<?php include(__DIR__ . '/../layout/header.php'); ?>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/dang_nhap.css">
<div class="container">
    <h2>Đăng nhập</h2>
    <?php 
    // Kiểm tra và gán giá trị mặc định nếu $xacThucController không tồn tại
    $thongBaoLoi = '';
    if (isset($xacThucController) && is_object($xacThucController)) {
        $thongBaoLoi = $xacThucController->getThongBaoLoi();
    }
    if ($thongBaoLoi): ?>
        <p style="color: red;"><?php echo htmlspecialchars($thongBaoLoi); ?></p>
    <?php endif; ?>

    <form method="POST" action="/petcare/customer/index.php?controller=XacThucController&action=xuLyDangNhap">
        <label>Tên đăng nhập:</label>
        <input type="text" name="tenDangNhap" required>

        <label>Mật khẩu:</label>
        <input type="password" name="matKhau" required>

        <button type="submit">Đăng nhập</button>
    </form>
</div>
<?php include(__DIR__ . '/../layout/footer.php'); ?>
