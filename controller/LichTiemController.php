<?php
namespace PetCare;


require_once __DIR__ . '/../config/database.php';


class LichTiemController {
   public function hienThiLichTiem() {
       if (session_status() === PHP_SESSION_NONE) {
           session_start();
       }


       if (!isset($_SESSION['maTK'])) {
           header("Location: " . BASE_URL . "/customer/index.php?controller=XacThucController&action=hienThiDangNhap");
           exit();
       }


       // ✅ Gọi đúng class Database có namespace
       $db = new \PetCare\Database();
       $conn = $db->getConnection();


       $maTK = $_SESSION['maTK'];


       // 🔹 Lấy mã khách hàng
       $sql_kh = "SELECT MaKH FROM khachhang WHERE MaTK = :maTK";
       $stmt = $conn->prepare($sql_kh);
       $stmt->bindParam(':maTK', $maTK, \PDO::PARAM_INT);
       $stmt->execute();
       $row = $stmt->fetch();
       $maKH = $row['MaKH'] ?? null;


       if (!$maKH) {
           die("Không tìm thấy thông tin khách hàng.");
       }


       // 🔹 Lấy lịch tiêm sắp tới
       $sql = "SELECT dl.*, tc.TenTC, tp.TenThuoc
               FROM datlich dl
               JOIN thucung tc ON dl.MaTC = tc.MaTC
               JOIN tiemphong tp ON dl.MaTP = tp.MaTP
               WHERE dl.MaKH = :maKH AND dl.NgayHen >= CURDATE()
               ORDER BY dl.NgayHen ASC, dl.GioHen ASC";


       $stmt = $conn->prepare($sql);
       $stmt->bindParam(':maKH', $maKH, \PDO::PARAM_INT);
       $stmt->execute();
       $lichTiem = $stmt->fetchAll();


       include __DIR__ . '/../customer/views/lich_tiem.php';
   }
}



