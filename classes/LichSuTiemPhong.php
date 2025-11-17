<?php
namespace PetCare;

require_once 'config/database.php';

class LichSuTiemPhong {
    private $maLSTP;
    private $maTC;
    private $maTP;
    private $tenVacXin;
    private $lieuLuong;
    private $ngayTiem;
    private $maNV_Tiem;
    private $ghiChu;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function create($maTC, $maTP, $tenVacXin, $lieuLuong, $ngayTiem, $maNV_Tiem, $ghiChu = null) {
        $query = "INSERT INTO LichSuTiemPhong (MaTC, MaTP, TenVacXin, LieuLuong, NgayTiem, MaNV_Tiem, GhiChu) 
                  VALUES (:maTC, :maTP, :tenVacXin, :lieuLuong, :ngayTiem, :maNV_Tiem, :ghiChu)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maTC', $maTC);
        $stmt->bindParam(':maTP', $maTP);
        $stmt->bindParam(':tenVacXin', $tenVacXin);
        $stmt->bindParam(':lieuLuong', $lieuLuong);
        $stmt->bindParam(':ngayTiem', $ngayTiem);
        $stmt->bindParam(':maNV_Tiem', $maNV_Tiem);
        $stmt->bindParam(':ghiChu', $ghiChu);
        return $stmt->execute();
    }

    public function read($maLSTP) {
        $query = "SELECT * FROM LichSuTiemPhong WHERE MaLSTP = :maLSTP";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maLSTP', $maLSTP);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->maLSTP = $row['MaLSTP'];
            $this->maTC = $row['MaTC'];
            $this->maTP = $row['MaTP'];
            $this->tenVacXin = $row['TenVacXin'];
            $this->lieuLuong = $row['LieuLuong'];
            $this->ngayTiem = $row['NgayTiem'];
            $this->maNV_Tiem = $row['MaNV_Tiem'];
            $this->ghiChu = $row['GhiChu'];
            return true;
        }
        return false;
    }

    // UPDATE
    // -------------------------------
    public function update($maLSTP, $tenVacXin, $lieuLuong, $ngayTiem, $maNV_Tiem, $ghiChu = null) {
        $query = "UPDATE LichSuTiemPhong 
                  SET TenVacXin = :tenVacXin, LieuLuong = :lieuLuong, NgayTiem = :ngayTiem, 
                      MaNV_Tiem = :maNV_Tiem, GhiChu = :ghiChu
                  WHERE MaLSTP = :maLSTP";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maLSTP', $maLSTP);
        $stmt->bindParam(':tenVacXin', $tenVacXin);
        $stmt->bindParam(':lieuLuong', $lieuLuong);
        $stmt->bindParam(':ngayTiem', $ngayTiem);
        $stmt->bindParam(':maNV_Tiem', $maNV_Tiem);
        $stmt->bindParam(':ghiChu', $ghiChu);
        return $stmt->execute();
    }

    // -------------------------------
    // DELETE
    // -------------------------------
    public function delete($maLSTP) {
        $query = "DELETE FROM LichSuTiemPhong WHERE MaLSTP = :maLSTP";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maLSTP', $maLSTP);
        return $stmt->execute();
    }

    // -------------------------------
    // GETTERS & SETTERS
    // -------------------------------
    public function getMaLSTP() { return $this->maLSTP; }
    public function getMaTC() { return $this->maTC; }
    public function getMaTP() { return $this->maTP; }
    public function getTenVacXin() { return $this->tenVacXin; }
    public function getLieuLuong() { return $this->lieuLuong; }
    public function getNgayTiem() { return $this->ngayTiem; }
    public function getMaNV_Tiem() { return $this->maNV_Tiem; }
    public function getGhiChu() { return $this->ghiChu; }

    public function setMaLSTP($maLSTP) { $this->maLSTP = $maLSTP; }
    public function setMaTC($maTC) { $this->maTC = $maTC; }
    public function setMaTP($maTP) { $this->maTP = $maTP; }
    public function setTenVacXin($tenVacXin) { $this->tenVacXin = $tenVacXin; }
    public function setLieuLuong($lieuLuong) { $this->lieuLuong = $lieuLuong; }
    public function setNgayTiem($ngayTiem) { $this->ngayTiem = $ngayTiem; }
    public function setMaNV_Tiem($maNV_Tiem) { $this->maNV_Tiem = $maNV_Tiem; }
    public function setGhiChu($ghiChu) { $this->ghiChu = $ghiChu; }

    // Các phương thức update, delete, getter/setter tương tự
}
?>