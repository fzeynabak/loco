<?php
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
            }
            
            // Check login attempts
            if ($this->isAccountLocked($username)) {
                set_flash_message('error', 'حساب کاربری شما به دلیل تلاش‌های ناموفق قفل شده است. لطفاً بعداً تلاش کنید');
                redirect('login');
            }
            
            $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ? AND status = 'active' LIMIT 1");
            $stmt->execute([$username]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($password, $user['password'])) {
                // Reset login attempts
                $this->resetLoginAttempts($username);
                
                // Set session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['user_name'] = $user['name'];
                
                // Regenerate session ID for security
                session_regenerate_id(true);
                
                redirect('dashboard');
            } else {
                $this->incrementLoginAttempts($username);
                set_flash_message('error', 'نام کاربری یا رمز عبور اشتباه است');
                redirect('login');
            }
        }
        
        // Show login form
        require_once 'views/auth/login.php';
    }
    
    public function register() {
        // Check if registration is enabled
        $stmt = $this->db->prepare("SELECT value FROM settings WHERE key = 'registration_enabled' LIMIT 1");
        $stmt->execute();
        $setting = $stmt->fetch();
        
        if ($setting && $setting['value'] === '0') {
            set_flash_message('error', 'ثبت نام در حال حاضر غیرفعال است');
            redirect('login');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];
            
            // Validation
            if (empty($name) || empty($username) || empty($email) || empty($password)) {
                set_flash_message('error', 'تمام فیلدها الزامی هستند');
                redirect('register');
            }
            
            if ($password !== $password_confirm) {
                set_flash_message('error', 'رمز عبور و تکرار آن یکسان نیستند');
                redirect('register');
            }
            
            // Check username and email uniqueness
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$username, $email]);
            if ($stmt->fetchColumn() > 0) {
                set_flash_message('error', 'نام کاربری یا ایمیل قبلاً ثبت شده است');
                redirect('register');
            }
            
            // Create user
            $stmt = $this->db->prepare("INSERT INTO users (name, username, email, password, role, status, created_at) VALUES (?, ?, ?, ?, 'user', 'pending', NOW())");
            $hashed_password = password_hash($password, PASSWORD_DEFAULT, ['cost' => HASH_COST]);
            
            if ($stmt->execute([$name, $username, $email, $hashed_password])) {
                set_flash_message('success', 'ثبت نام شما با موفقیت انجام شد. لطفاً منتظر تأیید مدیر بمانید');
                redirect('login');
            } else {
                set_flash_message('error', 'خطا در ثبت نام. لطفاً دوباره تلاش کنید');
                redirect('register');
            }
        }
        
        // Show registration form
        require_once 'views/auth/register.php';
    }
    
    private function isAccountLocked($username) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM login_attempts WHERE username = ? AND attempt_time > DATE_SUB(NOW(), INTERVAL ? SECOND)");
        $stmt->execute([$username, LOCKOUT_TIME]);
        return $stmt->fetchColumn() >= ALLOWED_ATTEMPTS;
    }
    
    private function incrementLoginAttempts($username) {
        $stmt = $this->db->prepare("INSERT INTO login_attempts (username, attempt_time) VALUES (?, NOW())");
        $stmt->execute([$username]);
    }
    
    private function resetLoginAttempts($username) {
        $stmt = $this->db->prepare("DELETE FROM login_attempts WHERE username = ?");
        $stmt->execute([$username]);
    }
}