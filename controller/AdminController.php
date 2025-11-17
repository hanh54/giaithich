<?php
namespace PetCare;


class AdminController {
    private $conn;


    public function __construct() {
        global $conn;


        if (!isset($_SESSION['maTK']) || $_SESSION['vaiTro'] !== 'Admin') {
            header('Location: ../customer/index.php?controller=XacThucController&action=hienThiDangNhap');
            exit;
        }


        $this->conn = $conn;
    }


    // Trang chủ admin
    public function hienThiTrangChu() {
        $soLoaiThuoc = $this->demLoaiThuoc();
        $soLichHen = $this->demLichHenHomNay();


        $controller = $this;
        include '../admin/views/trang_chu.php';
    }

private function demLoaiThuoc() {
    $sql = "SELECT COUNT(DISTINCT TenThuoc) AS soLoaiThuoc FROM tiemphong";
    $stmt = $this->conn->query($sql);
    return $stmt->fetch(\PDO::FETCH_ASSOC)['soLoaiThuoc'] ?? 0;
}


    private function demLichHenHomNay() {
        $sql = "SELECT COUNT(*) AS soLH FROM datlich WHERE NgayHen = CURDATE()";
        $stmt = $this->conn->query($sql);
        return $stmt->fetch(\PDO::FETCH_ASSOC)['soLH'] ?? 0;
    }
// ================================
   // 💉 QUẢN LÝ VẮC-XIN
   // ================================
   public function quanLyVacXin() {
       // ✅ Khi admin gửi form thêm/sửa/xóa
       if ($_SERVER['REQUEST_METHOD'] === 'POST') {
           $action = $_POST['action'] ?? '';
           $maTP = $_POST['MaTP'] ?? null;
           $ten = $_POST['TenThuoc'] ?? '';
           $moTa = $_POST['MoTa'] ?? '';
           $gia = $_POST['Gia'] ?? 0;
           $hinh = $_POST['HinhAnh'] ?? '';
           $trangThai = $_POST['TrangThai'] ?? 1;


           switch ($action) {
               case 'add':
                   $stmt = $this->conn->prepare("
                       INSERT INTO tiemphong (TenThuoc, MoTa, Gia, HinhAnh, TrangThai)
                       VALUES (:TenThuoc, :MoTa, :Gia, :HinhAnh, :TrangThai)
                   ");
                   $stmt->execute([
                       ':TenThuoc' => $ten,
                       ':MoTa' => $moTa,
                       ':Gia' => $gia,
                       ':HinhAnh' => $hinh,
                       ':TrangThai' => $trangThai
                   ]);
                   break;


               case 'edit':
                   $stmt = $this->conn->prepare("
                       UPDATE tiemphong
                       SET TenThuoc=:TenThuoc, MoTa=:MoTa, Gia=:Gia, HinhAnh=:HinhAnh, TrangThai=:TrangThai
                       WHERE MaTP=:MaTP
                   ");
                   $stmt->execute([
                       ':TenThuoc' => $ten,
                       ':MoTa' => $moTa,
                       ':Gia' => $gia,
                       ':HinhAnh' => $hinh,
                       ':TrangThai' => $trangThai,
                       ':MaTP' => $maTP
                   ]);
                   break;


               case 'delete':
                   $stmt = $this->conn->prepare("DELETE FROM tiemphong WHERE MaTP = :MaTP");
                   $stmt->execute([':MaTP' => $maTP]);
                   break;
           }


           header("Location: index.php?controller=AdminController&action=quanLyVacXin");
           exit;
       }


       // ✅ Hiển thị danh sách vắc-xin
       $stmt = $this->conn->query("SELECT * FROM tiemphong ORDER BY MaTP DESC");
       $vaccines = $stmt->fetchAll(\PDO::FETCH_ASSOC);


      $viewPath = dirname(__DIR__) . '/admin/views/quan_ly_vac_xin.php';


if (file_exists($viewPath)) {
   include $viewPath;
} else {
   die("❌ Không tìm thấy file view: " . $viewPath);
}


   }

    /* ============================================================
       QUẢN LÝ ĐẶT LỊCH
       ============================================================ */
    public function quanLyDatLich() {
        $sql = "SELECT dl.*, kh.HoTen AS TenKH, tc.TenTC, tp.TenThuoc, nv.HoTen AS BacSi
                FROM DatLich dl
                LEFT JOIN KhachHang kh ON dl.MaKH = kh.MaKH
                LEFT JOIN ThuCung tc ON dl.MaTC = tc.MaTC
                LEFT JOIN tiemphong tp ON dl.MaTP = tp.MaTP
                LEFT JOIN NhanVien nv ON dl.MaNV_DuKien = nv.MaNV
                ORDER BY dl.NgayHen DESC, dl.GioHen DESC";


        $stmt = $this->conn->query($sql);
        $danhSach = $stmt->fetchAll(\PDO::FETCH_ASSOC);


        include '../admin/views/quan_ly_dat_lich.php';
    }


    // Cập nhật trạng thái lịch
    public function capNhatTrangThaiLich() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maLich = $_POST['maLich'] ?? '';
            $trangThai = $_POST['trangThai'] ?? '';


            if ($maLich && $trangThai) {
                $stmt = $this->conn->prepare("UPDATE DatLich SET TrangThai = ? WHERE MaLich = ?");
                $stmt->execute([$trangThai, $maLich]);
            }


            header("Location: index.php?controller=AdminController&action=quanLyDatLich");
            exit;
        }
    }

}





?>



