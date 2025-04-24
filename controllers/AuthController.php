<?php

class AuthController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function login() {
        // اگر کاربر قبلاً لاگین کرده است، به داشبورد هدایت شود
        if (isset($_SESSION['user_id'])) {
            redirect('dashboard');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
            $password = $_POST['password'];
            
            // بررسی خالی نبودن فیلدها
            if (empty($username) || empty($password)) {
                set_flash_message('error', 'لطفاً نام کاربری و رمز عبور را وارد کنید');
                redirect('login');
                return;
            }

            try {
                // بررسی تعداد تلاش‌های ناموفق
                $stmt = $this->db->prepare("SELECT COUNT(*) FROM login_attempts WHERE username = ? AND attempt_time > DATE_SUB(NOW(), INTERVAL 30 MINUTE)");
                $stmt->execute([$username]);
                $attempts = $stmt->fetchColumn();

                if ($attempts >= 5) {
                    set_flash_message('error', 'حساب کاربری شما به دلیل تلاش‌های ناموفق مکرر به مدت 30 دقیقه مسدود شده است');
                    redirect('login');
                    return;
                }

                // بررسی اعتبار کاربر
                $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ? AND status = 'active' LIMIT 1");
                $stmt->execute([$username]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user && password_verify($password, $user['password'])) {
                    // پاک کردن تلاش‌های ناموفق قبلی
                    $stmt = $this->db->prepare("DELETE FROM login_attempts WHERE username = ?");
                    $stmt->execute([$username]);

                    // بروزرسانی آخرین زمان ورود
                    $stmt = $this->db->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
                    $stmt->execute([$user['id']]);

                    // ذخیره اطلاعات در سشن
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['name'];
                    $_SESSION['user_role'] = $user['role'];
                    $_SESSION['user_email'] = $user['email'];

                    // ثبت لاگ ورود
                    $this->logLogin($user['id'], true);

                    set_flash_message('success', 'خوش آمدید ' . $user['name']);
                    redirect('dashboard');
                    return;
                }

                // ثبت تلاش ناموفق
                $stmt = $this->db->prepare("INSERT INTO login_attempts (username, attempt_time) VALUES (?, NOW())");
                $stmt->execute([$username]);

                // ثبت لاگ تلاش ناموفق
                if ($user) {
                    $this->logLogin($user['id'], false);
                }

                set_flash_message('error', 'نام کاربری یا رمز عبور اشتباه است');
                redirect('login');
                return;

            } catch (PDOException $e) {
                error_log("خطا در ورود: " . $e->getMessage());
                set_flash_message('error', 'خطایی در سیستم رخ داده است. لطفاً بعداً تلاش کنید');
                redirect('login');
                return;
            }
        }

        // نمایش فرم ورود
        require_once 'views/auth/login.php';
    }

    private function logLogin($user_id, $success) {
        try {
            $stmt = $this->db->prepare(
                "INSERT INTO system_logs (user_id, action_type, entity_type, ip_address, user_agent, created_at) 
                 VALUES (?, ?, 'auth', ?, ?, NOW())"
            );
            $stmt->execute([
                $user_id,
                $success ? 'login' : 'failed_login',
                $_SERVER['REMOTE_ADDR'],
                $_SERVER['HTTP_USER_AGENT']
            ]);
        } catch (PDOException $e) {
            error_log("خطا در ثبت لاگ ورود: " . $e->getMessage());
        }
    }

    public function logout() {
        if (isset($_SESSION['user_id'])) {
            try {
                // ثبت لاگ خروج
                $stmt = $this->db->prepare(
                    "INSERT INTO system_logs (user_id, action_type, entity_type, ip_address, user_agent, created_at) 
                     VALUES (?, 'logout', 'auth', ?, ?, NOW())"
                );
                $stmt->execute([
                    $_SESSION['user_id'],
                    $_SERVER['REMOTE_ADDR'],
                    $_SERVER['HTTP_USER_AGENT']
                ]);
            } catch (PDOException $e) {
                error_log("خطا در ثبت لاگ خروج: " . $e->getMessage());
            }
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
}