<?php include 'layout/header.php'; ?>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/admin.css">

<div class="ad-container">
    <h2 class="title">Bảng điều khiển quản trị</h2>


    <?php
    // --- 1. LOGIC XÁC ĐỊNH LỜI CHÀO THEO THỜI GIAN ---
    $tenNguoiDung = $_SESSION['user_name'] ?? 'Quản trị viên';
    $gioHienTai = (int)date('H');
   
    if ($gioHienTai >= 5 && $gioHienTai < 12) {
        $loiChao = "Chào buổi sáng";
        $icon = "fas fa-sun";
    } elseif ($gioHienTai >= 12 && $gioHienTai < 18) {
        $loiChao = "Chào buổi chiều";
        $icon = "fas fa-cloud-sun";
    } else {
        $loiChao = "Chào buổi tối";
        $icon = "fas fa-moon";
    }
    ?>


    <div class="welcome-banner">
        <div class="banner-content">
            <h1 class="greeting">
                <i class="<?= $icon ?>"></i> <?= $loiChao ?>, **<?= $tenNguoiDung ?>**!
            </h1>
            <p class="motivational-message">
                Chúc bạn một ngày làm việc hiệu quả!
            </p>
        </div>
        <div class="banner-info">
            <p>Hôm nay là: **<?= date('l, d/m/Y') ?>**</p>
            <p>Hiện tại là: **<?= date('H:i:s') ?>**</p>
        </div>
    </div>
       


    <div class="status-widgets-grid">
        <div class="widget widget-appointment">
            <i class="fas fa-calendar-day widget-icon"></i>
            <h4>Lịch Hẹn Hôm Nay</h4>
            <p class="main-stat"><?= $soLichHenHomNay ?? 0 ?></p>
        </div>
        </div>
        
    <div class="status-widgets-grid">
        <div class="widget widget-appointment">
            <i class="fas fa-calendar-day widget-icon"></i>
            <h4>Loại Vắc-xin</h4>
            <p class="main-stat"><?= $soLoaiThuoc ?? 0 ?></p>
        </div>
    </div>
    
   
    </div>


<?php include 'layout/footer.php'; ?>



