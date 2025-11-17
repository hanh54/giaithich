<?php include 'layout/header.php'; ?>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/datlich.css">
<div class="container">
    <h2>Đặt lịch tiêm phòng</h2>
    <?php if ($controller->getThongBaoLoi()): ?>
        <p style="color: red;"><?php echo htmlspecialchars($controller->getThongBaoLoi()); ?></p>
    <?php endif; ?>
    <?php if (isset($dichVu) && $dichVu): ?>
        <form action="index.php?controller=DatLichController&action=xuLyDatLich" method="POST">
            <input type="hidden" name="maTP" value="<?php echo htmlspecialchars($maTP ?? ''); ?>">
            <div class="form-group">
                <label>Dịch vụ:</label>
                <input type="text" name="maTP_display" value="<?php echo htmlspecialchars($dichVu['TenThuoc'] ?? ''); ?>" readonly>
            </div>
            <div class="form-group">
                <label>Thú cưng:</label>
                <select name="maTC" required>
                    <?php foreach ($thuCungList as $thuCung): ?>
                        <option value="<?php echo htmlspecialchars($thuCung['MaTC']); ?>">
                            <?php echo htmlspecialchars($thuCung['TenTC']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Ngày hẹn:</label>
                <input type="date" name="ngayHen" required>
            </div>
            <div class="form-group">
                <label>Giờ hẹn:</label>
                <input type="time" name="gioHen" required>
            </div>
            <div class="form-group">
                <label>Ghi chú:</label>
                <textarea name="ghiChu"></textarea>
            </div>
            <div class="form-group">
                <label>Tổng tiền:</label>
                <input type="text" name="tongTien_display" value="<?php echo htmlspecialchars($dichVu['Gia'] ? number_format($dichVu['Gia'], 0, ',', '.') . ' VNĐ' : ''); ?>" readonly>
            </div>
            <button type="submit" class="btn">Đặt lịch</button>
        </form>
    <?php else: ?>
        <p style="color: red;">Không tìm thấy thông tin dịch vụ. Vui lòng chọn lại dịch vụ!</p>
    <?php endif; ?>
    <?php if (!isset($thuCungList) || empty($thuCungList)): ?>
        <p style="color: red;">Vui lòng thêm thú cưng trước khi đặt lịch!</p>
        <a href="index.php?controller=ThuCungController&action=hienThiDanhSachThuCung" class="btn btn-secondary">Thêm thú cưng</a>
    <?php endif; ?>
    <a href="index.php?controller=DichVuController&action=hienThiDanhSachDichVu" class="btn btn-secondary">Quay lại</a>
</div>
<?php include 'layout/footer.php'; ?>