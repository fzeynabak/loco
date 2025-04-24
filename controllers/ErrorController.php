<?php
class ErrorController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function index() {
        // Get search parameters
        $search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING);
        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?: 1;
        $limit = ITEMS_PER_PAGE;
        $offset = ($page - 1) * $limit;
        
        // Prepare query
        $where = "";
        $params = [];
        if ($search) {
            $where = "WHERE error_code LIKE ? OR description LIKE ? OR solution LIKE ?";
            $params = ["%$search%", "%$search%", "%$search%"];
        }
        
        // Get total count
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM locomotive_errors $where");
        $stmt->execute($params);
        $total = $stmt->fetchColumn();
        
        // Get errors
        $stmt = $this->db->prepare("SELECT * FROM locomotive_errors $where ORDER BY error_code LIMIT ? OFFSET ?");
        array_push($params, $limit, $offset);
        $stmt->execute($params);
        $errors = $stmt->fetchAll();
        
        // Calculate pagination
        $total_pages = ceil($total / $limit);
        
        require_once 'views/errors/list.php';
    }
    
    public function add() {
        if (!is_admin()) {
            set_flash_message('error', 'شما دسترسی لازم را ندارید');
            redirect('errors');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $error_code = filter_input(INPUT_POST, 'error_code', FILTER_SANITIZE_STRING);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
            $solution = filter_input(INPUT_POST, 'solution', FILTER_SANITIZE_STRING);
            $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);
            
            // Validation
            if (empty($error_code) || empty($description)) {
                set_flash_message('error', 'کد خطا و توضیحات الزامی هستند');
                redirect('errors/add');
            }
            
            // Check for duplicate error code
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM locomotive_errors WHERE error_code = ?");
            $stmt->execute([$error_code]);
            if ($stmt->fetchColumn() > 0) {
                set_flash_message('error', 'این کد خطا قبلاً ثبت شده است');
                redirect('errors/add');
            }
            
            // Insert error
            $stmt = $this->db->prepare("INSERT INTO locomotive_errors (error_code, description, solution, category, created_by, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
            if ($stmt->execute([$error_code, $description, $solution, $category, $_SESSION['user_id']])) {
                set_flash_message('success', 'خطای جدید با موفقیت ثبت شد');
                redirect('errors');
            } else {
                set_flash_message('error', 'خطا در ثبت اطلاعات');
                redirect('errors/add');
            }
        }
        
        require_once 'views/errors/add.php';
    }
    
    public function edit($id) {
        if (!is_admin()) {
            set_flash_message('error', 'شما دسترسی لازم را ندارید');
            redirect('errors');
        }
        
        $stmt = $this->db->prepare("SELECT * FROM locomotive_errors WHERE id = ?");
        $stmt->execute([$id]);
        $error = $stmt->fetch();
        
        if (!$error) {
            set_flash_message('error', 'خطای مورد نظر یافت نشد');
            redirect('errors');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
            $solution = filter_input(INPUT_POST, 'solution', FILTER_SANITIZE_STRING);
            $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);
            
            // Validation
            if (empty($description)) {
                set_flash_message('error', 'توضیحات الزامی است');
                redirect("errors/edit/$id");
            }
            
            // Update error
            $stmt = $this->db->prepare("UPDATE locomotive_errors SET description = ?, solution = ?, category = ?, updated_by = ?, updated_at = NOW() WHERE id = ?");
            if ($stmt->execute([$description, $solution, $category, $_SESSION['user_id'], $id])) {
                set_flash_message('success', 'اطلاعات خطا با موفقیت بروزرسانی شد');
                redirect('errors');
            } else {
                set_flash_message('error', 'خطا در بروزرسانی اطلاعات');
                redirect("errors/edit/$id");
            }
        }
        
        require_once 'views/errors/edit.php';
    }
    
    public function delete($id) {
        if (!is_admin()) {
            set_flash_message('error', 'شما دسترسی لازم را ندارید');
            redirect('errors');
        }
        
        $stmt = $this->db->prepare("DELETE FROM locomotive_errors WHERE id = ?");
        if ($stmt->execute([$id])) {
            set_flash_message('success', 'خطای مورد نظر با موفقیت حذف شد');
        } else {
            set_flash_message('error', 'خطا در حذف اطلاعات');
        }
        
        redirect('errors');
    }
}