<?php
function show_flash_message_script() {
    if (!isset($_SESSION['flash_messages']) || empty($_SESSION['flash_messages'])) {
        return;
    }

    echo "<script>";
    foreach ($_SESSION['flash_messages'] as $message) {
        $icon = match($message['type']) {
            'success' => 'success',
            'error', 'danger' => 'error',
            'warning' => 'warning',
            'info' => 'info',
            default => 'info'
        };
        
        echo "Swal.fire({
            icon: '$icon',
            title: '" . addslashes($message['message']) . "',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });";
    }
    echo "</script>";
    
    // پاک کردن پیام‌ها بعد از نمایش
    $_SESSION['flash_messages'] = [];
}

function set_flash_message($type, $message) {
    if (!isset($_SESSION['flash_messages'])) {
        $_SESSION['flash_messages'] = [];
    }
    
    $_SESSION['flash_messages'][] = [
        'type' => $type,
        'message' => $message
    ];
}

function show_toast($type, $message) {
    echo "<script>
    Swal.fire({
        icon: '$type',
        title: '$message',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
    </script>";
}