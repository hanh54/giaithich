<?php 
// Nhúng file header của layout, chứa phần đầu HTML, bao gồm <head>, CSS/JS chung, menu điều hướng
include 'layout/header.php'; 
?>

<!-- Nhúng CSS riêng cho trang admin -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/admin.css">

<!-- Bắt đầu container chính của trang admin -->
<div class="ad-container">

    <!-- Tiêu đề của dashboard admin -->
    <h2 class="title">Bảng điều khiển quản trị</h2>

    <?php
    // --- 1. XÁC ĐỊNH LỜI CHÀO THEO THỜI GIAN ---
    
    // Lấy tên người dùng từ session (nếu người dùng đã đăng nhập)
    // Nếu session không có tên người dùng, sử dụng tên mặc định "Quản trị viên"
    $tenNguoiDung = $_SESSION['user_name'] ?? 'Quản trị viên';

    // Lấy giờ hiện tại theo định dạng 24h (0-23) để xác định lời chào
    $gioHienTai = (int)date('H');
   
    // Điều kiện để xác định lời chào và icon hiển thị theo khung giờ
    if ($gioHienTai >= 5 && $gioHienTai < 12) {
        $loiChao = "Chào buổi sáng";       // Từ 5h đến 11h59 là buổi sáng
        $icon = "fas fa-sun";              // Icon mặt trời
    } elseif ($gioHienTai >= 12 && $gioHienTai < 18) {
        $loiChao = "Chào buổi chiều";      // Từ 12h đến 17h59 là buổi chiều
        $icon = "fas fa-cloud-sun";        // Icon mặt trời có mây
    } else {
        $loiChao = "Chào buổi tối";        // Từ 18h đến 4h59 hôm sau là buổi tối
        $icon = "fas fa-moon";             // Icon mặt trăng
    }
    ?>

    <!-- Banner chào mừng người dùng -->
    <div class="welcome-banner">

        <!-- Phần nội dung lời chào -->
        <div class="banner-content">
            <!-- Hiển thị icon, lời chào và tên người dùng -->
            <h1 class="greeting">
                <i class="<?= $icon ?>"></i> <!-- Hiển thị icon tương ứng -->
                <?= $loiChao ?>, <strong><?= $tenNguoiDung ?></strong>!
            </h1>
            <!-- Tin nhắn động viên, cố gắng thúc đẩy tinh thần làm việc -->
            <p class="motivational-message">
                Chúc bạn một ngày làm việc hiệu quả!
            </p>
        </div>

        <!-- Phần thông tin ngày và giờ hiện tại -->
        <div class="banner-info">
            <p>Hôm nay là: <strong><?= date('l, d/m/Y') ?></strong></p>
            <!-- Hiển thị ngày theo format: Thứ, ngày/tháng/năm -->
            <p>Hiện tại là: <strong><?= date('H:i:s') ?></strong></p>
            <!-- Hiển thị giờ hiện tại theo format 24h: phút:giây -->
        </div>

    </div>
       
    <!-- --- Widget hiển thị trạng thái / số liệu --- -->
    <div class="status-widgets-grid">
        <div class="widget widget-appointment">
            <!-- Icon biểu tượng lịch hẹn -->
            <i class="fas fa-calendar-day widget-icon"></i>
            <h4>Lịch Hẹn Hôm Nay</h4>
            <!-- Hiển thị số lượng lịch hẹn hôm nay. Nếu biến chưa tồn tại thì mặc định là 0 -->
            <p class="main-stat"><?= $soLichHenHomNay ?? 0 ?></p>
        </div>
    </div>
        
    <div class="status-widgets-grid">
        <div class="widget widget-appointment">
            <!-- Icon biểu tượng loại vắc-xin -->
            <i class="fas fa-calendar-day widget-icon"></i>
            <h4>Loại Vắc-xin</h4>
            <!-- Hiển thị số loại vắc-xin có trong hệ thống. Nếu biến chưa tồn tại thì mặc định là 0 -->
            <p class="main-stat"><?= $soLoaiThuoc ?? 0 ?></p>
        </div>
    </div>
    
</div> <!-- Kết thúc ad-container -->

<?php 
// Nhúng footer của layout, chứa phần cuối HTML, scripts chung
include 'layout/footer.php'; 
?>
