<?php
class AdminController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function categories() {
        if (!is_admin()) {
            set_flash_message('error', 'شما دسترسی لازم را ندارید');
            redirect('dashboard');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token()) {
                set_flash_message('error', 'توکن CSRF نامعتبر است');
                redirect('admin/categories');
                return;
            }
            
            $action = $_POST['action'] ?? '';
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            
            try {
                switch ($action) {
                    case 'add':
                        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
                        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
                        
                        if (!$name) {
                            throw new Exception('نام دسته‌بندی الزامی است');
                        }
                        
                        $stmt = $this->db->prepare("INSERT INTO error_categories (name, description, created_at) VALUES (?, ?, NOW())");
                        $stmt->execute([$name, $description]);
                        set_flash_message('success', 'دسته‌بندی با موفقیت افزوده شد');
                        break;
                        
                    case 'edit':
                        if (!$id) {
                            throw new Exception('دسته‌بندی نامعتبر است');
                        }
                        
                        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
                        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
                        
                        if (!$name) {
                            throw new Exception('نام دسته‌بندی الزامی است');
                        }
                        
                        $stmt = $this->db->prepare("UPDATE error_categories SET name = ?, description = ?, updated_at = NOW() WHERE id = ?");
                        $stmt->execute([$name, $description, $id]);
                        set_flash_message('success', 'دسته‌بندی با موفقیت ویرایش شد');
                        break;
                        
                    case 'delete':
                        if (!$id) {
                            throw new Exception('دسته‌بندی نامعتبر است');
                        }
                        
                        // بررسی استفاده از دسته‌بندی
                        $stmt = $this->db->prepare("SELECT COUNT(*) FROM locomotive_errors WHERE category = ?");
                        $stmt->execute([$id]);
                        if ($stmt->fetchColumn() > 0) {
                            throw new Exception('این دسته‌بندی در حال استفاده است و قابل حذف نیست');
                        }
                        
                        $stmt = $this->db->prepare("DELETE FROM error_categories WHERE id = ?");
                        $stmt->execute([$id]);
                        set_flash_message('success', 'دسته‌بندی با موفقیت حذف شد');
                        break;
                }
            } catch (Exception $e) {
                set_flash_message('error', $e->getMessage());
            }
            
            redirect('admin/categories');
            return;
        }
        
        // دریافت لیست دسته‌بندی‌ها
        $categories = $this->db->query("SELECT * FROM error_categories ORDER BY name")->fetchAll();
        require_once 'views/admin/categories.php';
    }
    
    public function locomotives() {
        if (!is_admin()) {
            set_flash_message('error', 'شما دسترسی لازم را ندارید');
            redirect('dashboard');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token()) {
                set_flash_message('error', 'توکن CSRF نامعتبر است');
                redirect('admin/locomotives');
                return;
            }
            
            $action = $_POST['action'] ?? '';
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            
            try {
                switch ($action) {
                    case 'add':
                        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
                        $model = filter_input(INPUT_POST, 'model', FILTER_SANITIZE_STRING);
                        $manufacturer = filter_input(INPUT_POST, 'manufacturer', FILTER_SANITIZE_STRING);
                        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
                        
                        if (!$name || !$model || !$manufacturer) {
                            throw new Exception('نام، مدل و سازنده الزامی هستند');
                        }
                        
                        $stmt = $this->db->prepare("INSERT INTO locomotive_types (name, model, manufacturer, description, created_at) VALUES (?, ?, ?, ?, NOW())");
                        $stmt->execute([$name, $model, $manufacturer, $description]);
                        set_flash_message('success', 'نوع لوکوموتیو با موفقیت افزوده شد');
                        break;
                        
                    case 'edit':
                        if (!$id) {
                            throw new Exception('نوع لوکوموتیو نامعتبر است');
                        }
                        
                        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
                        $model = filter_input(INPUT_POST, 'model', FILTER_SANITIZE_STRING);
                        $manufacturer = filter_input(INPUT_POST, 'manufacturer', FILTER_SANITIZE_STRING);
                        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
                        
                        if (!$name || !$model || !$manufacturer) {
                            throw new Exception('نام، مدل و سازنده الزامی هستند');
                        }
                        
                        $stmt = $this->db->prepare("UPDATE locomotive_types SET name = ?, model = ?, manufacturer = ?, description = ?, updated_at = NOW() WHERE id = ?");
                        $stmt->execute([$name, $model, $manufacturer, $description, $id]);
                        set_flash_message('success', 'نوع لوکوموتیو با موفقیت ویرایش شد');
                        break;
                        
                    case 'delete':
                        if (!$id) {
                            throw new Exception('نوع لوکوموتیو نامعتبر است');
                        }
                        
                        // بررسی استفاده از نوع لوکوموتیو
                        $stmt = $this->db->prepare("SELECT COUNT(*) FROM locomotive_errors WHERE locomotive_type = ?");
                        $stmt->execute([$id]);
                        if ($stmt->fetchColumn() > 0) {
                            throw new Exception('این نوع لوکوموتیو در حال استفاده است و قابل حذف نیست');
                        }
                        
                        $stmt = $this->db->prepare("DELETE FROM locomotive_types WHERE id = ?");
                        $stmt->execute([$id]);
                        set_flash_message('success', 'نوع لوکوموتیو با موفقیت حذف شد');
                        break;
                }
            } catch (Exception $e) {
                set_flash_message('error', $e->getMessage());
            }
            
            redirect('admin/locomotives');
            return;
        }
        
        // دریافت لیست انواع لوکوموتیو
    $locomotive_types = $this->db->query("SELECT * FROM locomotive_types ORDER BY name")->fetchAll();
        require_once 'views/admin/locomotives.php';
    }
}