<?php include 'layout/header.php'; ?>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/lichtiem.css">

<div class="container">
 <section class="recent-appointments">
   <h2>📅 Lịch tiêm sắp tới</h2>
   <?php if (!empty($lichTiem)): ?>
     <div class="appointment-list">
       <?php foreach ($lichTiem as $lt): ?>
         <div class="appointment-item">
           <div class="appointment-info">
             <h3><?= htmlspecialchars($lt['TenTC']) ?> – <?= htmlspecialchars($lt['TenThuoc']) ?></h3>
             <p><strong>Ngày:</strong> <?= date('d/m/Y', strtotime($lt['NgayHen'])) ?> <?= htmlspecialchars($lt['GioHen']) ?></p>
             <p><strong>Trạng thái:</strong> <?= htmlspecialchars($lt['TrangThai']) ?></p>
           </div>
         </div>
       <?php endforeach; ?>
     </div>
   <?php else: ?>
     <p class="text-center text-gray">Chưa có lịch tiêm sắp tới.</p>
   <?php endif; ?>
 </section>
</div>


<?php include 'layout/footer.php'; ?>



