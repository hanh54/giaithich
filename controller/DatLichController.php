<?php
namespace PetCare;

/**
 * Bộ điều khiển xử lý các chức năng liên quan đến đặt lịch tiêm phòng
 */
class DatLichController {
    private $conn;
    private $thongBaoLoi = '';

    public function __construct() {
        global $conn;
        if (!$conn) {
            throw new \Exception("Kết nối cơ sở dữ liệu không tồn tại!");
        }
        $this->conn = $conn;
    }

    public function hienThiDatLich($maTP = null) {
        if (!isset($_SESSION['maTK'])) {
            header("Location: index.php?controller=XacThucController&action=hienThiDangNhap");
            exit;
        }

        if ($_SESSION['vaiTro'] === 'Admin') {
            $this->thongBaoLoi = 'Quản trị viên không thể đặt lịch!';
            header("Location: index.php?controller=DichVuController&action=hienThiDanhSachDichVu");
            exit;
        }

        $maKH = $this->getMaKHByMaTK($_SESSION['maTK']);
        error_log("Debug hienThiDatLich: maTK=" . ($_SESSION['maTK'] ?? 'null') . ", maKH=" . ($maKH ?? 'null'));
        if (!$maKH) {
            $this->thongBaoLoi = 'Không tìm thấy thông tin khách hàng!';
            header("Location: index.php?controller=DichVuController&action=hienThiDanhSachDichVu");
            exit;
        }

        $thuCungList = $this->getThuCungCuaKhachHang($maKH);
        error_log("Debug hienThiDatLich: maKH=$maKH, thuCungList=" . print_r($thuCungList, true));
        if (empty($thuCungList)) {
            $this->thongBaoLoi = 'Vui lòng thêm thú cưng trước khi đặt lịch.';
            $controller = $this;
            include '../customer/views/dat_lich.php';
            exit;
        }

        // Lấy $maTP từ URL hoặc session
        $maTP = $maTP ?: ($_SESSION['maTP'] ?? null);
        $dichVu = isset($_SESSION['dichVu']) ? $_SESSION['dichVu'] : $this->getDichVuByMaTP($maTP);
        unset($_SESSION['dichVu']);
        unset($_SESSION['maTP']);
        error_log("Debug hienThiDatLich: maTP=" . ($maTP ?? 'null') . ", dichVu=" . print_r($dichVu, true));
        if ($maTP && !$dichVu) {
            $this->thongBaoLoi = "Dịch vụ không tồn tại hoặc không hoạt động! MaTP: $maTP";
            error_log("Dịch vụ không tìm thấy với MaTP: $maTP");
            $controller = $this;
            include '../customer/views/dat_lich.php';
            exit;
        }

        $lichDaDat = $this->getDanhSachLichDaDatToanHe();
        $controller = $this;
        include '../customer/views/dat_lich.php';
    }

    public function xuLyDatLich() {
        if (!isset($_SESSION['maTK'])) {
            header("Location: index.php?controller=XacThucController&action=hienThiDangNhap");
            exit;
        }

        if ($_SESSION['vaiTro'] === 'Admin') {
            $this->thongBaoLoi = 'Quản trị viên không thể đặt lịch!';
            header("Location: index.php?controller=DichVuController&action=hienThiDanhSachDichVu");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maKH = $this->getMaKHByMaTK($_SESSION['maTK']);
            $maTC = filter_input(INPUT_POST, 'maTC', FILTER_SANITIZE_NUMBER_INT);
            $maTP = filter_input(INPUT_POST, 'maTP', FILTER_SANITIZE_NUMBER_INT) ?: ($_GET['maTP'] ?? null);
            $ngayHen = filter_input(INPUT_POST, 'ngayHen', FILTER_SANITIZE_STRING);
            $gioHen = filter_input(INPUT_POST, 'gioHen', FILTER_SANITIZE_STRING);
            $ghiChu = filter_input(INPUT_POST, 'ghiChu', FILTER_SANITIZE_STRING) ?? '';

            error_log("Debug xuLyDatLich: maKH=$maKH, maTC=$maTC, maTP=$maTP, ngayHen=$ngayHen, gioHen=$gioHen, ghiChu=$ghiChu");

            if (!$maKH || !$maTC || !$maTP || !$ngayHen || !$gioHen) {
                $this->thongBaoLoi = 'Vui lòng điền đầy đủ thông tin!';
                $maKH = $this->getMaKHByMaTK($_SESSION['maTK']);
                $thuCungList = $this->getThuCungCuaKhachHang($maKH);
                $dichVu = $this->getDichVuByMaTP($maTP);
            } else {
                $gioBatDau = date('H:i:s', strtotime($gioHen . ' -15 minutes'));
                $gioKetThuc = date('H:i:s', strtotime($gioHen . ' +15 minutes'));
                if ($this->kiemTraTrungLichToanHe($ngayHen, $gioBatDau, $gioKetThuc)) {
                    $this->thongBaoLoi = 'Thời gian này đã có người đặt trong khoảng ±15 phút! Vui lòng chọn thời gian khác.';
                    $maKH = $this->getMaKHByMaTK($_SESSION['maTK']);
                    $thuCungList = $this->getThuCungCuaKhachHang($maKH);
                    $dichVu = $this->getDichVuByMaTP($maTP);
                } else {
                    $maNV = $this->ganBacSiDuKien($ngayHen, $gioHen);
                    if ($maNV === null) {
                        $this->thongBaoLoi = 'Không có bác sĩ sẵn sàng trong khung giờ này! Vui lòng chọn thời gian khác.';
                        $maKH = $this->getMaKHByMaTK($_SESSION['maTK']);
                        $thuCungList = $this->getThuCungCuaKhachHang($maKH);
                        $dichVu = $this->getDichVuByMaTP($maTP);
                    } else {
                        $tongTien = $this->getGiaTiemPhong($maTP);
                        $this->insertDatLich($maKH, $maTC, $maTP, $maNV, $ngayHen, $gioHen, $ghiChu, $tongTien);
                    }
                }
            }
        }

        $controller = $this;
        include '../customer/views/dat_lich.php';
    }

    
    public function huyLichHen($maLich) {
        if (!isset($_SESSION['maTK'])) {
            header("Location: index.php?controller=XacThucController&action=hienThiDangNhap");
            exit;
        }

        if ($_SESSION['vaiTro'] === 'Admin') {
            $this->thongBaoLoi = 'Quản trị viên không thể hủy lịch hẹn!';
            header("Location: index.php?controller=DichVuController&action=hienThiDanhSachDichVu");
            exit;
        }

        $maKH = $this->getMaKHByMaTK($_SESSION['maTK']);
        if (!$maKH) {
            $this->thongBaoLoi = 'Không tìm thấy thông tin khách hàng!';
            header("Location: index.php?controller=DichVuController&action=hienThiDanhSachDichVu");
            exit;
        }

        if (!isset($maLich) || !is_numeric($maLich)) {
            $this->thongBaoLoi = 'Mã lịch hẹn không hợp lệ!';
            $this->render('DatLich');
            exit;
        }

        $this->deleteLichHen($maLich, $maKH);
        $this->render('DatLich');
    }

    private function insertDatLich($maKH, $maTC, $maTP, $maNV, $ngayHen, $gioHen, $ghiChu, $tongTien) {
        try {
            $sql = "INSERT INTO DatLich (MaKH, MaTC, MaTP, MaNV_DuKien, NgayHen, GioHen, GhiChu, TrangThai, TongTien) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            if ($stmt === false) {
                throw new \Exception("Lỗi chuẩn bị câu lệnh SQL: " . $this->conn->errorInfo()[2]);
            }
            $trangThai = 'Chờ xác nhận';
            $stmt->bindParam(1, $maKH, \PDO::PARAM_INT);
            $stmt->bindParam(2, $maTC, \PDO::PARAM_INT);
            $stmt->bindParam(3, $maTP, \PDO::PARAM_INT);
            $stmt->bindParam(4, $maNV, \PDO::PARAM_INT);
            $stmt->bindParam(5, $ngayHen, \PDO::PARAM_STR);
            $stmt->bindParam(6, $gioHen, \PDO::PARAM_STR);
            $stmt->bindParam(7, $ghiChu, \PDO::PARAM_STR);
            $stmt->bindParam(8, $trangThai, \PDO::PARAM_STR);
            $stmt->bindParam(9, $tongTien, \PDO::PARAM_STR);

            if ($stmt->execute()) {
                $this->thongBaoLoi = 'Đặt lịch thành công! Vui lòng chờ xác nhận.';
                header("Location: index.php?controller=TrangChuController&action=hienThiTrangChu");
                exit;
            } else {
                $this->thongBaoLoi = 'Đặt lịch thất bại! Error: ' . implode(", ", $stmt->errorInfo());
            }
        } catch (\Exception $e) {
            $this->thongBaoLoi = "Lỗi khi đặt lịch: " . $e->getMessage();
        }
    }

    private function deleteLichHen($maLich, $maKH) {
        try {
            $sql = "DELETE FROM DatLich WHERE MaLich = ? AND MaKH = ? AND TrangThai = 'Chờ xác nhận'";
            $stmt = $this->conn->prepare($sql);
            if ($stmt === false) {
                throw new \Exception("Lỗi chuẩn bị câu lệnh SQL: " . $this->conn->errorInfo()[2]);
            }
            $stmt->bindParam(1, $maLich, \PDO::PARAM_INT);
            $stmt->bindParam(2, $maKH, \PDO::PARAM_INT);
            if ($stmt->execute()) {
                $this->thongBaoLoi = 'Hủy lịch hẹn thành công!';
            } else {
                $this->thongBaoLoi = 'Hủy lịch hẹn thất bại! Vui lòng thử lại.';
            }
        } catch (\Exception $e) {
            $this->thongBaoLoi = "Lỗi khi hủy lịch hẹn: " . $e->getMessage();
        }
    }

    private function getDanhSachLichHen() {
        try {
            $maKH = $this->getMaKHByMaTK($_SESSION['maTK']);
            $sql = "SELECT dl.MaLich, tc.TenTC, tp.TenThuoc, dl.NgayHen, dl.GioHen, dl.TrangThai, nv.HoTen AS BacSi 
                    FROM DatLich dl 
                    LEFT JOIN ThuCung tc ON dl.MaTC = tc.MaTC 
                    LEFT JOIN tiemphong tp ON dl.MaTP = tp.MaTP 
                    LEFT JOIN NhanVien nv ON dl.MaNV_DuKien = nv.MaNV 
                    WHERE dl.MaKH = ? 
                    ORDER BY dl.NgayHen DESC, dl.GioHen DESC";
            $stmt = $this->conn->prepare($sql);
            if ($stmt === false) {
                throw new \Exception("Lỗi chuẩn bị câu lệnh SQL: " . $this->conn->errorInfo()[2]);
            }
            $stmt->bindParam(1, $maKH, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            $this->thongBaoLoi = "Lỗi khi lấy danh sách lịch hẹn: " . $e->getMessage();
            return [];
        }
    }

    private function getDanhSachLichDaDatToanHe() {
        try {
            $sql = "SELECT NgayHen, GioHen, TrangThai 
                    FROM DatLich 
                    WHERE TrangThai NOT IN ('Hủy') 
                    ORDER BY NgayHen DESC, GioHen DESC";
            $stmt = $this->conn->prepare($sql);
            if ($stmt === false) {
                throw new \Exception("Lỗi chuẩn bị câu lệnh SQL: " . $this->conn->errorInfo()[2]);
            }
            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            error_log("Danh sách lịch toàn hệ thống: " . print_r($result, true));
            return $result ?: [];
        } catch (\Exception $e) {
            $this->thongBaoLoi = "Lỗi khi lấy danh sách lịch đã đặt: " . $e->getMessage();
            return [];
        }
    }

    private function kiemTraTrungLichToanHe($ngayHen, $gioBatDau, $gioKetThuc) {
        try {
            $sql = "SELECT COUNT(*) as soLuong 
                    FROM DatLich 
                    WHERE NgayHen = ? 
                    AND GioHen BETWEEN ? AND ? 
                    AND TrangThai NOT IN ('Hủy')";
            $stmt = $this->conn->prepare($sql);
            if ($stmt === false) {
                throw new \Exception("Lỗi chuẩn bị câu lệnh SQL: " . $this->conn->errorInfo()[2]);
            }
            $stmt->bindParam(1, $ngayHen, \PDO::PARAM_STR);
            $stmt->bindParam(2, $gioBatDau, \PDO::PARAM_STR);
            $stmt->bindParam(3, $gioKetThuc, \PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result['soLuong'] > 0;
        } catch (\Exception $e) {
            $this->thongBaoLoi = "Lỗi khi kiểm tra trùng lịch: " . $e->getMessage();
            return false;
        }
    }

    private function ganBacSiDuKien($ngayHen, $gioHen) {
        try {
            $gioBatDau = date('H:i:s', strtotime($gioHen . ' -15 minutes'));
            $gioKetThuc = date('H:i:s', strtotime($gioHen . ' +15 minutes'));
            $sql = "SELECT nv.MaNV 
                    FROM NhanVien nv 
                    LEFT JOIN DatLich dl ON nv.MaNV = dl.MaNV_DuKien 
                        AND dl.NgayHen = ? AND dl.GioHen BETWEEN ? AND ? AND dl.TrangThai NOT IN ('Hủy') 
                    WHERE nv.ChucVu = 'Bác sỹ thú y' AND dl.MaNV_DuKien IS NULL 
                    LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            if ($stmt === false) {
                throw new \Exception("Lỗi chuẩn bị câu lệnh SQL: " . $this->conn->errorInfo()[2]);
            }
            $stmt->bindParam(1, $ngayHen, \PDO::PARAM_STR);
            $stmt->bindParam(2, $gioBatDau, \PDO::PARAM_STR);
            $stmt->bindParam(3, $gioKetThuc, \PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result ? $result['MaNV'] : null;
        } catch (\Exception $e) {
            $this->thongBaoLoi = "Lỗi khi gán bác sĩ: " . $e->getMessage();
            return null;
        }
    }

    private function getThuCungCuaKhachHang($maKH) {
        try {
            $sql = "SELECT MaTC, TenTC, Loai, Giong FROM thucung WHERE MaKH = ?"; // Tạm loại bỏ TrangThai
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
                error_log("Không tìm thấy vắc-xin với MaTP=$maTP");
            }
            return $result;
        } catch (\Exception $e) {
            $this->thongBaoLoi = "Lỗi khi lấy thông tin vắc-xin: " . $e->getMessage();
            return null;
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

    private function getGiaTiemPhong($maTP) {
        try {
            $sql = "SELECT Gia FROM tiemphong WHERE MaTP = ? AND TrangThai = 'HoatDong'";
            $stmt = $this->conn->prepare($sql);
            if ($stmt === false) {
                throw new \Exception("Lỗi chuẩn bị câu lệnh SQL: " . $this->conn->errorInfo()[2]);
            }
            $stmt->bindParam(1, $maTP, \PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result ? $result['Gia'] : 0.00;
        } catch (\Exception $e) {
            $this->thongBaoLoi = "Lỗi khi lấy giá vắc-xin: " . $e->getMessage();
            return 0.00;
        }
    }

    private function render($view) {
        $controller = $this;
        include "../customer/views/$view.php";
    }

    public function getThongBaoLoi() {
        return $this->thongBaoLoi;
    }
}
?>