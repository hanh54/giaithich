<?php
namespace PetCare;

require_once 'config/database.php';

class BaoCaoThongKe {
    private $maBCTK;
    private $maNV_Tao;
    private $tenBaoCao;
    private $thoiGianBatDau;
    private $thoiGianKetThuc;
    private $tongDoanhThu;
    private $tongSoLuongDV;
    private $soKhachHangMoi;
    private $noiDung;
    private $ngayTao;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function create($maNV_Tao, $tenBaoCao, $thoiGianBatDau, $thoiGianKetThuc, $tongDoanhThu, $tongSoLuongDV, $soKhachHangMoi, $noiDung) {
        $query = "INSERT INTO BaoCaoThongKe (MaNV_Tao, TenBaoCao, ThoiGianBatDau, ThoiGianKetThuc, TongDoanhThu, TongSoLuongDV, SoKhachHangMoi, NoiDung) 
                  VALUES (:maNV_Tao, :tenBaoCao, :thoiGianBatDau, :thoiGianKetThuc, :tongDoanhThu, :tongSoLuongDV, :soKhachHangMoi, :noiDung)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maNV_Tao', $maNV_Tao);
        $stmt->bindParam(':tenBaoCao', $tenBaoCao);
        $stmt->bindParam(':thoiGianBatDau', $thoiGianBatDau);
        $stmt->bindParam(':thoiGianKetThuc', $thoiGianKetThuc);
        $stmt->bindParam(':tongDoanhThu', $tongDoanhThu);
        $stmt->bindParam(':tongSoLuongDV', $tongSoLuongDV);
        $stmt->bindParam(':soKhachHangMoi', $soKhachHangMoi);
        $stmt->bindParam(':noiDung', $noiDung);
        return $stmt->execute();
    }

    public function read($maBCTK) {
        $query = "SELECT * FROM BaoCaoThongKe WHERE MaBCTK = :maBCTK";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maBCTK', $maBCTK);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->maBCTK = $row['MaBCTK'];
            $this->maNV_Tao = $row['MaNV_Tao'];
            $this->tenBaoCao = $row['TenBaoCao'];
            $this->thoiGianBatDau = $row['ThoiGianBatDau'];
            $this->thoiGianKetThuc = $row['ThoiGianKetThuc'];
            $this->tongDoanhThu = $row['TongDoanhThu'];
            $this->tongSoLuongDV = $row['TongSoLuongDV'];
            $this->soKhachHangMoi = $row['SoKhachHangMoi'];
            $this->noiDung = $row['NoiDung'];
            $this->ngayTao = $row['NgayTao'];
            return true;
        }
        return false;
    }

    // UPDATE
    // ================================
    public function update($maBCTK, $tenBaoCao, $thoiGianBatDau, $thoiGianKetThuc, $tongDoanhThu, $tongSoLuongDV, $soKhachHangMoi, $noiDung) {
        $query = "UPDATE BaoCaoThongKe 
                  SET TenBaoCao = :tenBaoCao, ThoiGianBatDau = :thoiGianBatDau, ThoiGianKetThuc = :thoiGianKetThuc,
                      TongDoanhThu = :tongDoanhThu, TongSoLuongDV = :tongSoLuongDV, SoKhachHangMoi = :soKhachHangMoi,
                      NoiDung = :noiDung
                  WHERE MaBCTK = :maBCTK";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maBCTK', $maBCTK);
        $stmt->bindParam(':tenBaoCao', $tenBaoCao);
        $stmt->bindParam(':thoiGianBatDau', $thoiGianBatDau);
        $stmt->bindParam(':thoiGianKetThuc', $thoiGianKetThuc);
        $stmt->bindParam(':tongDoanhThu', $tongDoanhThu);
        $stmt->bindParam(':tongSoLuongDV', $tongSoLuongDV);
        $stmt->bindParam(':soKhachHangMoi', $soKhachHangMoi);
        $stmt->bindParam(':noiDung', $noiDung);
        return $stmt->execute();
    }

    // ================================
    // DELETE
    // ================================
    public function delete($maBCTK) {
        $query = "DELETE FROM BaoCaoThongKe WHERE MaBCTK = :maBCTK";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maBCTK', $maBCTK);
        return $stmt->execute();
    }

    // ================================
    // GETTERS & SETTERS
    // ================================
    public function getMaBCTK() { return $this->maBCTK; }
    public function getMaNV_Tao() { return $this->maNV_Tao; }
    public function getTenBaoCao() { return $this->tenBaoCao; }
    public function getThoiGianBatDau() { return $this->thoiGianBatDau; }
    public function getThoiGianKetThuc() { return $this->thoiGianKetThuc; }
    public function getTongDoanhThu() { return $this->tongDoanhThu; }
    public function getTongSoLuongDV() { return $this->tongSoLuongDV; }
    public function getSoKhachHangMoi() { return $this->soKhachHangMoi; }
    public function getNoiDung() { return $this->noiDung; }
    public function getNgayTao() { return $this->ngayTao; }

    public function setMaBCTK($maBCTK) { $this->maBCTK = $maBCTK; }
    public function setMaNV_Tao($maNV_Tao) { $this->maNV_Tao = $maNV_Tao; }
    public function setTenBaoCao($tenBaoCao) { $this->tenBaoCao = $tenBaoCao; }
    public function setThoiGianBatDau($thoiGianBatDau) { $this->thoiGianBatDau = $thoiGianBatDau; }
    public function setThoiGianKetThuc($thoiGianKetThuc) { $this->thoiGianKetThuc = $thoiGianKetThuc; }
    public function setTongDoanhThu($tongDoanhThu) { $this->tongDoanhThu = $tongDoanhThu; }
    public function setTongSoLuongDV($tongSoLuongDV) { $this->tongSoLuongDV = $tongSoLuongDV; }
    public function setSoKhachHangMoi($soKhachHangMoi) { $this->soKhachHangMoi = $soKhachHangMoi; }
    public function setNoiDung($noiDung) { $this->noiDung = $noiDung; }
    public function setNgayTao($ngayTao) { $this->ngayTao = $ngayTao; }

    // Các phương thức update, delete, getter/setter tương tự
}
?>