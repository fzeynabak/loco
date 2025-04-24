<div class="sidebar mb-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">منوی اصلی</h5>
        </div>
        <div class="list-group list-group-flush">
            <!-- داشبورد -->
            <a href="<?php echo BASE_URL; ?>/dashboard" 
               class="list-group-item list-group-item-action <?php echo $route == 'dashboard' ? 'active' : ''; ?>">
                <i class="bi bi-speedometer2 me-2"></i> داشبورد
            </a>

            <!-- مدیریت خطاها -->
            <div class="list-group-item">
                <div class="d-flex justify-content-between align-items-center" 
                     data-bs-toggle="collapse" href="#errorSubmenu" role="button">
                    <span><i class="bi bi-exclamation-triangle me-2"></i> مدیریت خطاها</span>
                    <i class="bi bi-chevron-down"></i>
                </div>
                <div class="collapse show" id="errorSubmenu">
                    <div class="list-group mt-2">
                        <a href="<?php echo BASE_URL; ?>/errors" 
                           class="list-group-item list-group-item-action">
                            <i class="bi bi-list-ul me-2"></i> لیست خطاها
                        </a>
                        <?php if (is_admin() || has_permission('create_error')): ?>
                        <a href="<?php echo BASE_URL; ?>/errors/create" 
                           class="list-group-item list-group-item-action">
                            <i class="bi bi-plus-lg me-2"></i> افزودن خطای جدید
                        </a>
                        <?php endif; ?>
                        <a href="<?php echo BASE_URL; ?>/errors/search" 
                           class="list-group-item list-group-item-action">
                            <i class="bi bi-search me-2"></i> جستجوی پیشرفته
                        </a>
                    </div>
                </div>
            </div>

            <?php if (is_admin()): ?>
            <!-- مدیریت کاربران -->
            <div class="list-group-item">
                <div class="d-flex justify-content-between align-items-center" 
                     data-bs-toggle="collapse" href="#userSubmenu" role="button">
                    <span><i class="bi bi-people me-2"></i> مدیریت کاربران</span>
                    <i class="bi bi-chevron-down"></i>
                </div>
                <div class="collapse" id="userSubmenu">
                    <div class="list-group mt-2">
                        <a href="<?php echo BASE_URL; ?>/users" 
                           class="list-group-item list-group-item-action">
                            <i class="bi bi-list-ul me-2"></i> لیست کاربران
                        </a>
                        <a href="<?php echo BASE_URL; ?>/users/create" 
                           class="list-group-item list-group-item-action">
                            <i class="bi bi-person-plus me-2"></i> افزودن کاربر
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>