<?php
namespace PetCare;

require_once '../classes/TaiKhoan.php';
require_once '../classes/KhachHang.php'; // Thêm lớp KhachHang

use PetCare\TaiKhoan;
use PetCare\KhachHang;

/**
 * Bộ điều khiển xử lý đăng nhập, đăng xuất và đăng ký
 */
class XacThucController {
    private $taiKhoan;          // Đối tượng quản lý tài khoản
    private $khachHang;         // Đối tượng quản lý khách hàng
    private $tenDangNhap;       // Tên đăng nhập từ form
    private $matKhau;           // Mật khẩu từ form
    private $email;             // Email từ form
    private $thongBaoLoi;       // Thông báo lỗi (nếu có)

    /**
     * Hàm khởi tạo, khởi tạo đối tượng TaiKhoan và KhachHang
     */
    public function __construct() {
        $this->taiKhoan = new TaiKhoan();
        $this->khachHang = new KhachHang();
        $this->thongBaoLoi = '';
    }

    /**
     * Hiển thị trang đăng nhập
     */
    public function hienThiDangNhap() {
        if (isset($_SESSION['maTK'])) {
            if ($_SESSION['vaiTro'] === 'Admin') {
                header('Location: ../admin/index.php');
            } else {
                header('Location: ../customer/index.php?controller=TrangChuController&action=hienThiTrangChu');
            }
            exit;
        }
        $xacThucController = $this;
        include '../customer/views/xac_thuc/dang_nhap.php';
    }

    /**
     * Xử lý đăng nhập
     */
    public function xuLyDangNhap() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->tenDangNhap = filter_input(INPUT_POST, 'tenDangNhap', FILTER_SANITIZE_STRING);
            $this->matKhau = filter_input(INPUT_POST, 'matKhau', FILTER_SANITIZE_STRING);

            if ($this->taiKhoan->readByTenDangNhap($this->tenDangNhap)) {
                if ($this->taiKhoan->kiemTraMatKhau($this->matKhau)) {
                    $_SESSION['maTK'] = $this->taiKhoan->getMaTK();
                    $_SESSION['vaiTro'] = $this->taiKhoan->getVaiTro();
                    if ($_SESSION['vaiTro'] === 'Admin') {
                        header('Location: ../admin/index.php');
                    } else {
                        header('Location: ../customer/index.php?controller=TrangChuController&action=hienThiTrangChu');
                    }
                    exit;
                } else {
                    $this->thongBaoLoi = 'Mật khẩu không đúng!';
                }
            } else {
                $this->thongBaoLoi = 'Tên đăng nhập không tồn tại!';
            }
        }
        $xacThucController = $this;
        include '../customer/views/xac_thuc/dang_nhap.php';
    }

    /**
     * Hiển thị trang đăng ký
     */
    public function hienThiDangKy() {
        if (isset($_SESSION['maTK'])) {
            if ($_SESSION['vaiTro'] === 'Admin') {
                header('Location: ../admin/index.php');
            } else {
                header('Location: ../customer/index.php?controller=TrangChuController&action=hienThiTrangChu');
            }
            exit;
        }
        $xacThucController = $this;
        include '../customer/views/xac_thuc/dang_ky.php';
    }

    /**
     * Xử lý đăng ký
     */
    public function xuLyDangKy() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $this->tenDangNhap = filter_input(INPUT_POST, 'tenDangNhap', FILTER_SANITIZE_STRING);
        $this->matKhau = filter_input(INPUT_POST, 'matKhau', FILTER_SANITIZE_STRING);
        $this->email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $hoTen = filter_input(INPUT_POST, 'hoTen', FILTER_SANITIZE_STRING);
        $sdt = filter_input(INPUT_POST, 'sdt', FILTER_SANITIZE_STRING);
        $diaChi = filter_input(INPUT_POST, 'diaChi', FILTER_SANITIZE_STRING) ?? '';

        if (empty($this->tenDangNhap) || empty($this->matKhau) || empty($this->email) || empty($hoTen) || empty($sdt)) {
            $this->thongBaoLoi = 'Vui lòng điền đầy đủ thông tin bắt buộc!';
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->thongBaoLoi = 'Email không hợp lệ!';
        } elseif ($this->taiKhoan->kiemTraTonTaiTenDangNhap($this->tenDangNhap)) {
            $this->thongBaoLoi = 'Tên đăng nhập đã tồn tại!';
        } elseif ($this->taiKhoan->kiemTraTonTaiEmail($this->email)) {
            $this->thongBaoLoi = 'Email đã được sử dụng!';
        } else {
            try {
                $maTK = $this->taiKhoan->taoTaiKhoan($this->tenDangNhap, $this->matKhau, $this->email);
                if ($maTK) {
                    if ($this->khachHang->create($maTK, $hoTen, $sdt, $this->email, $diaChi, null)) {
                        $this->thongBaoLoi = 'Đăng ký thành công! Vui lòng đăng nhập.';
                        header('Location: ../customer/index.php?controller=XacThucController&action=hienThiDangNhap');
                        exit;
                    } else {
                        $this->thongBaoLoi = 'Đăng ký thất bại khi tạo thông tin khách hàng!';
                        // Xóa tài khoản nếu thất bại
                        $this->taiKhoan->delete($maTK);
                    }
                } else {
                    $this->thongBaoLoi = 'Đăng ký thất bại khi tạo tài khoản!';
                }
            } catch (\Exception $e) {
                $this->thongBaoLoi = 'Lỗi hệ thống: ' . $e->getMessage();
            }
        }
    }
    $xacThucController = $this;
    include '../customer/views/xac_thuc/dang_ky.php';
}
    /**
     * Xử lý đăng xuất
     */
    public function xuLyDangXuat() {
        session_start();
        session_destroy();
        header('Location: ../customer/index.php');
        exit;
    }

    /**
     * Lấy thông báo lỗi
     * @return string
     */
    public function getThongBaoLoi() {
        return $this->thongBaoLoi;
    }
}
?>