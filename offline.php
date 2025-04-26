<?php require_once 'views/layouts/main.php'; ?>

<div class="container-fluid pt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card text-center">
                <div class="card-body p-5">
                    <i class="bi bi-wifi-off display-1 text-muted mb-4"></i>
                    <h2 class="mb-4">اتصال به اینترنت برقرار نیست</h2>
                    <p class="mb-4">لطفاً اتصال اینترنت خود را بررسی کرده و دوباره تلاش کنید.</p>
                    <button class="btn btn-primary" onclick="window.location.reload()">
                        <i class="bi bi-arrow-clockwise me-2"></i>
                        تلاش مجدد
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>