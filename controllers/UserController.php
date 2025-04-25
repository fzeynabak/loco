<?php
class UserController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function index() {
        if (!is_admin()) {
            set_flash_message('error', 'شما دسترسی لازم را ندارید');
            redirect('dashboard');
            return;
        }
        
        try {
            $stmt = $this->db->query(
                "SELECT u.*, GROUP_CONCAT(p.permission_name) as permissions 
                 FROM users u 
                 LEFT JOIN user_permissions up ON u.id = up.user_id 
                 LEFT JOIN permissions p ON up.permission_id = p.id 
                 GROUP BY u.id"
            );
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            require_once 'views/users/index.php';
        } catch (PDOException $e) {
            error_log("Error fetching users: " . $e->getMessage());
            set_flash_message('error', 'خطایی در بازیابی اطلاعات کاربران رخ داد');
            redirect('dashboard');
        }
    }
    
    public function updatePermissions() {
        if (!is_admin()) {
            set_flash_message('error', 'شما دسترسی لازم را ندارید');
            redirect('users');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('users');
            return;
        }
        
        if (!verify_csrf_token()) {
            set_flash_message('error', 'توکن CSRF نامعتبر است');
            redirect('users');
            return;
        }
        
        $user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
        $permissions = $_POST['permissions'] ?? [];
        
        try {
            $this->db->beginTransaction();
            
            // حذف دسترسی‌های قبلی
            $stmt = $this->db->prepare("DELETE FROM user_permissions WHERE user_id = ?");
            $stmt->execute([$user_id]);
            
            // اضافه کردن دسترسی‌های جدید
            if (!empty($permissions)) {
                $stmt = $this->db->prepare(
                    "INSERT INTO user_permissions (user_id, permission_id) 
                     SELECT ?, id FROM permissions WHERE permission_name IN (" . 
                     str_repeat('?,', count($permissions) - 1) . '?)'
                );
                $stmt->execute(array_merge([$user_id], $permissions));
            }
            
            $this->db->commit();
            set_flash_message('success', 'دسترسی‌های کاربر با موفقیت بروزرسانی شد');
            
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Error updating permissions: " . $e->getMessage());
            set_flash_message('error', 'خطایی در بروزرسانی دسترسی‌ها رخ داد');
        }
        
        redirect('users');
    }
        public function toggleStatus() {
        if (!is_admin()) {
            set_flash_message('error', 'شما دسترسی لازم را ندارید');
            redirect('users');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('users');
            return;
        }
        
        if (!verify_csrf_token()) {
            set_flash_message('error', 'توکن CSRF نامعتبر است');
            redirect('users');
            return;
        }
        
        $user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
        
        try {
            // بررسی وجود کاربر و عدم تغییر وضعیت مدیر
            $stmt = $this->db->prepare("SELECT role, status FROM users WHERE id = ?");
            $stmt->execute([$user_id]);
            $user = $stmt->fetch();
            
            if (!$user) {
                throw new Exception('کاربر مورد نظر یافت نشد');
            }
            
            if ($user['role'] === 'admin') {
                throw new Exception('امکان تغییر وضعیت مدیر سیستم وجود ندارد');
            }
            
            // تغییر وضعیت
            $new_status = $user['status'] === 'active' ? 'inactive' : 'active';
            $stmt = $this->db->prepare("UPDATE users SET status = ? WHERE id = ?");
            $stmt->execute([$new_status, $user_id]);
            
            set_flash_message('success', 'وضعیت کاربر با موفقیت تغییر کرد');
            
        } catch (Exception $e) {
            error_log("Error toggling user status: " . $e->getMessage());
            set_flash_message('error', $e->getMessage());
        }
        
        redirect('users');
    }
}