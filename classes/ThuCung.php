<?php
namespace PetCare;

require_once __DIR__ . '/../config/database.php';

class ThuCung {
    private $maTC;
    private $maKH;
    private $tenTC;
    private $loai;
    private $giong;
    private $ngaySinh;
    private $canNang;
    private $gioiTinh;
    private $tinhTrangSucKhoe;
    private $lichSuTiem;
    private $hinhAnh;
    private $createdAt;
    private $updatedAt;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function create($maKH, $tenTC, $loai, $giong, $ngaySinh, $canNang, $gioiTinh, $tinhTrangSucKhoe, $lichSuTiem, $hinhAnh = null) {
        $query = "INSERT INTO ThuCung (MaKH, TenTC, Loai, Giong, NgaySinh, CanNang, GioiTinh, TinhTrangSucKhoe, LichSuTiem, HinhAnh) 
                  VALUES (:maKH, :tenTC, :loai, :giong, :ngaySinh, :canNang, :gioiTinh, :tinhTrangSucKhoe, :lichSuTiem, :hinhAnh)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maKH', $maKH);
        $stmt->bindParam(':tenTC', $tenTC);
        $stmt->bindParam(':loai', $loai);
        $stmt->bindParam(':giong', $giong);
        $stmt->bindParam(':ngaySinh', $ngaySinh);
        $stmt->bindParam(':canNang', $canNang);
        $stmt->bindParam(':gioiTinh', $gioiTinh);
        $stmt->bindParam(':tinhTrangSucKhoe', $tinhTrangSucKhoe);
        $stmt->bindParam(':lichSuTiem', $lichSuTiem);
        $stmt->bindParam(':hinhAnh', $hinhAnh);
        return $stmt->execute();
    }

    public function read($maTC) {
        $query = "SELECT * FROM ThuCung WHERE MaTC = :maTC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maTC', $maTC);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->maTC = $row['MaTC'];
            $this->maKH = $row['MaKH'];
            $this->tenTC = $row['TenTC'];
            $this->loai = $row['Loai'];
            $this->giong = $row['Giong'];
            $this->ngaySinh = $row['NgaySinh'];
            $this->canNang = $row['CanNang'];
            $this->gioiTinh = $row['GioiTinh'];
            $this->tinhTrangSucKhoe = $row['TinhTrangSucKhoe'];
            $this->lichSuTiem = $row['LichSuTiem'];
            $this->hinhAnh = $row['HinhAnh'];
            $this->createdAt = $row['CreatedAt'];
            $this->updatedAt = $row['UpdatedAt'];
            return true;
        }
        return false;
    }

    // ==================== UPDATE ====================
    public function update($maTC, $tenTC, $loai, $giong, $ngaySinh, $canNang, $gioiTinh, $tinhTrangSucKhoe, $lichSuTiem, $hinhAnh = null) {
        $query = "UPDATE ThuCung 
                  SET TenTC = :tenTC, Loai = :loai, Giong = :giong, NgaySinh = :ngaySinh, 
                      CanNang = :canNang, GioiTinh = :gioiTinh, TinhTrangSucKhoe = :tinhTrangSucKhoe,
                      LichSuTiem = :lichSuTiem, HinhAnh = :hinhAnh, UpdatedAt = NOW()
                  WHERE MaTC = :maTC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maTC', $maTC);
        $stmt->bindParam(':tenTC', $tenTC);
        $stmt->bindParam(':loai', $loai);
        $stmt->bindParam(':giong', $giong);
        $stmt->bindParam(':ngaySinh', $ngaySinh);
        $stmt->bindParam(':canNang', $canNang);
        $stmt->bindParam(':gioiTinh', $gioiTinh);
        $stmt->bindParam(':tinhTrangSucKhoe', $tinhTrangSucKhoe);
        $stmt->bindParam(':lichSuTiem', $lichSuTiem);
        $stmt->bindParam(':hinhAnh', $hinhAnh);
        return $stmt->execute();
    }

    // ==================== DELETE ====================
    public function delete($maTC) {
        $query = "DELETE FROM ThuCung WHERE MaTC = :maTC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maTC', $maTC);
        return $stmt->execute();
    }

    // ==================== GETTER & SETTER ====================
    public function getMaTC() { return $this->maTC; }
    public function setMaTC($maTC) { $this->maTC = $maTC; }

    public function getMaKH() { return $this->maKH; }
    public function setMaKH($maKH) { $this->maKH = $maKH; }

    public function getTenTC() { return $this->tenTC; }
    public function setTenTC($tenTC) { $this->tenTC = $tenTC; }

    public function getLoai() { return $this->loai; }
    public function setLoai($loai) { $this->loai = $loai; }

    public function getGiong() { return $this->giong; }
    public function setGiong($giong) { $this->giong = $giong; }

    public function getNgaySinh() { return $this->ngaySinh; }
    public function setNgaySinh($ngaySinh) { $this->ngaySinh = $ngaySinh; }

    public function getCanNang() { return $this->canNang; }
    public function setCanNang($canNang) { $this->canNang = $canNang; }

    public function getGioiTinh() { return $this->gioiTinh; }
    public function setGioiTinh($gioiTinh) { $this->gioiTinh = $gioiTinh; }

    public function getTinhTrangSucKhoe() { return $this->tinhTrangSucKhoe; }
    public function setTinhTrangSucKhoe($tinhTrangSucKhoe) { $this->tinhTrangSucKhoe = $tinhTrangSucKhoe; }

    public function getLichSuTiem() { return $this->lichSuTiem; }
    public function setLichSuTiem($lichSuTiem) { $this->lichSuTiem = $lichSuTiem; }

    public function getHinhAnh() { return $this->hinhAnh; }
    public function setHinhAnh($hinhAnh) { $this->hinhAnh = $hinhAnh; }

    public function getCreatedAt() { return $this->createdAt; }
    public function setCreatedAt($createdAt) { $this->createdAt = $createdAt; }

    public function getUpdatedAt() { return $this->updatedAt; }
    public function setUpdatedAt($updatedAt) { $this->updatedAt = $updatedAt; }


    // Các phương thức update, delete, getter/setter tương tự
}
?>