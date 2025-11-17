<?php
session_start();

require_once '../config/database.php';
require_once '../controller/XacThucController.php';
require_once '../controller/TrangChuController.php';
require_once '../controller/DichVuController.php';
//require_once '../controller/ThuCungController.php';
require_once '../controller/DatLichController.php';
require_once '../controller/KhachHangController.php';
require_once '../controller/LichTiemController.php';
require_once '../controller/LichSuTiemController.php';


use PetCare\XacThucController;
use PetCare\TrangChuController;
use PetCare\DichVuController;
//use PetCare\ThuCungController;
use PetCare\DatLichController;
use PetCare\KhachHangController;
use PetCare\LichTiemController;
use PetCare\LichSuTiemController;


// Mặc định: nếu chưa có controller/action trong URL
$tenBoDieuKhien = $_GET['controller'] ?? 'TrangChuController';
$hanhDong = $_GET['action'] ?? 'hienThiTrangChu';

// Xử lý tham số cho các hành động cần tham số
$args = [];
if ($hanhDong === 'hienThiChiTietDichVu' || $hanhDong === 'datLichTuDichVu') {
    $maTP = isset($_GET['maTP']) ? (int)$_GET['maTP'] : null;
    if ($maTP === null) {
        // Nếu thiếu maTP, chuyển hướng về danh sách hoặc hiển thị lỗi
        header('Location: index.php?controller=DichVuController&action=hienThiDanhSachDichVu');
        exit;
    }
    $args[] = $maTP;
}

// Tạo controller và chạy
$tenLopBoDieuKhien = "PetCare\\$tenBoDieuKhien";

if (class_exists($tenLopBoDieuKhien)) {
    $boDieuKhien = new $tenLopBoDieuKhien();

    if (method_exists($boDieuKhien, $hanhDong)) {
        if (!empty($args)) {
            call_user_func_array([$boDieuKhien, $hanhDong], $args);
        } else {
            $boDieuKhien->$hanhDong();
        }
    } else {
        echo "<h3>❌ Không tìm thấy hành động '$hanhDong' trong $tenBoDieuKhien</h3>";
    }
} else {
    echo "<h3>❌ Không tìm thấy controller '$tenBoDieuKhien'</h3>";
}
?>