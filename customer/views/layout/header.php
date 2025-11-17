<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../../config/database.php';
?>

<!DOCTYPE html>
<html lang="<?php echo DEFAULT_LANGUAGE; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetCare - Hệ thống Quản lý Thú cưng</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/kieu_dang.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <a href="<?php echo BASE_URL; ?>/customer/index.php">
                    <img src="<?php echo BASE_URL; ?>/assets/images/logo.png" alt="PetCare Logo" class="logo-img">
                    <span class="logo-text">PetCare</span>
                </a>
            </div>
            
            <ul class="menu" id="mainMenu">
                <li><a href="<?php echo BASE_URL; ?>/customer/index.php?controller=TrangChuController&action=hienThiTrangChu" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' && (!isset($_GET['controller']) || $_GET['controller'] == 'TrangChuController') ? 'active' : ''; ?>">Trang chủ</a></li>
                <li><a href="<?php echo BASE_URL; ?>/customer/index.php?controller=DichVuController&action=hienThiDanhSachDichVu" class="<?php echo isset($_GET['controller']) && $_GET['controller'] == 'DichVuController' ? 'active' : ''; ?>">Dịch vụ tiêm phòng</a></li>

                <?php if (isset($_SESSION['maTK'])): ?>
                    <li class="dropdown">
                        <a href="#">Thú cưng ▾</a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo BASE_URL; ?>/customer/index.php?controller=LichTiemController&action=hienThiLichTiem">Lịch Tiêm</a></li>
                            <li><a href="<?php echo BASE_URL; ?>/customer/index.php?controller=LichSuTiemController&action=hienThiLichSu">Lịch sử tiêm</a></li>
                        </ul>
                    </li>
                    <li><a href="<?php echo BASE_URL; ?>/customer/index.php?controller=KhachHangController&action=hienThiHoSo" class="<?php echo isset($_GET['controller']) && $_GET['controller'] == 'KhachHangController' ? 'active' : ''; ?>">Hồ sơ cá nhân</a></li>
                    <li><a href="<?php echo BASE_URL; ?>/customer/index.php?controller=XacThucController&action=xuLyDangXuat">Đăng xuất</a></li>
                <?php else: ?>
                    <li><a href="<?php echo BASE_URL; ?>/customer/index.php?controller=XacThucController&action=hienThiDangNhap" class="<?php echo isset($_GET['controller']) && $_GET['controller'] == 'XacThucController' && isset($_GET['action']) && $_GET['action'] == 'hienThiDangNhap' ? 'active' : ''; ?>">Đăng nhập</a></li>
                    <li><a href="<?php echo BASE_URL; ?>/customer/index.php?controller=XacThucController&action=hienThiDangKy" class="<?php echo isset($_GET['controller']) && $_GET['controller'] == 'XacThucController' && isset($_GET['action']) && $_GET['action'] == 'hienThiDangKy' ? 'active' : ''; ?>">Đăng ký</a></li>
                <?php endif; ?>
            </ul>
        </nav>

    </header>
    <main class="main-content">