<?php
class AuthController {
    private $db;
    private $max_attempts = 5;
    private $lockout_time = 30; // minutes
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function login() {
        // اگر کاربر قبلاً لاگین کرده است، به داشبورد هدایت شود
        if (isset($_SESSION['user_id'])) {
            redirect('dashboard');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
            $password = $_POST['password'] ?? '';
            
            if (empty($username) || empty($password)) {
                set_flash_message('error', 'لطفاً نام کاربری و رمز عبور را وارد کنید');
                redirect('login');
                return;
            }

            try {
                // پاک کردن تلاش‌های قدیمی
                $this->cleanOldAttempts();
                
                // بررسی تعداد تلاش‌های ناموفق
                $attempts = $this->getLoginAttempts($username);
                
                if ($attempts >= $this->max_attempts) {
                    set_flash_message('error', "حساب کاربری شما به دلیل تلاش‌های ناموفق مکرر به مدت {$this->lockout_time} دقیقه مسدود شده است");
                    redirect('login');
                    return;
                }

                // بررسی اعتبار کاربر
                $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ? AND status = 'active' LIMIT 1");
                $stmt->execute([$username]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user && password_verify($password, $user['password'])) {
                    // پاک کردن تلاش‌های ناموفق
                    $this->clearLoginAttempts($username);

                    // بروزرسانی آخرین زمان ورود
                    $stmt = $this->db->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
                    $stmt->execute([$user['id']]);

                    // ذخیره اطلاعات در سشن
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['name'];
                    $_SESSION['user_role'] = $user['role'];
                    $_SESSION['user_email'] = $user['email'];

                    // ثبت لاگ ورود موفق
                    $this->logAction($user['id'], 'login', 'success');

                    set_flash_message('success', 'خوش آمدید ' . $user['name']);
                    redirect('dashboard');
                    return;
                }

                // ثبت تلاش ناموفق
                $this->recordLoginAttempt($username);
                
                // ثبت لاگ ناموفق
                if ($user) {
                    $this->logAction($user['id'], 'login', 'failed');
                }

                $remaining_attempts = $this->max_attempts - $this->getLoginAttempts($username);
                set_flash_message('error', "نام کاربری یا رمز عبور اشتباه است. {$remaining_attempts} تلاش دیگر باقی مانده است");
                redirect('login');
                return;

            } catch (PDOException $e) {
                error_log("Login error: " . $e->getMessage());
                set_flash_message('error', 'خطایی در سیستم رخ داده است. لطفاً بعداً تلاش کنید');
                redirect('login');
                return;
            }
        }

        // نمایش فرم ورود
        require_once 'views/auth/login.php';
    }

    public function logout() {
        if (isset($_SESSION['user_id'])) {
            // ثبت لاگ خروج
            $this->logAction($_SESSION['user_id'], 'logout', 'success');
        }

        // پاکسازی و نابودی سشن
        $_SESSION = array();
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time()-42000, '/');
        }
        session_destroy();

        set_flash_message('success', 'شما با موفقیت از سیستم خارج شدید');
        redirect('login');
    }

    private function getLoginAttempts($username) {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM login_attempts 
             WHERE username = ? AND attempt_time > DATE_SUB(NOW(), INTERVAL ? MINUTE)"
        );
        $stmt->execute([$username, $this->lockout_time]);
        return $stmt->fetchColumn();
    }

    private function recordLoginAttempt($username) {
        $stmt = $this->db->prepare(
            "INSERT INTO login_attempts (username, attempt_time) VALUES (?, NOW())"
        );
        $stmt->execute([$username]);
    }

    private function clearLoginAttempts($username) {
        $stmt = $this->db->prepare("DELETE FROM login_attempts WHERE username = ?");
        $stmt->execute([$username]);
    }

    private function cleanOldAttempts() {
        $stmt = $this->db->prepare(
            "DELETE FROM login_attempts WHERE attempt_time < DATE_SUB(NOW(), INTERVAL ? MINUTE)"
        );
        $stmt->execute([$this->lockout_time]);
    }

    private function logAction($user_id, $action, $status) {
        try {
            $stmt = $this->db->prepare(
                "INSERT INTO system_logs (user_id, action_type, entity_type, ip_address, user_agent, created_at) 
                 VALUES (?, ?, ?, ?, ?, NOW())"
            );
            $stmt->execute([
                $user_id,
                $status === 'success' ? $action : 'failed_' . $action,
                'auth',
                $_SERVER['REMOTE_ADDR'],
                $_SERVER['HTTP_USER_AGENT']
            ]);
        } catch (PDOException $e) {
            error_log("Error logging action: " . $e->getMessage());
        }
    }
}