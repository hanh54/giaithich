<?php
namespace PetCare;

use PDO; // thêm dòng này để dùng hằng PDO::FETCH_ASSOC

/**
 * Bộ điều khiển xử lý trang chủ
 */
class TrangChuController {
    private $conn;

    /**
     * Hàm khởi tạo, kết nối cơ sở dữ liệu
     */
    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    /**
     * Hiển thị trang chủ
     */
    public function hienThiTrangChu() {
        $danhSachVacXin = $this->getDanhSachVacXinHoatDong();
        $lichHenGanDay = $this->getLichHenGanDay();

        $controller = $this;
        include '../customer/views/trang_chu.php';
    }

    /*
     *  Lấy danh sách vắc-xin đang hoạt động (DÙNG PDO)
     */
    private function getDanhSachVacXinHoatDong() {
        $sql = "SELECT MaTP, TenThuoc, MoTa, Gia, HinhAnh 
                FROM TiemPhong 
                WHERE TrangThai = 'HoatDong' 
                ORDER BY Gia ASC 
                LIMIT 3";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $vacXinList = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $vacXinList;
    }

    /**
     * Lấy lịch hẹn gần đây từ bảng DatLich (nếu khách hàng đã đăng nhập)
     */
    private function getLichHenGanDay() {
        if (isset($_SESSION['ma_kh'])) {
            $maKH = $_SESSION['ma_kh'];

            $sql = "SELECT dl.MaLich, dl.NgayHen, dl.GioHen, tp.TenThuoc
                    FROM DatLich dl
                    JOIN ThuCung tc ON dl.MaTC = tc.MaTC
                    JOIN ChiTietThanhToan ctt ON dl.MaLich = ctt.MaTT
                    JOIN TiemPhong tp ON ctt.MaTP = tp.MaTP
                    WHERE dl.MaKH = ?
                    ORDER BY dl.NgayHen DESC
                    LIMIT 3";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$maKH]); // 👈 Chuẩn PDO
            $lichHenList = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $lichHenList;
        }
        return [];
    }

    /**
     *  Hiển thị chi tiết lịch hẹn
     */
    public function hienThiChiTietLichHen($maLich) {
        $sql = "SELECT dl.MaLich, dl.NgayHen, dl.GioHen, dl.TrangThai, tc.TenTC, tp.TenThuoc
                FROM DatLich dl
                JOIN ThuCung tc ON dl.MaTC = tc.MaTC
                JOIN ChiTietThanhToan ctt ON dl.MaLich = ctt.MaTT
                JOIN TiemPhong tp ON ctt.MaTP = tp.MaTP
                WHERE dl.MaLich = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$maLich]);
        $lichHen = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($lichHen) {
            $controller = $this;
            include '../customer/views/chi_tiet_lich_hen.php';
        } else {
            include '../customer/views/thong_bao_loi.php';
            exit;
        }
    }
}
?>
