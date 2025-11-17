<?php
namespace PetCare;

/**
 * Bộ điều khiển xử lý các chức năng liên quan đến dịch vụ tiêm phòng
 */
class DichVuController {
    private $conn;
    private $thongBaoLoi = '';

    public function __construct() {
        global $conn;
        if (!$conn) {
            throw new \Exception("Kết nối cơ sở dữ liệu không tồn tại!");
        }
        $this->conn = $conn;
    }

    public function hienThiDanhSachDichVu() {
        if (isset($_SESSION['maTK']) && $_SESSION['vaiTro'] === 'Admin') {
            header('Location: ../admin/index.php');
            exit;
        }
        $danhSachDichVu = $this->getDanhSachDichVuHoatDong();
        $controller = $this;
        include '../customer/views/danh_sach_dich_vu.php';
    }

    public function hienThiChiTietDichVu($maTP) {
        if (isset($_SESSION['maTK']) && $_SESSION['vaiTro'] === 'Admin') {
            header('Location: ../admin/index.php');
            exit;
        }
        if (!isset($maTP) || !is_numeric($maTP)) {
            $this->thongBaoLoi = 'Mã dịch vụ không hợp lệ!';
            $controller = $this;
            include '../customer/views/danh_sach_dich_vu.php';
            return;
        }
        $dichVu = $this->getDichVuByMaTP($maTP);
        if ($dichVu) {
            $controller = $this;
            include '../customer/views/chi_tiet_dich_vu.php';
        } else {
            $this->thongBaoLoi = 'Dịch vụ không tồn tại hoặc không hoạt động!';
            $controller = $this;
            include '../customer/views/danh_sach_dich_vu.php';
        }
    }

    public function datLichTuDichVu($maTP) {
        if (!isset($_SESSION['maTK'])) {
            header("Location: index.php?controller=XacThucController&action=hienThiDangNhap");
            exit;
        }
        if ($_SESSION['vaiTro'] === 'Admin') {
            $this->thongBaoLoi = 'Quản trị viên không thể đặt lịch!';
            $controller = $this;
            include '../customer/views/chi_tiet_dich_vu.php';
            exit;
        }
        if (!isset($maTP) || !is_numeric($maTP)) {
            $this->thongBaoLoi = 'Mã dịch vụ không hợp lệ!';
            $controller = $this;
            include '../customer/views/danh_sach_dich_vu.php';
            exit;
        }

        $maKH = $this->getMaKHByMaTK($_SESSION['maTK']);
        error_log("Debug datLichTuDichVu: maTK=" . ($_SESSION['maTK'] ?? 'null') . ", maKH=" . ($maKH ?? 'null'));
        if (!$maKH) {
            $this->thongBaoLoi = 'Không tìm thấy thông tin khách hàng!';
            $controller = $this;
            include '../customer/views/chi_tiet_dich_vu.php';
            exit;
        }

        $thuCungList = $this->getThuCungCuaKhachHang($maKH);
        error_log("Debug datLichTuDichVu: maKH=$maKH, thuCungList=" . print_r($thuCungList, true));
        if (empty($thuCungList)) {
            $this->thongBaoLoi = 'Vui lòng thêm thú cưng trước khi đặt lịch.';
            $controller = $this;
            include '../customer/views/chi_tiet_dich_vu.php';
            exit;
        }

        $dichVu = $this->getDichVuByMaTP($maTP);
        error_log("Debug datLichTuDichVu: maTP=$maTP, dichVu=" . print_r($dichVu, true));
        if (!$dichVu) {
            $this->thongBaoLoi = "Dịch vụ không tồn tại hoặc không khả dụng! MaTP: $maTP";
            $controller = $this;
            include '../customer/views/chi_tiet_dich_vu.php';
            exit;
        }

        $_SESSION['dichVu'] = $dichVu;
        $_SESSION['maTP'] = $maTP; // Lưu maTP vào session
        header("Location: index.php?controller=DatLichController&action=hienThiDatLich&maTP=" . urlencode($maTP)); // Truyền maTP qua URL
        exit;
    }

    private function getDanhSachDichVuHoatDong() {
        try {
            $sql = "SELECT MaTP, TenThuoc, MoTa, Gia, LoaiThuCung, HinhAnh FROM tiemphong WHERE TrangThai = 'HoatDong' ORDER BY Gia ASC";
            $stmt = $this->conn->prepare($sql);
            if ($stmt === false) {
                throw new \Exception("Lỗi chuẩn bị câu lệnh SQL: " . $this->conn->errorInfo()[2]);
            }
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            $this->thongBaoLoi = "Lỗi khi lấy danh sách dịch vụ: " . $e->getMessage();
            return [];
        }
    }

    private function getDichVuByMaTP($maTP) {
        try {
            $sql = "SELECT MaTP, TenThuoc, MoTa, Gia, LoaiThuCung, SoLanTiem, ThoiLuong, HinhAnh FROM tiemphong WHERE MaTP = ? AND TrangThai = 'HoatDong'";
            $stmt = $this->conn->prepare($sql);
            if ($stmt === false) {
                throw new \Exception("Lỗi chuẩn bị câu lệnh SQL: " . $this->conn->errorInfo()[2]);
            }
            $stmt->bindParam(1, $maTP, \PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            if (!$result) {
                error_log("Không tìm thấy vắc-xin với MaTP=$maTP. Kiểm tra bảng tiemphong.");
            }
            return $result;
        } catch (\Exception $e) {
            $this->thongBaoLoi = "Lỗi khi lấy thông tin vắc-xin: " . $e->getMessage();
            return null;
        }
    }

    private function getThuCungCuaKhachHang($maKH) {
        try {
            $sql = "SELECT MaTC, TenTC, Loai, Giong FROM thucung WHERE MaKH = ?"; // Tạm loại bỏ TrangThai để test
            $stmt = $this->conn->prepare($sql);
            if ($stmt === false) {
                throw new \Exception("Lỗi chuẩn bị câu lệnh SQL: " . $this->conn->errorInfo()[2]);
            }
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
            if ($stmt === false) {
                throw new \Exception("Lỗi chuẩn bị câu lệnh SQL: " . $this->conn->errorInfo()[2]);
            }
            $stmt->bindParam(1, $maTK, \PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result ? $result['MaKH'] : null;
        } catch (\Exception $e) {
            $this->thongBaoLoi = "Lỗi khi lấy thông tin khách hàng: " . $e->getMessage();
            return null;
        }
    }

    private function render($view, $params = []) {
        $controller = $this;
        extract($params);
        include "../customer/views/$view.php";
    }

    public function getThongBaoLoi() {
        return $this->thongBaoLoi;
    }
}
?>