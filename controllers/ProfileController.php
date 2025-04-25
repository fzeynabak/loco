<?php
require_once 'assets/plugins/jdf.php';

class ProfileController extends Controller {
    public function update() {
        if (!$this->validateCSRF()) {
            $this->redirect('/error/csrf');
            return;
        }

        $user_id = $_SESSION['user_id'];
        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'mobile' => $_POST['mobile'],
            'national_code' => $_POST['national_code'],
            'personnel_number' => $_POST['personnel_number'],
            'province' => $_POST['province'],
            'city' => $_POST['city'],
            'railway_station' => $_POST['railway_station'],
            'address' => $_POST['address'],
            'updated_at' => jdate('Y-m-d H:i:s')
        ];

        // اعتبارسنجی داده‌ها
        require_once 'includes/Validator.php';
        $validator = new Validator();

        $errors = [];
        
        if (!$validator->validateMobile($data['mobile'])) {
            $errors[] = 'شماره موبایل معتبر نیست. شماره باید با 09 شروع شود و 11 رقم باشد.';
        }

        if (!$validator->validateNationalCode($data['national_code'])) {
            $errors[] = 'کد ملی وارد شده معتبر نیست.';
        }

        if (!$validator->validatePersonnelNumber($data['personnel_number'])) {
            $errors[] = 'شماره پرسنلی باید بین 5 تا 10 رقم باشد.';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $this->redirect('/profile');
            return;
        }

        // آپدیت پروفایل
        try {
            $this->db->beginTransaction();

            $sql = "UPDATE users SET 
                    name = :name,
                    email = :email, 
                    mobile = :mobile,
                    national_code = :national_code,
                    personnel_number = :personnel_number,
                    province = :province,
                    city = :city,
                    railway_station = :railway_station,
                    address = :address,
                    updated_at = :updated_at
                    WHERE id = :id";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(array_merge($data, ['id' => $user_id]));

            $this->db->commit();
            $_SESSION['success'] = 'اطلاعات پروفایل با موفقیت به‌روزرسانی شد.';

        } catch (PDOException $e) {
            $this->db->rollBack();
            $_SESSION['error'] = 'خطا در به‌روزرسانی اطلاعات. لطفاً دوباره تلاش کنید.';
            error_log($e->getMessage());
        }

        $this->redirect('/profile');
    }
}