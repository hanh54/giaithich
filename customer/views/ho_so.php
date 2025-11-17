<?php include 'layout/header.php'; ?>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/hoso.css">
<div class="container">
    <h2>Hồ sơ khách hàng</h2>
    <?php if ($controller->getThongBaoLoi()): ?>
        <p style="color: red;"><?php echo htmlspecialchars($controller->getThongBaoLoi()); ?></p>
    <?php endif; ?>

    <?php if (!empty($thongTinKhachHang)): ?>
        <div class="profile-info">
            <h3>Thông tin cá nhân</h3>
            <form action="index.php?controller=KhachHangController&action=hienThiHoSo" method="POST">
                <div class="form-group">
                    <label>Họ và tên:</label>
                    <input type="text" name="hoTen" value="<?php echo htmlspecialchars($thongTinKhachHang['HoTen'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label>Số điện thoại:</label>
                    <input type="text" name="sdt" value="<?php echo htmlspecialchars($thongTinKhachHang['SDT'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($thongTinKhachHang['Email'] ?? $thongTinKhachHang['EmailTaiKhoan'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label>Địa chỉ:</label>
                    <input type="text" name="diaChi" value="<?php echo htmlspecialchars($thongTinKhachHang['DiaChi'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label>Ghi chú:</label>
                    <textarea name="ghiChu"><?php echo htmlspecialchars($thongTinKhachHang['GhiChu'] ?? ''); ?></textarea>
                </div>
                <button type="submit" name="capNhat" class="btn">Cập nhật thông tin</button>
            </form>
        </div>

        <!-- Danh sách thú cưng -->
        <div class="pet-list">
            <h3>Danh sách thú cưng</h3>
            <?php if (!empty($thuCungList)): ?>
                <ul>
                    <?php foreach ($thuCungList as $thuCung): ?>
                        <li>
                            <?php echo htmlspecialchars($thuCung['TenTC']); ?> 
                            (Giống: <?php echo htmlspecialchars($thuCung['Giong']); ?>)
                            <form action="index.php?controller=KhachHangController&action=hienThiHoSo" method="POST" style="display:inline;">
                                <input type="hidden" name="maTC" value="<?php echo htmlspecialchars($thuCung['MaTC']); ?>">
                            
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <form action="index.php?controller=KhachHangController&action=hienThiHoSo" method="POST">
                    <button type="submit" name="hienThiFormThem" class="btn">Thêm thú cưng</button>
                </form>
            <?php else: ?>
                <p>Bạn chưa có thú cưng nào.</p>
                <form action="index.php?controller=KhachHangController&action=hienThiHoSo" method="POST">
                    <button type="submit" name="hienThiFormThem" class="btn">Thêm thú cưng</button>
                </form>
            <?php endif; ?>
        </div>

        <!-- Form thêm thú cưng (chỉ hiển thị khi nhấn Thêm) -->
        <?php if ($controller->getHienThiFormThem()): ?>
            <div class="pet-add">
                <h3>Thêm thú cưng</h3>
                <form action="index.php?controller=KhachHangController&action=hienThiHoSo" method="POST">
                    <div class="form-group">
                        <label>Tên thú cưng:</label>
                        <input type="text" name="tenTC" required>
                    </div>
                    <div class="form-group">
                        <label>Loại:</label>
                        <input type="text" name="loai" required>
                    </div>
                    <div class="form-group">
                        <label>Giống:</label>
                        <input type="text" name="giong" required>
                    </div>
                    <div class="form-group">
                        <label>Ngày sinh:</label>
                        <input type="date" name="ngaySinh" required>
                    </div>
                    <div class="form-group">
                        <label>Cân nặng (kg):</label>
                        <input type="number" name="canNang" step="0.1" required>
                    </div>
                    <div class="form-group">
                        <label>Giới tính:</label>
                        <select name="gioiTinh" required>
                            <option value="Đực">Đực</option>
                            <option value="Cái">Cái</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tình trạng sức khỏe:</label>
                        <input type="text" name="tinhTrangSucKhoe">
                    </div>
                    <div class="form-group">
                        <label>Lịch sử tiêm:</label>
                        <textarea name="lichSuTiem"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Hình ảnh:</label>
                        <input type="text" name="hinhAnh" placeholder="URL hoặc đường dẫn">
                    </div>
                    <button type="submit" name="themThuCung" class="btn">Lưu thú cưng</button>
                    <a href="index.php?controller=KhachHangController&action=hienThiHoSo" class="btn btn-secondary">Hủy</a>
                </form>
            </div>
        <?php endif; ?>

    <?php else: ?>
        <p>Không tìm thấy thông tin khách hàng.</p>
    <?php endif; ?>

    <a href="index.php?controller=TrangChuController&action=hienThiTrangChu" class="btn btn-secondary">Quay lại</a>
</div>
<?php include 'layout/footer.php'; ?>

<style>
    .form-group { margin-bottom: 15px; }
    .btn { padding: 5px 10px; margin-right: 5px; }
    .btn-small { padding: 2px 5px; font-size: 12px; }
    .pet-edit, .pet-add { border: 1px solid #ccc; padding: 10px; margin-top: 20px; }
</style>