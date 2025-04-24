<div class="sidebar">
    <div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 280px; height: 100vh;">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
            <i class="bi bi-train-front me-2"></i>
            <span class="fs-4">مدیریت خطاها</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="<?php echo BASE_URL; ?>/dashboard" class="nav-link <?php echo $route === 'dashboard' ? 'active' : 'link-dark'; ?>">
                    <i class="bi bi-speedometer2 me-2"></i>
                    داشبورد
                </a>
            </li>
            
            <li class="nav-item">
                <a href="<?php echo BASE_URL; ?>/errors" class="nav-link <?php echo $route === 'errors' ? 'active' : 'link-dark'; ?>">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    لیست خطاها
                </a>
            </li>
            
            <?php if (has_permission('create_error')): ?>
            <li class="nav-item">
                <a href="<?php echo BASE_URL; ?>/errors/create" class="nav-link <?php echo $route === 'errors/create' ? 'active' : 'link-dark'; ?>">
                    <i class="bi bi-plus-circle me-2"></i>
                    افزودن خطا
                </a>
            </li>
            <?php endif; ?>
            
            <?php if (is_admin()): ?>
            <li class="nav-item">
                <a href="<?php echo BASE_URL; ?>/users" class="nav-link <?php echo $route === 'users' ? 'active' : 'link-dark'; ?>">
                    <i class="bi bi-people me-2"></i>
                    مدیریت کاربران
                </a>
            </li>
            
            <li class="nav-item">
                <a href="<?php echo BASE_URL; ?>/permissions" class="nav-link <?php echo $route === 'permissions' ? 'active' : 'link-dark'; ?>">
                    <i class="bi bi-shield-check me-2"></i>
                    مدیریت دسترسی‌ها
                </a>
            </li>
            <?php endif; ?>
        </ul>
        <hr>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown">
                <img src="https://github.com/<?php echo htmlspecialchars($_SESSION['username'] ?? 'user'); ?>.png" alt="" width="32" height="32" class="rounded-circle me-2">
                <strong><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'کاربر'); ?></strong>
            </a>
            <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser">
                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/profile">پروفایل</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/logout">خروج</a></li>
            </ul>
        </div>
    </div>
</div>