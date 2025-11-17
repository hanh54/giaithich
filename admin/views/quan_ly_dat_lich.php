<?php include 'layout/header.php'; ?>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/ad_datlich.css">

<div class="ad-container">
    <h2 class="title">Quản lý lịch hẹn</h2>


    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Khách Hàng</th>
                <th>Thú cưng</th>
                <th>Dịch vụ</th>
                <th>Ngày đặt lịch</th>
                <th>Bác sĩ</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $colors = ['Đã xác nhận'=>'green','Đang thực hiện'=>'orange','Hoàn thành'=>'blue','Hủy'=>'red'];
            foreach ($danhSach as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['TenKH']) ?></td>
                    <td><?= htmlspecialchars($item['TenTC']) ?></td>
                    <td><?= htmlspecialchars($item['TenThuoc']) ?></td>
                    <td><?= htmlspecialchars($item['NgayHen'].' - '.$item['GioHen']) ?></td>
                    <td><?= $item['BacSi'] ?? "<span class='text-danger'>Chưa phân</span>" ?></td>
                    <td><span style="color:<?= $colors[$item['TrangThai']]??'black' ?>;font-weight:bold;"><?= htmlspecialchars($item['TrangThai']) ?></span></td>
                    <td>
                        <form method="POST" action="index.php?controller=AdminController&action=capNhatTrangThaiLich">
                            <input type="hidden" name="maLich" value="<?= $item['MaLich'] ?>">
                            <select name="trangThai" class="form-select" onchange="this.form.submit()">
                                <option value="" disabled selected>Chọn hành động</option>
                                <?php foreach(array_keys($colors) as $tt): ?>
                                    <option value="<?= $tt ?>"><?= $tt ?></option>
                                <?php endforeach; ?>
                            </select>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


<?php include 'layout/footer.php'; ?>



