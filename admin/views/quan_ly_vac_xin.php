<?php include 'layout/header.php'; ?>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/vacxin.css">
   <div class="ad-container">
   <h2 class="title">Quản lý lịch hẹn</h2>


   <!-- Form thêm/sửa -->
   <form method="post" style="margin-bottom:30px;">
       <h3>➕ Thêm / Cập nhật Vắc-xin</h3>
       <input type="hidden" name="MaTP" id="MaTP">
       <div>
           <label>Tên thuốc:</label>
           <input type="text" name="TenThuoc" id="TenThuoc" required>
       </div>
       <div>
           <label>Mô tả:</label>
           <textarea name="MoTa" id="MoTa"></textarea>
       </div>
       <div>
           <label>Giá (VNĐ):</label>
           <input type="number" name="Gia" id="Gia" required>
       </div>
       <div>
           <label>Hình ảnh (URL):</label>
           <input type="text" name="HinhAnh" id="HinhAnh">
       </div>
       <div>
           <label>Trạng thái:</label>
           <select name="TrangThai" id="TrangThai">
               <option value="1">Hoạt động</option>
               <option value="0">Ngừng</option>
           </select>
       </div>


       <button type="submit" name="action" value="add" class="btn">Thêm mới</button>
       <button type="submit" name="action" value="edit" class="btn btn-secondary">Cập nhật</button>
   </form>


   <!-- Bảng danh sách -->
   <table border="1" cellpadding="10" cellspacing="0" width="100%">
       <thead style="background-color:#00a8e8;color:white;">
           <tr>
               <th>Mã</th>
               <th>Tên thuốc</th>
               <th>Mô tả</th>
               <th>Giá</th>
               <th>Hình ảnh</th>
               <th>Trạng thái</th>
               <th>Hành động</th>
           </tr>
       </thead>
       <tbody>
           <?php foreach ($vaccines as $v): ?>
               <tr>
                   <td><?= $v['MaTP'] ?></td>
                   <td><?= htmlspecialchars($v['TenThuoc']) ?></td>
                   <td><?= htmlspecialchars($v['MoTa']) ?></td>
                   <td><?= number_format($v['Gia'], 0, ',', '.') ?> VNĐ</td>
                   <td><img src="<?= htmlspecialchars($v['HinhAnh']) ?>" alt="Ảnh" style="width:70px;height:70px;object-fit:cover;border-radius:6px;"></td>
                   <td><?= $v['TrangThai'] ? 'Hoạt động' : 'Ngừng' ?></td>
                   <td>
                       <button onclick="editVacxin(<?= htmlspecialchars(json_encode($v)) ?>)">✏️</button>
                       <form method="post" style="display:inline;">
                           <input type="hidden" name="MaTP" value="<?= $v['MaTP'] ?>">
                           <button type="submit" name="action" value="delete" onclick="return confirm('Bạn có chắc muốn xóa vắc-xin này?')">🗑️</button>
                       </form>
                   </td>
               </tr>
           <?php endforeach; ?>
       </tbody>
   </table>
</div>


<script>
function editVacxin(v) {
   document.getElementById('MaTP').value = v.MaTP;
   document.getElementById('TenThuoc').value = v.TenThuoc;
   document.getElementById('MoTa').value = v.MoTa;
   document.getElementById('Gia').value = v.Gia;
   document.getElementById('HinhAnh').value = v.HinhAnh;
   document.getElementById('TrangThai').value = v.TrangThai;
}
</script>
<?php include 'layout/footer.php'; ?>







