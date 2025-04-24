<?php
require_once __DIR__ . '/../includes/database.php';

class AuthController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
            $password = $_POST['password'];
            
            if (empty($username) || empty($password)) {
                set_flash_message('error', 'تمام فیلدها الزامی هستند');
                redirect('login');
                return;
            }
            
            try {
                $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ? AND status = 'active' LIMIT 1");
                $stmt->execute([$username]);
                $user = $stmt->fetch();
                
                if ($user && password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_role'] = $user['role'];
                    $_SESSION['user_name'] = $user['name'];
                    
                    session_regenerate_id(true);
                    redirect('dashboard');
                    return;
                } else {
                    set_flash_message('error', 'نام کاربری یا رمز عبور اشتباه است');
                    redirect('login');
                    return;
                }
            } catch (PDOException $e) {
                error_log($e->getMessage());
                set_flash_message('error', 'خطا در ورود به سیستم. لطفاً دوباره تلاش کنید');
                redirect('login');
                return;
            }
        }
        
        // نمایش فرم ورود
        require_once 'views/auth/login.php';
    }
    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];
            
            // اعتبارسنجی
            if (empty($name) || empty($username) || empty($email) || empty($password)) {
                set_flash_message('error', 'تمام فیلدها الزامی هستند');
                redirect('register');
                return;
            }
            
            if ($password !== $password_confirm) {
                set_flash_message('error', 'رمز عبور و تکرار آن یکسان نیستند');
                redirect('register');
                return;
            }
            
            try {
                // بررسی تکراری نبودن نام کاربری و ایمیل
                $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE username = ? OR email = ?");
                $stmt->execute([$username, $email]);
                if ($stmt->fetchColumn() > 0) {
                    set_flash_message('error', 'نام کاربری یا ایمیل قبلاً ثبت شده است');
                    redirect('register');
                    return;
                }
                
                // ایجاد کاربر جدید
                $stmt = $this->db->prepare("INSERT INTO users (name, username, email, password, role, status, created_at) VALUES (?, ?, ?, ?, 'user', 'pending', NOW())");
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                if ($stmt->execute([$name, $username, $email, $hashed_password])) {
                    set_flash_message('success', 'ثبت نام شما با موفقیت انجام شد. لطفاً منتظر تأیید مدیر بمانید');
                    redirect('login');
                    return;
                } else {
                    set_flash_message('error', 'خطا در ثبت نام. لطفاً دوباره تلاش کنید');
                    redirect('register');
                    return;
                }
            } catch (PDOException $e) {
                error_log($e->getMessage());
                set_flash_message('error', 'خطا در ثبت نام. لطفاً دوباره تلاش کنید');
                redirect('register');
                return;
            }
        }
        
        // نمایش فرم ثبت نام
        require_once 'views/auth/register.php';
    }
}