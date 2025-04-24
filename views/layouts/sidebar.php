<?php
$current_route = $_GET['route'] ?? '';
?>
<div class="sidebar">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">منوی اصلی</h5>
        </div>
        <div class="list-group list-group-flush">
            <!-- داشبورد -->
            <a href="<?php echo BASE_URL; ?>/dashboard" 
               class="list-group-item list-group-item-action <?php echo $current_route == 'dashboard' ? 'active' : ''; ?>">
                <i class="bi bi-speedometer2 me-2"></i> داشبورد
            </a>

            <!-- مدیریت خطاها -->
            <div class="list-group-item list-group-item-action">
                <div class="d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#errorSubmenu">
                    <span><i class="bi bi-exclamation-triangle me-2"></i> مدیریت خطاها</span>
                    <i class="bi bi-chevron-down"></i>
                </div>
                <div class="collapse <?php echo str_starts_with($current_route, 'errors') ? 'show' : ''; ?>" id="errorSubmenu">
                    <div class="list-group mt-2">
                        <a href="<?php echo BASE_URL; ?>/errors" 
                           class="list-group-item list-group-item-action <?php echo $current_route == 'errors' ? 'active' : ''; ?>">
                            <i class="bi bi-list-ul me-2"></i> لیست خطاها
                        </a>
                        <?php if (is_admin() || has_permission('create_error')): ?>
                        <a href="<?php echo BASE_URL; ?>/errors/create" 
                           class="list-group-item list-group-item-action <?php echo $current_route == 'errors/create' ? 'active' : ''; ?>">
                            <i class="bi bi-plus-lg me-2"></i> افزودن خطای جدید
                        </a>
                        <?php endif; ?>
                        <a href="<?php echo BASE_URL; ?>/errors/search" 
                           class="list-group-item list-group-item-action <?php echo $current_route == 'errors/search' ? 'active' : ''; ?>">
                            <i class="bi bi-search me-2"></i> جستجوی پیشرفته
                        </a>
                        <a href="<?php echo BASE_URL; ?>/errors/categories" 
                           class="list-group-item list-group-item-action <?php echo $current_route == 'errors/categories' ? 'active' : ''; ?>">
                            <i class="bi bi-folder me-2"></i> دسته‌بندی خطاها
                        </a>
                    </div>
                </div>
            </div>

            <!-- مدیریت کاربران (فقط برای ادمین) -->
            <?php if (is_admin()): ?>
            <div class="list-group-item list-group-item-action">
                <div class="d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#userSubmenu">
                    <span><i class="bi bi-people me-2"></i> مدیریت کاربران</span>
                    <i class="bi bi-chevron-down"></i>
                </div>
                <div class="collapse <?php echo str_starts_with($current_route, 'users') ? 'show' : ''; ?>" id="userSubmenu">
                    <div class="list-group mt-2">
                        <a href="<?php echo BASE_URL; ?>/users" 
                           class="list-group-item list-group-item-action <?php echo $current_route == 'users' ? 'active' : ''; ?>">
                            <i class="bi bi-list-ul me-2"></i> لیست کاربران
                        </a>
                        <a href="<?php echo BASE_URL; ?>/users/create" 
                           class="list-group-item list-group-item-action <?php echo $current_route == 'users/create' ? 'active' : ''; ?>">
                            <i class="bi bi-person-plus me-2"></i> افزودن کاربر
                        </a>
                        <a href="<?php echo BASE_URL; ?>/users/pending" 
                           class="list-group-item list-group-item-action <?php echo $current_route == 'users/pending' ? 'active' : ''; ?>">
                            <i class="bi bi-clock-history me-2"></i> کاربران در انتظار تایید
                        </a>
                    </div>
                </div>
            </div>

            <!-- لاگ سیستم -->
            <div class="list-group-item list-group-item-action">
                <div class="d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#logSubmenu">
                    <span><i class="bi bi-journal-text me-2"></i> لاگ سیستم</span>
                    <i class="bi bi-chevron-down"></i>
                </div>
                <div class="collapse <?php echo str_starts_with($current_route, 'logs') ? 'show' : ''; ?>" id="logSubmenu">
                    <div class="list-group mt-2">
                        <a href="<?php echo BASE_URL; ?>/logs/system" 
                           class="list-group-item list-group-item-action <?php echo $current_route == 'logs/system' ? 'active' : ''; ?>">
                            <i class="bi bi-activity me-2"></i> لاگ فعالیت‌ها
                        </a>
                        <a href="<?php echo BASE_URL; ?>/logs/errors" 
                           class="list-group-item list-group-item-action <?php echo $current_route == 'logs/errors' ? 'active' : ''; ?>">
                            <i class="bi bi-bug me-2"></i> لاگ تغییرات خطاها
                        </a>
                        <a href="<?php echo BASE_URL; ?>/logs/login" 
                           class="list-group-item list-group-item-action <?php echo $current_route == 'logs/login' ? 'active' : ''; ?>">
                            <i class="bi bi-box-arrow-in-right me-2"></i> لاگ ورود و خروج
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- تنظیمات (فقط برای ادمین) -->
            <?php if (is_admin()): ?>
            <a href="<?php echo BASE_URL; ?>/settings" 
               class="list-group-item list-group-item-action <?php echo $current_route == 'settings' ? 'active' : ''; ?>">
                <i class="bi bi-gear me-2"></i> تنظیمات
            </a>
            <?php endif; ?>

            <!-- پروفایل -->
            <a href="<?php echo BASE_URL; ?>/profile" 
               class="list-group-item list-group-item-action <?php echo $current_route == 'profile' ? 'active' : ''; ?>">
                <i class="bi bi-person me-2"></i> پروفایل
            </a>

            <!-- خروج -->
            <a href="<?php echo BASE_URL; ?>/logout" 
               class="list-group-item list-group-item-action text-danger">
                <i class="bi bi-box-arrow-right me-2"></i> خروج
            </a>
        </div>
    </div>
</div>