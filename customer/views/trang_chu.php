<?php include 'layout/header.php'; ?>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/trang_chu.css">
<div class="container">
    <div class="banner">
        <h1>"Bảo vệ thú cưng của bạn với vắc-xin!"</h1>
        <img src="../assets/images/banner1.png" alt="PetCare Vaccination Banner" class="banner-img">
    </div>

    <div class="introduction">
        <h2>Chào mừng đến với PetCare</h2>
        <p>PetCare là trung tâm chăm sóc sức khỏe dành riêng cho thú cưng của bạn. Chúng tôi cung cấp các dịch vụ tiêm phòng chất lượng cao, giúp thú cưng của bạn luôn khỏe mạnh và vui vẻ. Với đội ngũ bác sĩ thú y giàu kinh nghiệm, chúng tôi cam kết mang đến sự chăm sóc tốt nhất cho những người bạn bốn chân.</p>
        <p>Tại PetCare, chúng tôi hiểu rằng thú cưng không chỉ là động vật, mà còn là thành viên trong gia đình. Vì vậy, chúng tôi luôn ưu tiên sức khỏe và an toàn của chúng trong mọi dịch vụ.</p>
    </div>

    <div class="benefits">
        <h2>Lợi ích của việc tiêm phòng cho thú cưng</h2>
        <ul>
            <li>Bảo vệ thú cưng khỏi các bệnh truyền nhiễm nguy hiểm như bệnh dại, parvovirus, và nhiều bệnh khác.</li>
            <li>Giúp thú cưng có hệ miễn dịch mạnh mẽ hơn, giảm nguy cơ mắc bệnh và chi phí điều trị sau này.</li>
            <li>Tuân thủ quy định pháp luật về tiêm phòng cho thú cưng, đặc biệt là chó và mèo.</li>
            <li>Mang lại sự yên tâm cho chủ nuôi, biết rằng thú cưng của mình được bảo vệ tốt nhất.</li>
            <li>Dịch vụ nhanh chóng, an toàn với các loại vắc-xin chất lượng cao từ các nhà sản xuất uy tín.</li>
        </ul>
    </div>

    <div class="available-vaccines">
        <h2>Các loại vắc-xin hiện có</h2>
        <div class="vaccine-list">
            <?php foreach ($controller->getDanhSachVacXinHoatDong() as $vacXin): ?>
                <div class="vaccine-item">
                    <img src="<?php echo htmlspecialchars($vacXin['HinhAnh'] ?? 'default.jpg'); ?>" alt="<?php echo htmlspecialchars($vacXin['TenThuoc']); ?>">
                    <h3><?php echo htmlspecialchars($vacXin['TenThuoc']); ?></h3>
                    <p>Mô tả: <?php echo htmlspecialchars($vacXin['MoTa']); ?></p>
                    <p>Giá: <?php echo number_format($vacXin['Gia'], 0, ',', '.') ?> VNĐ</p>
                    <a href="index.php?controller=DatLichController&action=hienThiDatLich&maTP=<?php echo $vacXin['MaTP']; ?>" class="btn">Đặt lịch</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php if (!empty($controller->getLichHenGanDay())): ?>
        <div class="recent-appointments">
            <h2>Lịch hẹn gần đây</h2>
            <?php foreach ($controller->getLichHenGanDay() as $lichHen): ?>
                <div class="appointment-item">
                    <p>Thú cưng: <?php echo htmlspecialchars($lichHen['TenTC']); ?></p>
                    <p>Vắc-xin: <?php echo htmlspecialchars($lichHen['TenThuoc']); ?></p>
                    <p>Ngày hẹn: <?php echo date('d/m/Y', strtotime($lichHen['NgayHen'])); ?> - <?php echo $lichHen['GioHen']; ?></p>
                    <a href="index.php?controller=TrangChuController&action=hienThiChiTietLichHen&maLich=<?php echo $lichHen['MaLich']; ?>" class="btn">Xem chi tiết</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="faq">
        <h2>Câu hỏi thường gặp</h2>
        <div class="faq-item">
            <h3>Thú cưng của tôi cần tiêm phòng bao nhiêu lần?</h3>
            <p>Tùy thuộc vào loại vắc-xin và độ tuổi của thú cưng, thường là từ 1-3 mũi cơ bản, sau đó tiêm nhắc lại hàng năm.</p>
        </div>
        <div class="faq-item">
            <h3>Tôi cần chuẩn bị gì trước khi đưa thú cưng đi tiêm?</h3>
            <p>Hãy đảm bảo thú cưng của bạn khỏe mạnh, không bị bệnh, và mang theo sổ theo dõi sức khỏe nếu có.</p>
        </div>
        <div class="faq-item">
            <h3>Dịch vụ có hỗ trợ tại nhà không?</h3>
            <p>Hiện tại, chúng tôi chỉ hỗ trợ tiêm phòng tại trung tâm để đảm bảo an toàn và thiết bị đầy đủ.</p>
        </div>
    </div>

</div>
<?php include 'layout/footer.php'; ?>