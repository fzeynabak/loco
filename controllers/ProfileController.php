<?php
class ProfileController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function index() {
        if (!is_authenticated()) {
            redirect('login');
            return;
        }

        try {
            // دریافت اطلاعات کاربر
            $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$_SESSION['user_id']]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$user) {
                set_flash_message('error', 'کاربر یافت نشد');
                redirect('dashboard');
                return;
            }
            
            // نمایش صفحه پروفایل بر اساس نقش کاربر
            if ($user['role'] === 'admin') {
                require_once 'views/users/profile.php';
            } else {
                require_once 'views/profile/index.php';
            }
            
        } catch (PDOException $e) {
            error_log("Error in profile page: " . $e->getMessage());
            set_flash_message('error', 'خطایی در بازیابی اطلاعات رخ داد');
            redirect('dashboard');
        }
    }

    public function update() {
        if (!is_authenticated()) {
            redirect('login');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('profile');
            return;
        }

        if (!verify_csrf_token()) {
            set_flash_message('error', 'توکن CSRF نامعتبر است');
            redirect('profile');
            return;
        }

        try {
            $id = $_SESSION['user_id'];
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $mobile = filter_input(INPUT_POST, 'mobile', FILTER_SANITIZE_STRING);
            $personnel_number = filter_input(INPUT_POST, 'personnel_number', FILTER_SANITIZE_STRING);
            $national_code = filter_input(INPUT_POST, 'national_code', FILTER_SANITIZE_STRING);
            $province = filter_input(INPUT_POST, 'province', FILTER_SANITIZE_STRING);
            $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
            $station = filter_input(INPUT_POST, 'station', FILTER_SANITIZE_STRING);

            // Validation
            if (empty($name) || empty($email)) {
                throw new Exception('فیلدهای الزامی را پر کنید');
            }

            // Update user information
            $sql = "UPDATE users SET 
                    name = ?, 
                    email = ?, 
                    mobile = ?,
                    personnel_number = ?,
                    national_code = ?,
                    province = ?,
                    city = ?,
                    station = ?,
                    updated_at = NOW() 
                    WHERE id = ?";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                $name,
                $email,
                $mobile,
                $personnel_number,
                $national_code,
                $province,
                $city,
                $station,
                $id
            ]);

            // اگر رمز عبور جدید وارد شده باشد
            $current_password = $_POST['current_password'] ?? '';
            $new_password = $_POST['new_password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            if (!empty($new_password)) {
                if (empty($current_password)) {
                    throw new Exception('برای تغییر رمز عبور، ابتدا رمز فعلی را وارد کنید');
                }

                // بررسی رمز عبور فعلی
                $stmt = $this->db->prepare("SELECT password FROM users WHERE id = ?");
                $stmt->execute([$id]);
                $user = $stmt->fetch();

                if (!password_verify($current_password, $user['password'])) {
                    throw new Exception('رمز عبور فعلی اشتباه است');
                }

                if ($new_password !== $confirm_password) {
                    throw new Exception('رمز عبور جدید و تکرار آن مطابقت ندارند');
                }

                // بروزرسانی رمز عبور
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE id = ?");
                $stmt->execute([$hashed_password, $id]);
            }

            set_flash_message('success', 'اطلاعات با موفقیت بروزرسانی شد');
            
        } catch (Exception $e) {
            set_flash_message('error', $e->getMessage());
        }

        redirect('profile');
    }
}