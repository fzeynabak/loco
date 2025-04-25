<?php require_once 'views/partials/header.php'; ?>

<div class="d-flex">
    <!-- Sidebar - Fixed on right -->
    <div class="sidebar bg-light border-left" style="width: 250px; position: fixed; right: 0; top: 0; bottom: 0; overflow-y: auto;">
        <?php require_once 'views/partials/sidebar.php'; ?>
    </div>

    <!-- Main Content - with margin-right for sidebar -->
    <div class="flex-grow-1" style="margin-right: 250px; padding: 20px;">
        <div class="container">
            <!-- Helper Image and Text -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="position-relative" style="width: 100px; height: 100px;">
                                    <img src="<?php echo BASE_URL; ?>/assets/img/error-guide.png" 
                                         alt="راهنمای ثبت خطا" 
                                         class="img-fluid rounded" 
                                         style="width: 100px; height: 100px; object-fit: cover;">
                                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex align-items-center justify-content-center text-white opacity-0 hover-overlay"
                                         style="transition: opacity 0.3s;">
                                        <span>راهنمای ثبت خطا</span>
                                    </div>
                                </div>
                                <div class="ms-3">
                                    <h5 class="mb-2">راهنمای ثبت خطا</h5>
                                    <p class="mb-0">لطفاً تمام فیلدها را با دقت تکمیل کنید. اطلاعات دقیق به تشخیص و رفع سریع‌تر خطا کمک می‌کند.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Technical Diagram and Video Guide -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="position-relative" style="height: 200px;">
                                <img src="<?php echo BASE_URL; ?>/assets/img/technical-diagram.png" 
                                     alt="نقشه فنی" 
                                     class="img-fluid w-100 h-100" 
                                     style="object-fit: cover;">
                                <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex align-items-center justify-content-center text-white opacity-0 hover-overlay"
                                     style="transition: opacity 0.3s;">
                                    <span>مشاهده نقشه فنی</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="position-relative" style="height: 200px;">
                                <img src="<?php echo BASE_URL; ?>/assets/img/video-guide.png" 
                                     alt="ویدیوی راهنما" 
                                     class="img-fluid w-100 h-100" 
                                     style="object-fit: cover;">
                                <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex align-items-center justify-content-center text-white opacity-0 hover-overlay"
                                     style="transition: opacity 0.3s;">
                                    <span>مشاهده ویدیوی راهنما</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Error Form -->
            <div class="card">
                <div class="card-body">
                    <form action="<?php echo BASE_URL; ?>/locomotive-errors/store" method="POST" enctype="multipart/form-data">
                        <!-- Form fields here (existing fields remain unchanged) -->
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="error_code" class="form-label">کد خطا *</label>
                                <input type="text" class="form-control" id="error_code" name="error_code" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="severity" class="form-label">شدت خطا *</label>
                                <select class="form-select" id="severity" name="severity" required>
                                    <option value="">انتخاب کنید</option>
                                    <option value="critical">بحرانی</option>
                                    <option value="major">مهم</option>
                                    <option value="minor">جزئی</option>
                                    <option value="warning">هشدار</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">شرح خطا *</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>

                        <!-- Add other form fields as needed -->

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary">ثبت خطا</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-overlay {
    cursor: pointer;
}
.hover-overlay:hover {
    opacity: 1 !important;
}
</style>

<?php require_once 'views/partials/footer.php'; ?>