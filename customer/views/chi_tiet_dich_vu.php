<?php include 'layout/header.php'; ?>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/ctdv.css">
<div class="container">
    <h2>Chi tiết dịch vụ</h2>
    <?php if ($controller->getThongBaoLoi()): ?>
        <p style="color: red;"><?php echo htmlspecialchars($controller->getThongBaoLoi()); ?></p>
    <?php endif; ?>
    <div class="vaccine-detail">
        <?php if (isset($dichVu)): ?>
            <img src="<?php echo htmlspecialchars($dichVu['HinhAnh'] ?? 'default.jpg'); ?>" alt="<?php echo htmlspecialchars($dichVu['TenThuoc']); ?>">
            <h3><?php echo htmlspecialchars($dichVu['TenThuoc']); ?></h3>
            <p><strong>Mô tả:</strong> <?php echo htmlspecialchars($dichVu['MoTa']); ?></p>
            <p><strong>Loại thú cưng:</strong> <?php echo htmlspecialchars($dichVu['LoaiThuCung']); ?></p>
            <p><strong>Số lần tiêm:</strong> <?php echo htmlspecialchars($dichVu['SoLanTiem']); ?></p>
            <p><strong>Thời lượng:</strong> <?php echo htmlspecialchars($dichVu['ThoiLuong']); ?> phút</p>
            <p><strong>Giá:</strong> <?php echo number_format($dichVu['Gia'], 0, ',', '.') ?> VNĐ</p>
            <?php if (isset($_SESSION['maTK']) && $_SESSION['vaiTro'] === 'Khách hàng' && !$controller->getThongBaoLoi()): ?>
                <a href="index.php?controller=DichVuController&action=datLichTuDichVu&maTP=<?php echo $dichVu['MaTP']; ?>" class="btn">Đặt lịch ngay</a>
            <?php elseif (!isset($_SESSION['maTK'])): ?>
                <p>Vui lòng <a href="index.php?controller=XacThucController&action=hienThiDangNhap">đăng nhập</a> để đặt lịch.</p>
            <?php elseif ($controller->getThongBaoLoi()): ?>
                <p>Vui lòng khắc phục lỗi: <?php echo htmlspecialchars($controller->getThongBaoLoi()); ?></p>
                <a href="index.php?controller=ThuCungController&action=hienThiThemThuCung" class="btn">Thêm thú cưng</a>
            <?php endif; ?>
        <?php else: ?>
            <p>Dịch vụ không tồn tại hoặc không khả dụng.</p>
        <?php endif; ?>
        <a href="index.php?controller=DichVuController&action=hienThiDanhSachDichVu" class="btn btn-secondary">Quay lại</a>
    </div>
</div>
<?php include 'layout/footer.php'; ?>