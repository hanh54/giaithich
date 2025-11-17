<?php include(__DIR__ . '/../layout/header.php'); ?>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/dang_ky.css">
<div class="container">
    <h2>Đăng ký</h2>
    <?php if ($thongBaoLoi = $xacThucController->getThongBaoLoi()): ?>
        <p style="color: red;"><?php echo $thongBaoLoi; ?></p>
    <?php endif; ?>
    <form method="POST" action="index.php?controller=XacThucController&action=xuLyDangKy">
        <label>Họ tên:</label>
        <input type="text" name="hoTen" required>
        <label>Số điện thoại:</label><label?>
        <input type="text" name="sdt" required>
        <label>Tên đăng nhập:</label>
        <input type="text" name="tenDangNhap" required>
        <label>Mật khẩu:</label>
        <input type="password" name="matKhau" required>
        <label>Email:</label>
        <input type="email" name="email" required>
        <label>Địa chỉ:</label>
        <input type="text" name="diaChi">
        <button type="submit">Đăng ký</button>
    </form>
</div>
<?php include(__DIR__ . '/../layout/footer.php'); ?>