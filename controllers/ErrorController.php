<?php
class ErrorController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function index() {
        // دریافت پارامترهای فیلتر
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $per_page = 20;
        $search = $_GET['search'] ?? '';
        $category = $_GET['category'] ?? '';
        $severity = $_GET['severity'] ?? '';
        $locomotive_type = $_GET['locomotive_type'] ?? '';
        
        // ساخت کوئری
        $where = [];
        $params = [];
        
        if ($search) {
            $where[] = "(error_code LIKE ? OR description LIKE ? OR solution LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }
        
        if ($category) {
            $where[] = "category = ?";
            $params[] = $category;
        }
        
        if ($severity) {
            $where[] = "severity = ?";
            $params[] = $severity;
        }
        
        if ($locomotive_type) {
            $where[] = "locomotive_type = ?";
            $params[] = $locomotive_type;
        }
        
        $where_clause = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";
        
        // دریافت تعداد کل رکوردها
        $count_sql = "SELECT COUNT(*) FROM locomotive_errors $where_clause";
        $stmt = $this->db->prepare($count_sql);
        $stmt->execute($params);
        $total_records = $stmt->fetchColumn();
        
        // محاسبه تعداد صفحات
        $total_pages = ceil($total_records / $per_page);
        $offset = ($page - 1) * $per_page;
        
        // دریافت خطاها
        $sql = "SELECT * FROM locomotive_errors $where_clause ORDER BY created_at DESC LIMIT ? OFFSET ?";
        $stmt = $this->db->prepare($sql);
        $params[] = $per_page;
        $params[] = $offset;
        $stmt->execute($params);
        $errors = $stmt->fetchAll();
        
        // دریافت دسته‌بندی‌ها و انواع لوکوموتیو برای فیلتر
        $categories = $this->db->query("SELECT * FROM error_categories ORDER BY name")->fetchAll();
        $locomotive_types = $this->db->query("SELECT * FROM locomotive_types ORDER BY name")->fetchAll();
        
        require_once 'views/errors/index.php';
    }
    
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $this->db->beginTransaction();
                
                // بررسی اعتبار داده‌ها
                $error_code = filter_input(INPUT_POST, 'error_code', FILTER_SANITIZE_STRING);
                $severity = filter_input(INPUT_POST, 'severity', FILTER_SANITIZE_STRING);
                $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
                $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);
                $locomotive_type = filter_input(INPUT_POST, 'locomotive_type', FILTER_SANITIZE_STRING);
                $component = filter_input(INPUT_POST, 'component', FILTER_SANITIZE_STRING);
                
                if (!$error_code || !$severity || !$description || !$category || !$locomotive_type || !$component) {
                    throw new Exception('لطفاً تمام فیلدهای الزامی را پر کنید.');
                }
                
                // درج خطا
                $sql = "INSERT INTO locomotive_errors (
                    error_code, severity, description, category, locomotive_type, component,
                    sub_component, symptoms, cause, diagnosis_steps, solution_steps,
                    required_tools, required_parts, estimated_repair_time, safety_notes,
                    created_by, created_at
                ) VALUES (
                    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW()
                )";
                
                $stmt = $this->db->prepare($sql);
                $stmt->execute([
                    $error_code, $severity, $description, $category, $locomotive_type,
                    $component, $_POST['sub_component'] ?? null, $_POST['symptoms'] ?? null,
                    $_POST['cause'] ?? null, $_POST['diagnosis_steps'] ?? null,
                    $_POST['solution_steps'] ?? null, $_POST['required_tools'] ?? null,
                    $_POST['required_parts'] ?? null, $_POST['estimated_repair_time'] ?? null,
                    $_POST['safety_notes'] ?? null, $_SESSION['user_id']
                ]);
                
                $error_id = $this->db->lastInsertId();
                
                // ثبت لاگ
                $this->logAction('create', 'locomotive_error', $error_id, null, [
                    'error_code' => $error_code,
                    'description' => $description
                ]);
                
                $this->db->commit();
                set_flash_message('success', 'خطای جدید با موفقیت ثبت شد.');
                redirect('errors');
                
            } catch (Exception $e) {
                $this->db->rollBack();
                set_flash_message('error', $e->getMessage());
                redirect('errors/create');
            }
        }
        
        // دریافت دسته‌بندی‌ها و انواع لوکوموتیو
        $categories = $this->db->query("SELECT * FROM error_categories ORDER BY name")->fetchAll();
        $locomotive_types = $this->db->query("SELECT * FROM locomotive_types ORDER BY name")->fetchAll();
        
        require_once 'views/errors/create.php';
    }
    
    public function view($id) {
        $sql = "SELECT e.*, u.name as created_by_name, 
                       uc.name as updated_by_name
                FROM locomotive_errors e
                LEFT JOIN users u ON e.created_by = u.id
                LEFT JOIN users uc ON e.updated_by = uc.id
                WHERE e.id = ?";
                
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $error = $stmt->fetch();
        
        if (!$error) {
            set_flash_message('error', 'خطای مورد نظر یافت نشد.');
            redirect('errors');
        }
        
        // ثبت لاگ بازدید
        $this->logAction('view', 'locomotive_error', $id);
        
        require_once 'views/errors/view.php';
    }
    
    private function logAction($action_type, $entity_type, $entity_id, $old_data = null, $new_data = null) {
        $sql = "INSERT INTO system_logs (
            user_id, action_type, entity_type, entity_id, old_data, new_data,
            ip_address, user_agent, created_at
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $_SESSION['user_id'],
            $action_type,
            $entity_type,
            $entity_id,
            $old_data ? json_encode($old_data) : null,
            $new_data ? json_encode($new_data) : null,
            $_SERVER['REMOTE_ADDR'],
            $_SERVER['HTTP_USER_AGENT']
        ]);
    }
    public function edit($id) {
    if (!$id) {
        set_flash_message('error', 'شناسه خطا نامعتبر است');
        redirect('errors');
        return;
    }

    // در حالت POST، ذخیره تغییرات
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $this->db->beginTransaction();
            
            // اعتبارسنجی داده‌ها
            $error_code = filter_input(INPUT_POST, 'error_code', FILTER_SANITIZE_STRING);
            $severity = filter_input(INPUT_POST, 'severity', FILTER_SANITIZE_STRING);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
            $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);
            $locomotive_type = filter_input(INPUT_POST, 'locomotive_type', FILTER_SANITIZE_STRING);
            $component = filter_input(INPUT_POST, 'component', FILTER_SANITIZE_STRING);
            
            if (!$error_code || !$severity || !$description || !$category || !$locomotive_type || !$component) {
                throw new Exception('لطفاً تمام فیلدهای الزامی را پر کنید.');
            }
            
            // دریافت داده‌های قبلی برای لاگ
            $stmt = $this->db->prepare("SELECT * FROM locomotive_errors WHERE id = ?");
            $stmt->execute([$id]);
            $old_data = $stmt->fetch();

            if (!$old_data) {
                throw new Exception('خطای مورد نظر یافت نشد.');
            }
            
            // بروزرسانی خطا
            $sql = "UPDATE locomotive_errors SET 
                error_code = ?, 
                severity = ?, 
                description = ?, 
                category = ?, 
                locomotive_type = ?, 
                component = ?,
                sub_component = ?,
                symptoms = ?,
                cause = ?,
                diagnosis_steps = ?,
                solution_steps = ?,
                solution = ?,
                required_tools = ?,
                required_parts = ?,
                estimated_repair_time = ?,
                safety_notes = ?,
                updated_by = ?,
                updated_at = NOW()
                WHERE id = ?";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                $error_code,
                $severity,
                $description,
                $category,
                $locomotive_type,
                $component,
                $_POST['sub_component'] ?? null,
                $_POST['symptoms'] ?? null,
                $_POST['cause'] ?? null,
                $_POST['diagnosis_steps'] ?? null,
                $_POST['solution_steps'] ?? null,
                $_POST['solution'] ?? null,
                $_POST['required_tools'] ?? null,
                $_POST['required_parts'] ?? null,
                $_POST['estimated_repair_time'] ?? null,
                $_POST['safety_notes'] ?? null,
                $_SESSION['user_id'],
                $id
            ]);

            // ثبت لاگ
            $this->logAction('edit', 'locomotive_error', $id, $old_data, [
                'error_code' => $error_code,
                'description' => $description,
                'updated_by' => $_SESSION['user_id']
            ]);

            $this->db->commit();
            set_flash_message('success', 'خطا با موفقیت ویرایش شد.');
            redirect('errors');
            
        } catch (Exception $e) {
            $this->db->rollBack();
            set_flash_message('error', $e->getMessage());
            redirect("errors/edit/$id");
        }
        return;
    }

    // حالت GET - نمایش فرم ویرایش
    $sql = "SELECT e.*, u.name as created_by_name, 
                   uc.name as updated_by_name
            FROM locomotive_errors e
            LEFT JOIN users u ON e.created_by = u.id
            LEFT JOIN users uc ON e.updated_by = uc.id
            WHERE e.id = ?";
            
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$id]);
    $error = $stmt->fetch();

    if (!$error) {
        set_flash_message('error', 'خطای مورد نظر یافت نشد.');
        redirect('errors');
        return;
    }

    // دریافت لیست دسته‌بندی‌ها و انواع لوکوموتیو
    $categories = $this->db->query("SELECT * FROM error_categories ORDER BY name")->fetchAll();
    $locomotive_types = $this->db->query("SELECT * FROM locomotive_types ORDER BY name")->fetchAll();

    require_once 'views/errors/edit.php';
}
}