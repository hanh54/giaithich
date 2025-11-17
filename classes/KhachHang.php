<?php
namespace PetCare;

require_once __DIR__ . '/../config/database.php';

class KhachHang {
    private $maKH;
    private $maTK;
    private $hoTen;
    private $sdt;
    private $email;
    private $diaChi;
    private $ngayDangKy;
    private $ghiChu;
    private $createdAt;
    private $updatedAt;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function create($maTK, $hoTen, $sdt, $email, $diaChi, $ghiChu = null) {
        $query = "INSERT INTO KhachHang (MaTK, HoTen, SDT, Email, DiaChi, GhiChu) VALUES (:maTK, :hoTen, :sdt, :email, :diaChi, :ghiChu)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maTK', $maTK);
        $stmt->bindParam(':hoTen', $hoTen);
        $stmt->bindParam(':sdt', $sdt);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':diaChi', $diaChi);
        $stmt->bindParam(':ghiChu', $ghiChu);
        return $stmt->execute();
    }

    public function read($maKH) {
        $query = "SELECT * FROM KhachHang WHERE MaKH = :maKH";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maKH', $maKH);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->maKH = $row['MaKH'];
            $this->maTK = $row['MaTK'];
            $this->hoTen = $row['HoTen'];
            $this->sdt = $row['SDT'];
            $this->email = $row['Email'];
            $this->diaChi = $row['DiaChi'];
            $this->ngayDangKy = $row['NgayDangKy'];
            $this->ghiChu = $row['GhiChu'];
            $this->createdAt = $row['CreatedAt'];
            $this->updatedAt = $row['UpdatedAt'];
            return true;
        }
        return false;
    }

    // ==================== UPDATE ====================
    public function update($maKH, $hoTen, $sdt, $email, $diaChi, $ghiChu, $trangThai = null) {
        $query = "UPDATE KhachHang 
                  SET HoTen = :hoTen, SDT = :sdt, Email = :email, DiaChi = :diaChi, 
                      GhiChu = :ghiChu, UpdatedAt = NOW()
                  WHERE MaKH = :maKH";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maKH', $maKH);
        $stmt->bindParam(':hoTen', $hoTen);
        $stmt->bindParam(':sdt', $sdt);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':diaChi', $diaChi);
        $stmt->bindParam(':ghiChu', $ghiChu);
        return $stmt->execute();
    }

    // ==================== DELETE ====================
    public function delete($maKH) {
        $query = "DELETE FROM KhachHang WHERE MaKH = :maKH";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maKH', $maKH);
        return $stmt->execute();
    }

    // ==================== GETTER & SETTER ====================
    public function getMaKH() { return $this->maKH; }
    public function setMaKH($maKH) { $this->maKH = $maKH; }

    public function getMaTK() { return $this->maTK; }
    public function setMaTK($maTK) { $this->maTK = $maTK; }

    public function getHoTen() { return $this->hoTen; }
    public function setHoTen($hoTen) { $this->hoTen = $hoTen; }

    public function getSDT() { return $this->sdt; }
    public function setSDT($sdt) { $this->sdt = $sdt; }

    public function getEmail() { return $this->email; }
    public function setEmail($email) { $this->email = $email; }

    public function getDiaChi() { return $this->diaChi; }
    public function setDiaChi($diaChi) { $this->diaChi = $diaChi; }

    public function getNgayDangKy() { return $this->ngayDangKy; }
    public function setNgayDangKy($ngayDangKy) { $this->ngayDangKy = $ngayDangKy; }

    public function getGhiChu() { return $this->ghiChu; }
    public function setGhiChu($ghiChu) { $this->ghiChu = $ghiChu; }

    public function getCreatedAt() { return $this->createdAt; }
    public function setCreatedAt($createdAt) { $this->createdAt = $createdAt; }

    public function getUpdatedAt() { return $this->updatedAt; }
    public function setUpdatedAt($updatedAt) { $this->updatedAt = $updatedAt; }
    // Các phương thức update, delete, getter/setter tương tự
}
?>