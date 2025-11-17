<?php
namespace PetCare;


require_once __DIR__ . '/../config/database.php';


class LichSuTiemController {
   public function hienThiLichSu() {
       if (session_status() === PHP_SESSION_NONE) {
           session_start();
       }


       if (!isset($_SESSION['maTK'])) {
           header("Location: " . BASE_URL . "/customer/index.php?controller=XacThucController&action=hienThiDangNhap");
           exit();
       }


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


       // 🔹 Lấy lịch sử tiêm, đồng thời đếm số mũi đã tiêm của mỗi vắc-xin theo thú cưng
       $sql = "SELECT
                   lstp.*,
                   tc.TenTC,
                   tp.TenThuoc,
                   nv.HoTen AS BacSi,
                   (
                       SELECT COUNT(*)
                       FROM lichsutiemphong AS sub
                       WHERE sub.MaTP = lstp.MaTP
                         AND sub.MaTC = lstp.MaTC
                   ) AS SoMuiDaTiem
               FROM lichsutiemphong lstp
               JOIN thucung tc ON lstp.MaTC = tc.MaTC
               LEFT JOIN tiemphong tp ON lstp.MaTP = tp.MaTP
               LEFT JOIN nhanvien nv ON lstp.MaNV_Tiem = nv.MaNV
               WHERE tc.MaKH = :maKH
               ORDER BY lstp.NgayTiem DESC";


       $stmt = $conn->prepare($sql);
       $stmt->bindParam(':maKH', $maKH, \PDO::PARAM_INT);
       $stmt->execute();
       $lichSuTiem = $stmt->fetchAll();


       include __DIR__ . '/../customer/views/lich_su_tiem.php';
   }
}



