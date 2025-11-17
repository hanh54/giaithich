<?php
namespace PetCare;

class KhachHangController {
    private $conn;
    private $thongBaoLoi = '';
    private $hienThiFormThem = false;

    public function __construct() {
        global $conn;
        if (!$conn) {
            throw new \Exception("Kết nối cơ sở dữ liệu không tồn tại!");
        }
        $this->conn = $conn;
    }

    public function hienThiHoSo() {
        if (!isset($_SESSION['maTK'])) {
            header("Location: index.php?controller=XacThucController&action=hienThiDangNhap");
            exit;
        }

        if ($_SESSION['vaiTro'] === 'Admin') {
            $this->thongBaoLoi = 'Quản trị viên không thể xem hồ sơ khách hàng!';
            header("Location: index.php?controller=DichVuController&action=hienThiDanhSachDichVu");
            exit;
        }

        $maKH = $this->getMaKHByMaTK($_SESSION['maTK']);
        if (!$maKH) {
            $this->thongBaoLoi = 'Không tìm thấy thông tin khách hàng!';
            header("Location: index.php?controller=TrangChuController&action=hienThiTrangChu");
            exit;
        }

        $thongTinKhachHang = $this->getThongTinKhachHang($maKH);
        $thuCungList = $this->getThuCungCuaKhachHang($maKH);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['capNhat'])) {
                $this->xuLyCapNhatThongTin($maKH);
            } elseif (isset($_POST['themThuCung'])) {
                $this->xuLyThemThuCung($maKH);
            } elseif (isset($_POST['hienThiFormThem'])) { // Sửa điều kiện
                $this->hienThiFormThem = true;
            }
        }

        $controller = $this;
        include '../customer/views/ho_so.php';
    }

    private function xuLyCapNhatThongTin($maKH) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hoTen = trim($_POST['hoTen'] ?? '');
            $sdt = trim($_POST['sdt'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $diaChi = trim($_POST['diaChi'] ?? '');
            $ghiChu = trim($_POST['ghiChu'] ?? '');

            if (empty($hoTen) || empty($sdt) || empty($email)) {
                $this->thongBaoLoi = 'Vui lòng điền đầy đủ họ tên, số điện thoại và email!';
                return;
            }

            try {
                $maTK = $this->getMaTKByMaKH($maKH);
                if ($maTK) {
                    $sql = "UPDATE taikhoan SET Email = ? WHERE MaTK = ?";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindParam(1, $email, \PDO::PARAM_STR);
                    $stmt->bindParam(2, $maTK, \PDO::PARAM_INT);
                    $stmt->execute();
                }

                $sql = "UPDATE khachhang SET HoTen = ?, SDT = ?, Email = ?, DiaChi = ?, GhiChu = ? WHERE MaKH = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(1, $hoTen, \PDO::PARAM_STR);
                $stmt->bindParam(2, $sdt, \PDO::PARAM_STR);
                $stmt->bindParam(3, $email, \PDO::PARAM_STR);
                $stmt->bindParam(4, $diaChi, \PDO::PARAM_STR);
                $stmt->bindParam(5, $ghiChu, \PDO::PARAM_STR);
                $stmt->bindParam(6, $maKH, \PDO::PARAM_INT);

                if ($stmt->execute()) {
                    $this->thongBaoLoi = 'Cập nhật thông tin thành công!';
                } else {
                    $this->thongBaoLoi = 'Cập nhật thất bại! Vui lòng thử lại.';
                }
            } catch (\Exception $e) {
                $this->thongBaoLoi = "Lỗi hệ thống: " . $e->getMessage();
            }
        }
    }

    private function xuLyThemThuCung($maKH) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tenTC = trim($_POST['tenTC'] ?? '');
            $loai = trim($_POST['loai'] ?? '');
            $giong = trim($_POST['giong'] ?? '');
            $ngaySinh = trim($_POST['ngaySinh'] ?? '');
            $canNang = trim($_POST['canNang'] ?? '');
            $gioiTinh = trim($_POST['gioiTinh'] ?? '');
            $tinhTrangSucKhoe = trim($_POST['tinhTrangSucKhoe'] ?? '');
            $lichSuTiem = trim($_POST['lichSuTiem'] ?? '');
            $hinhAnh = trim($_POST['hinhAnh'] ?? '');

            if (empty($tenTC) || empty($loai) || empty($giong) || empty($ngaySinh) || empty($canNang) || empty($gioiTinh)) {
                $this->thongBaoLoi = 'Vui lòng điền đầy đủ thông tin cơ bản!';
                return;
            }

            try {
                $sql = "INSERT INTO thucung (MaKH, TenTC, Loai, Giong, NgaySinh, CanNang, GioiTinh, TinhTrangSucKhoe, LichSuTiem, HinhAnh, CreatedAt) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(1, $maKH, \PDO::PARAM_INT);
                $stmt->bindParam(2, $tenTC, \PDO::PARAM_STR);
                $stmt->bindParam(3, $loai, \PDO::PARAM_STR);
                $stmt->bindParam(4, $giong, \PDO::PARAM_STR);
                $stmt->bindParam(5, $ngaySinh, \PDO::PARAM_STR);
                $stmt->bindParam(6, $canNang, \PDO::PARAM_STR);
                $stmt->bindParam(7, $gioiTinh, \PDO::PARAM_STR);
                $stmt->bindParam(8, $tinhTrangSucKhoe, \PDO::PARAM_STR);
                $stmt->bindParam(9, $lichSuTiem, \PDO::PARAM_STR);
                $stmt->bindParam(10, $hinhAnh, \PDO::PARAM_STR);

                if ($stmt->execute()) {
                    $this->thongBaoLoi = 'Thêm thú cưng thành công!';
                    $this->hienThiFormThem = false; // Ẩn form sau khi thêm thành công
                } else {
                    $this->thongBaoLoi = 'Thêm thú cưng thất bại! Vui lòng thử lại.';
                }
            } catch (\Exception $e) {
                $this->thongBaoLoi = "Lỗi hệ thống: " . $e->getMessage();
            }
        }
    }



    private function getThongTinKhachHang($maKH) {
        try {
            $sql = "SELECT kh.*, tk.Email AS EmailTaiKhoan 
                    FROM khachhang kh 
                    LEFT JOIN taikhoan tk ON kh.MaTK = tk.MaTK 
                    WHERE kh.MaKH = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $maKH, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC) ?: [];
        } catch (\Exception $e) {
            $this->thongBaoLoi = "Lỗi: " . $e->getMessage();
            return [];
        }
    }

    private function getThuCungCuaKhachHang($maKH) {
        try {
            $sql = "SELECT MaTC, TenTC, Giong FROM thucung WHERE MaKH = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $maKH, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            $this->thongBaoLoi = "Lỗi khi lấy danh sách thú cưng: " . $e->getMessage();
            return [];
        }
    }

    private function getMaKHByMaTK($maTK) {
        try {
            $sql = "SELECT MaKH FROM khachhang WHERE MaTK = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $maTK, \PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result['MaKH'] ?? null;
        } catch (\Exception $e) {
            return null;
        }
    }

    private function getMaTKByMaKH($maKH) {
        try {
            $sql = "SELECT MaTK FROM khachhang WHERE MaKH = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $maKH, \PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result['MaTK'] ?? null;
        } catch (\Exception $e) {
            return null;
        }
    }

    private function getThongTinThuCung($maTC) {
        try {
            $sql = "SELECT * FROM thucung WHERE MaTC = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $maTC, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC) ?: [];
        } catch (\Exception $e) {
            $this->thongBaoLoi = "Lỗi khi lấy thông tin thú cưng: " . $e->getMessage();
            return [];
        }
    }

    public function getThongBaoLoi() {
        return $this->thongBaoLoi;
    }

    public function getHienThiFormThem() {
        return $this->hienThiFormThem;
    }
}
?>