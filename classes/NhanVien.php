<?php
namespace PetCare;

require_once 'config/database.php';

class NhanVien {
    private $maNV;
    private $hoTen;
    private $chucVu;
    private $sdt;
    private $email;
    private $diaChi;
    private $ngayVaoLam;
    private $trangThai;
    private $createdAt;
    private $updatedAt;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function create($hoTen, $chucVu, $sdt, $email, $diaChi, $ngayVaoLam) {
        $query = "INSERT INTO NhanVien (HoTen, ChucVu, SDT, Email, DiaChi, NgayVaoLam) VALUES (:hoTen, :chucVu, :sdt, :email, :diaChi, :ngayVaoLam)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':hoTen', $hoTen);
        $stmt->bindParam(':chucVu', $chucVu);
        $stmt->bindParam(':sdt', $sdt);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':diaChi', $diaChi);
        $stmt->bindParam(':ngayVaoLam', $ngayVaoLam);
        return $stmt->execute();
    }

    public function read($maNV) {
        $query = "SELECT * FROM NhanVien WHERE MaNV = :maNV";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maNV', $maNV);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->maNV = $row['MaNV'];
            $this->hoTen = $row['HoTen'];
            $this->chucVu = $row['ChucVu'];
            $this->sdt = $row['SDT'];
            $this->email = $row['Email'];
            $this->diaChi = $row['DiaChi'];
            $this->ngayVaoLam = $row['NgayVaoLam'];
            $this->trangThai = $row['TrangThai'];
            $this->createdAt = $row['CreatedAt'];
            $this->updatedAt = $row['UpdatedAt'];
            return true;
        }
        return false;
    }

    // ==================== UPDATE ====================
    public function update($maNV, $hoTen, $chucVu, $sdt, $email, $diaChi, $trangThai) {
        $query = "UPDATE NhanVien 
                  SET HoTen = :hoTen, ChucVu = :chucVu, SDT = :sdt, Email = :email, 
                      DiaChi = :diaChi, TrangThai = :trangThai, UpdatedAt = NOW()
                  WHERE MaNV = :maNV";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maNV', $maNV);
        $stmt->bindParam(':hoTen', $hoTen);
        $stmt->bindParam(':chucVu', $chucVu);
        $stmt->bindParam(':sdt', $sdt);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':diaChi', $diaChi);
        $stmt->bindParam(':trangThai', $trangThai);
        return $stmt->execute();
    }

    // ==================== DELETE ====================
    public function delete($maNV) {
        $query = "DELETE FROM NhanVien WHERE MaNV = :maNV";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maNV', $maNV);
        return $stmt->execute();
    }

    // ==================== GETTER & SETTER ====================
    public function getMaNV() { return $this->maNV; }
    public function setMaNV($maNV) { $this->maNV = $maNV; }

    public function getHoTen() { return $this->hoTen; }
    public function setHoTen($hoTen) { $this->hoTen = $hoTen; }

    public function getChucVu() { return $this->chucVu; }
    public function setChucVu($chucVu) { $this->chucVu = $chucVu; }

    public function getSDT() { return $this->sdt; }
    public function setSDT($sdt) { $this->sdt = $sdt; }

    public function getEmail() { return $this->email; }
    public function setEmail($email) { $this->email = $email; }

    public function getDiaChi() { return $this->diaChi; }
    public function setDiaChi($diaChi) { $this->diaChi = $diaChi; }

    public function getNgayVaoLam() { return $this->ngayVaoLam; }
    public function setNgayVaoLam($ngayVaoLam) { $this->ngayVaoLam = $ngayVaoLam; }

    public function getTrangThai() { return $this->trangThai; }
    public function setTrangThai($trangThai) { $this->trangThai = $trangThai; }

    public function getCreatedAt() { return $this->createdAt; }
    public function setCreatedAt($createdAt) { $this->createdAt = $createdAt; }

    public function getUpdatedAt() { return $this->updatedAt; }
    public function setUpdatedAt($updatedAt) { $this->updatedAt = $updatedAt; }
}
?>