<?php
namespace PetCare;
use PDO;
use PDOException;


require_once __DIR__ . '/../config/database.php';

class TaiKhoan {
    private $maTK;
    private $tenDangNhap;
    private $matKhau;
    private $email;
    private $vaiTro;
    private $trangThai;
    private $createdAt;
    private $updatedAt;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Trong TaiKhoan.php, thêm các phương thức sau:
    public function readByTenDangNhap($tenDangNhap) {
        $query = "SELECT * FROM TaiKhoan WHERE TenDangNhap = :tenDangNhap";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':tenDangNhap', $tenDangNhap);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->maTK = $row['MaTK'];
            $this->tenDangNhap = $row['TenDangNhap'];
            $this->matKhau = $row['MatKhau'];
            $this->email = $row['Email'];
            $this->vaiTro = $row['VaiTro'];
            $this->trangThai = $row['TrangThai'];
            $this->createdAt = $row['CreatedAt'];
            $this->updatedAt = $row['UpdatedAt'];
            return true;
        }
        return false;
    }

    public function kiemTraMatKhau($matKhau) {
    return $matKhau === $this->matKhau;
    }

    public function kiemTraTonTaiTenDangNhap($tenDangNhap) {
        $query = "SELECT COUNT(*) FROM TaiKhoan WHERE TenDangNhap = :tenDangNhap";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':tenDangNhap', $tenDangNhap);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function kiemTraTonTaiEmail($email) {
        $query = "SELECT COUNT(*) FROM TaiKhoan WHERE Email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function taoTaiKhoan($tenDangNhap, $matKhau, $email) {
        return $this->create($tenDangNhap, $matKhau, $email); // Sử dụng lại create
    }

    public function create($tenDangNhap, $matKhau, $email) {
        $query = "INSERT INTO TaiKhoan (TenDangNhap, MatKhau, Email, VaiTro) VALUES (:tenDangNhap, :matKhau, :email, 'Khách hàng')";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':matKhau', $matKhau);
        $stmt->bindParam(':tenDangNhap', $tenDangNhap);
        $stmt->bindParam(':email', $email);
        if ($stmt->execute()) {
        return $this->db->lastInsertId(); // Trả về MaTK
    }
    return false;
    }
    

    public function read($maTK) {
        $query = "SELECT * FROM TaiKhoan WHERE MaTK = :maTK";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maTK', $maTK);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->maTK = $row['MaTK'];
            $this->tenDangNhap = $row['TenDangNhap'];
            $this->matKhau = $row['MatKhau'];
            $this->email = $row['Email'];
            $this->vaiTro = $row['VaiTro'];
            $this->trangThai = $row['TrangThai'];
            $this->createdAt = $row['CreatedAt'];
            $this->updatedAt = $row['UpdatedAt'];
            return true;
        }
        return false;
    }

    public function update($maTK, $email, $matKhau = null) {
        $query = "UPDATE TaiKhoan SET Email = :email";
        $params = [':email' => $email, ':maTK' => $maTK];
        if ($matKhau) {
            $hashedPassword = password_hash($matKhau, PASSWORD_DEFAULT);
            $query .= ", MatKhau = :matKhau";
            $params[':matKhau'] = $hashedPassword;
        }
        $query .= " WHERE MaTK = :maTK";
        $stmt = $this->db->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindParam($key, $value);
        }
        return $stmt->execute();
    }

    public function delete($maTK) {
        $query = "DELETE FROM TaiKhoan WHERE MaTK = :maTK";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maTK', $maTK);
        return $stmt->execute();
    }

    // Getters
    public function getMaTK() { return $this->maTK; }
    public function getTenDangNhap() { return $this->tenDangNhap; }
    public function getMatKhau() { return $this->matKhau; } // Tránh sử dụng trực tiếp
    public function getEmail() { return $this->email; }
    public function getVaiTro() { return $this->vaiTro; }
    public function getTrangThai() { return $this->trangThai; }
    public function getCreatedAt() { return $this->createdAt; }
    public function getUpdatedAt() { return $this->updatedAt; }

    // Setters
    public function setEmail($email) { $this->email = $email; }
    public function setTrangThai($trangThai) { $this->trangThai = $trangThai; }
}
?>