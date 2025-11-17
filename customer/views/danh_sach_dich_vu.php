<?php include 'layout/header.php'; ?>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/ds_dv.css">
<div class="container">
    <h2>Danh sách dịch vụ tiêm phòng</h2>
    <?php if ($controller->getThongBaoLoi()): ?>
        <p style="color: red;"><?php echo htmlspecialchars($controller->getThongBaoLoi()); ?></p>
    <?php endif; ?>
    <div class="vaccine-list">
        <?php foreach ($controller->getDanhSachDichVuHoatDong() as $dichVu): ?>
            <div class="vaccine-item">
                <img src="<?php echo htmlspecialchars($dichVu['HinhAnh'] ?? 'default.jpg'); ?>" alt="<?php echo htmlspecialchars($dichVu['TenThuoc']); ?>">
                <h3><?php echo htmlspecialchars($dichVu['TenThuoc']); ?></h3>
                <p>Loại thú cưng: <?php echo htmlspecialchars($dichVu['LoaiThuCung']); ?></p>
                <p>Giá: <?php echo number_format($dichVu['Gia'], 0, ',', '.') ?> VNĐ</p>
                <a href="index.php?controller=DichVuController&action=hienThiChiTietDichVu&maTP=<?php echo $dichVu['MaTP']; ?>" class="btn">Xem chi tiết</a>
                <a href="index.php?controller=DichVuController&action=datLichTuDichVu&maTP=<?php echo $dichVu['MaTP']; ?>" class="btn btn-secondary">Đặt lịch</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include 'layout/footer.php'; ?>