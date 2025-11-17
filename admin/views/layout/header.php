<?php
if(session_status()===PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin PetCare</title>
    <link rel="stylesheet" href="../assets/css/kieu_dang.css">
    <link rel="stylesheet" href="../assets/css/hoso.css">
    <link rel="stylesheet" href="../assets/css/ad_header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<header>
    <nav class="navbar">
        <div class="logo">
            <a href="index.php">
                <img src="../assets/images/logo.png" alt="PetCare Logo" class="logo-img">
                <span class="logo-text">PetCare Admin</span>
            </a>
        </div>
        <div class="menu" id="mainMenu">
            <li><a href="<?php echo BASE_URL; ?>/customer/index.php?controller=TrangChuController&action=hienThiTrangChu"
                   class="<?php echo basename($_SERVER['PHP_SELF'])=='index.php' && (!isset($_GET['controller'])||$_GET['controller']=='TrangChuController')?'active':''; ?>">Trang chủ</a></li>
            <li><a href="<?php echo BASE_URL; ?>/customer/index.php?controller=XacThucController&action=xuLyDangXuat">Đăng xuất</a></li>
        </div>
    </nav>
</header>


<nav class="sidebar" id="admin-sidebar">
    <ul class="admin-menu">
        <?php $c = isset($_GET['action']) ? $_GET['action'] : ''; ?>
        <li><a href="index.php" class="<?php echo basename($_SERVER['PHP_SELF'])=='index.php'&&!isset($_GET['controller'])?'active':''; ?>"><i class="fas fa-home"></i> Trang chủ</a></li>
        <li><a href="index.php?controller=AdminController&action=quanLyVacXin" class="<?php echo $c=='quanLyVacXin'?'active':''; ?>"><i class="fas fa-syringe"></i> Quản lý Loại Vắc-xin</a></li>
        <li><a href="index.php?controller=AdminController&action=quanLyDatLich" class="<?php echo $c=='quanLyDatLich'?'active':''; ?>"><i class="fas fa-calendar-alt"></i> Quản lý Lịch hẹn</a></li>
    </ul>
</nav>



