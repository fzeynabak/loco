#!/bin/bash  

# ساخت دایرکتوری‌ها  
mkdir -p config  
mkdir -p controllers  
mkdir -p models  
mkdir -p views/auth  
mkdir -p views/admin  
mkdir -p views/errors  
mkdir -p views/users  
mkdir -p views/layouts  
mkdir -p assets/css  
mkdir -p assets/js  
mkdir -p includes  

# ایجاد فایل‌ها  
touch config/config.php  
touch config/database.php  

touch controllers/AuthController.php  
touch controllers/ErrorController.php  
touch controllers/UserController.php  
touch controllers/AdminController.php  

touch models/User.php  
touch models/Error.php  
touch models/Role.php  

touch views/auth/login.php  
touch views/auth/register.php  

touch views/admin/dashboard.php  
touch views/admin/users.php  
touch views/admin/roles.php  

touch views/errors/add.php  
touch views/errors/list.php  
touch views/errors/search.php  

touch views/users/dashboard.php  
touch views/users/profile.php  

touch views/layouts/main.php  
touch views/layouts/footer.php  
touch views/layouts/admin-header.php  

touch assets/css/style.css  
touch assets/js/main.js  

touch includes/functions.php  
touch includes/database.php  
touch includes/auth.php  

touch index.php  
touch .htaccess  

echo "ساختار پروژه با موفقیت ایجاد شد."  