<?php include 'layout/header.php'; ?>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/lichsutiem.css">

<div class="container">
 <section class="recent-appointments">
   <h2>💉 Lịch sử tiêm phòng</h2>


   <?php if (!empty($lichSuTiem)): ?>
     <div class="appointment-list">
       <?php foreach ($lichSuTiem as $lt): ?>
         <div class="appointment-item">
           <div class="appointment-info">
             <h3><?= htmlspecialchars($lt['TenTC']) ?> – <?= htmlspecialchars($lt['TenThuoc'] ?? 'Không rõ') ?></h3>
             <p><strong>Ngày tiêm:</strong> <?= date('d/m/Y', strtotime($lt['NgayTiem'])) ?></p>
             <p><strong>Bác sĩ phụ trách:</strong> <?= htmlspecialchars($lt['BacSi'] ?? 'Chưa cập nhật') ?></p>
             <p><strong>Liều lượng:</strong> <?= htmlspecialchars($lt['LieuLuong'] ?? '-') ?></p>
             <p><strong>Số mũi đã tiêm:</strong> <?= $lt['SoMuiDaTiem'] ?></p>
             <p><strong>Ghi chú:</strong> <?= htmlspecialchars($lt['GhiChu'] ?? '') ?></p>
           </div>
           <span class="status completed">Hoàn thành</span>
         </div>
       <?php endforeach; ?>
     </div>
   <?php else: ?>
     <p class="text-center text-gray">⚠️ Bạn chưa có lịch sử tiêm phòng nào.</p>
   <?php endif; ?>
 </section>
</div>


<?php include 'layout/footer.php'; ?>



