<?php require_once 'layouts/header.php'; ?>

<div class="landing-page rtl">
    <!-- بخش هدر -->
    <header class="hero-section">
        <div class="container">
            <div class="row align-items-center min-vh-75">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold text-primary mb-4">سیستم مدیریت خطاهای لوکوموتیو</h1>
                    <p class="lead mb-4">سامانه جامع مدیریت و جستجوی خطاهای لوکوموتیو، راهنمای شما در عیب‌یابی و رفع مشکلات</p>
                    <div class="d-flex gap-3">
                        <a href="<?php echo BASE_URL; ?>/login" class="btn btn-primary btn-lg px-4">ورود به سیستم</a>
                        <a href="<?php echo BASE_URL; ?>/register" class="btn btn-outline-primary btn-lg px-4">ثبت نام</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="<?php echo BASE_URL; ?>/assets/images/locomotive.svg" alt="لوکوموتیو" class="img-fluid">
                </div>
            </div>
        </div>
    </header>

    <!-- بخش ویژگی‌ها -->
    <section class="features-section py-5">
        <div class="container">
            <h2 class="text-center mb-5">ویژگی‌های سیستم</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-search fs-1 text-primary mb-3"></i>
                            <h3 class="card-title h5">جستجوی سریع</h3>
                            <p class="card-text">دسترسی آسان و سریع به کدهای خطا و راه‌حل‌های مربوطه</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-database-check fs-1 text-primary mb-3"></i>
                            <h3 class="card-title h5">بانک اطلاعاتی جامع</h3>
                            <p class="card-text">دسترسی به مجموعه کاملی از کدهای خطا و راه‌حل‌های تخصصی</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-people fs-1 text-primary mb-3"></i>
                            <h3 class="card-title h5">مدیریت کاربران</h3>
                            <p class="card-text">سیستم مدیریت کاربران با سطوح دسترسی مختلف</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- بخش راهنما -->
    <section class="guide-section py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">راهنمای استفاده</h2>
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="steps">
                        <div class="step d-flex align-items-start mb-4">
                            <div class="step-number bg-primary text-white rounded-circle p-3 me-3">1</div>
                            <div>
                                <h3 class="h5">ثبت نام در سیستم</h3>
                                <p>ابتدا در سیستم ثبت نام کنید و منتظر تایید مدیر بمانید</p>
                            </div>
                        </div>
                        <div class="step d-flex align-items-start mb-4">
                            <div class="step-number bg-primary text-white rounded-circle p-3 me-3">2</div>
                            <div>
                                <h3 class="h5">ورود به سیستم</h3>
                                <p>پس از تایید ثبت نام، با نام کاربری و رمز عبور وارد شوید</p>
                            </div>
                        </div>
                        <div class="step d-flex align-items-start">
                            <div class="step-number bg-primary text-white rounded-circle p-3 me-3">3</div>
                            <div>
                                <h3 class="h5">جستجو و استفاده</h3>
                                <p>به راحتی کدهای خطا را جستجو کرده و راه‌حل‌ها را مشاهده کنید</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <img src="<?php echo BASE_URL; ?>/assets/images/guide.svg" alt="راهنما" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <!-- بخش تماس با ما -->
    <section class="contact-section py-5">
        <div class="container">
            <h2 class="text-center mb-5">تماس با ما</h2>
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <p class="mb-4">برای دریافت اطلاعات بیشتر و یا گزارش مشکلات با ما در تماس باشید</p>
                    <div class="d-flex justify-content-center gap-4">
                        <div>
                            <i class="bi bi-envelope fs-3 text-primary"></i>
                            <p class="mt-2">support@example.com</p>
                        </div>
                        <div>
                            <i class="bi bi-telephone fs-3 text-primary"></i>
                            <p class="mt-2">۰۲۱-۱۲۳۴۵۶۷۸</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php require_once 'layouts/footer.php'; ?>