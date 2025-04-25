<nav class="sidebar-nav d-flex flex-column flex-shrink-0 bg-white shadow-lg">
    <!-- Header -->
    <div class="d-flex align-items-center mb-3 p-3">
        <button class="btn btn-link text-dark d-lg-none me-3" type="button" onclick="toggleSidebar()">
            <i class="bi bi-x-lg"></i>
        </button>
        <a href="<?php echo BASE_URL; ?>" class="d-flex align-items-center text-dark text-decoration-none flex-grow-1">
            <i class="bi bi-train-front-fill fs-4 me-2"></i>
            <span class="fs-5 fw-semibold">مدیریت خطاها</span>
        </a>
    </div>

    <hr class="text-black-50 mx-3">

    <!-- User Profile Summary -->
    <div class="profile-summary mb-3 px-3">
        <div class="d-flex align-items-center">
            <img src="https://www.gravatar.com/avatar/<?php echo md5($_SESSION['email'] ?? ''); ?>?s=45&d=mp" 
                 alt="تصویر پروفایل" 
                 class="rounded-circle me-2">
            <div>
                <div class="fw-bold"><?php echo htmlspecialchars($_SESSION['name'] ?? ''); ?></div>
                <small class="text-muted"><?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?></small>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <ul class="nav nav-pills flex-column mb-auto px-3">
        <li class="nav-item mb-1">
            <a href="<?php echo BASE_URL; ?>/dashboard" 
               class="nav-link <?php echo $route === 'dashboard' ? 'active' : 'link-dark'; ?>">
                <i class="bi bi-speedometer2 me-2"></i>
                <span>داشبورد</span>
            </a>
        </li>
        
        <li class="nav-item mb-1">
            <a href="<?php echo BASE_URL; ?>/errors" 
               class="nav-link <?php echo $route === 'errors' ? 'active' : 'link-dark'; ?>">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <span>لیست خطاها</span>
            </a>
        </li>
        
        <?php if (has_permission('create_error')): ?>
        <li class="nav-item mb-1">
            <a href="<?php echo BASE_URL; ?>/errors/create" 
               class="nav-link <?php echo $route === 'errors/create' ? 'active' : 'link-dark'; ?>">
                <i class="bi bi-plus-circle me-2"></i>
                <span>افزودن خطا</span>
            </a>
        </li>
        <?php endif; ?>
        
        <?php if (is_admin()): ?>
        <li class="nav-item mb-1">
            <a href="<?php echo BASE_URL; ?>/users" 
               class="nav-link <?php echo $route === 'users' ? 'active' : 'link-dark'; ?>">
                <i class="bi bi-people me-2"></i>
                <span>مدیریت کاربران</span>
            </a>
        </li>
        
        <li class="nav-item mb-1">
            <a href="<?php echo BASE_URL; ?>/users/permissions" 
                class="nav-link <?php echo $route === 'users/permissions' ? 'active' : 'link-dark'; ?>">
                <i class="bi bi-shield-check me-2"></i>
                <span>مدیریت دسترسی‌ها</span>
            </a>
        </li>
        <?php endif; ?>
    </ul>

    <!-- Bottom Actions -->
    <hr class="text-black-50 mx-3">
    <div class="dropdown px-3 pb-3">
        <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" 
           id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-gear me-2"></i>
            <span>تنظیمات</span>
        </a>
        <ul class="dropdown-menu text-end" aria-labelledby="userMenu">
            <li>
                <a class="dropdown-item" href="<?php echo BASE_URL; ?>/profile">
                    <i class="bi bi-person me-2"></i>
                    پروفایل
                </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="confirmLogout()">
                    <i class="bi bi-box-arrow-right me-2"></i>
                    خروج
                </a>
            </li>
        </ul>
    </div>
</nav>