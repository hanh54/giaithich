<?php
namespace PetCare;

require_once 'config/database.php';

class ThanhToan {
    private $maTT;
    private $maLich;
    private $maKH;
    private $maAdmin_XacNhan;
    private $phuongThuc;
    private $soTien;
    private $ngayThanhToan;
    private $trangThai;
    private $ghiChu;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function create($maLich, $maKH, $phuongThuc, $soTien, $trangThai, $ghiChu = null, $maAdmin_XacNhan = null) {
        $query = "INSERT INTO ThanhToan (MaLich, MaKH, MaAdmin_XacNhan, PhuongThuc, SoTien, TrangThai, GhiChu) 
                  VALUES (:maLich, :maKH, :maAdmin_XacNhan, :phuongThuc, :soTien, :trangThai, :ghiChu)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maLich', $maLich);
        $stmt->bindParam(':maKH', $maKH);
        $stmt->bindParam(':maAdmin_XacNhan', $maAdmin_XacNhan);
        $stmt->bindParam(':phuongThuc', $phuongThuc);
        $stmt->bindParam(':soTien', $soTien);
        $stmt->bindParam(':trangThai', $trangThai);
        $stmt->bindParam(':ghiChu', $ghiChu);
        return $stmt->execute();
    }

    public function read($maTT) {
        $query = "SELECT * FROM ThanhToan WHERE MaTT = :maTT";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maTT', $maTT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->maTT = $row['MaTT'];
            $this->maLich = $row['MaLich'];
            $this->maKH = $row['MaKH'];
            $this->maAdmin_XacNhan = $row['MaAdmin_XacNhan'];
            $this->phuongThuc = $row['PhuongThuc'];
            $this->soTien = $row['SoTien'];
            $this->ngayThanhToan = $row['NgayThanhToan'];
            $this->trangThai = $row['TrangThai'];
            $this->ghiChu = $row['GhiChu'];
            return true;
        }
        return false;
    }

    // 3️⃣ UPDATE
    // ==============================================================
    public function update($maTT, $phuongThuc, $soTien, $trangThai, $ghiChu, $maAdmin_XacNhan = null) {
        $query = "UPDATE ThanhToan 
                  SET PhuongThuc = :phuongThuc, SoTien = :soTien, TrangThai = :trangThai, 
                      GhiChu = :ghiChu, MaAdmin_XacNhan = :maAdmin_XacNhan, 
                      NgayThanhToan = NOW()
                  WHERE MaTT = :maTT";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maTT', $maTT);
        $stmt->bindParam(':phuongThuc', $phuongThuc);
        $stmt->bindParam(':soTien', $soTien);
        $stmt->bindParam(':trangThai', $trangThai);
        $stmt->bindParam(':ghiChu', $ghiChu);
        $stmt->bindParam(':maAdmin_XacNhan', $maAdmin_XacNhan);
        return $stmt->execute();
    }

    // ==============================================================
    // 4️⃣ DELETE
    // ==============================================================
    public function delete($maTT) {
        $query = "DELETE FROM ThanhToan WHERE MaTT = :maTT";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maTT', $maTT);
        return $stmt->execute();
    }

    // ==============================================================
    // 5️⃣ GETTERS & SETTERS
    // ==============================================================
    public function getMaTT() { return $this->maTT; }
    public function getMaLich() { return $this->maLich; }
    public function getMaKH() { return $this->maKH; }
    public function getMaAdmin_XacNhan() { return $this->maAdmin_XacNhan; }
    public function getPhuongThuc() { return $this->phuongThuc; }
    public function getSoTien() { return $this->soTien; }
    public function getNgayThanhToan() { return $this->ngayThanhToan; }
    public function getTrangThai() { return $this->trangThai; }
    public function getGhiChu() { return $this->ghiChu; }

    public function setMaLich($maLich) { $this->maLich = $maLich; }
    public function setMaKH($maKH) { $this->maKH = $maKH; }
    public function setMaAdmin_XacNhan($maAdmin_XacNhan) { $this->maAdmin_XacNhan = $maAdmin_XacNhan; }
    public function setPhuongThuc($phuongThuc) { $this->phuongThuc = $phuongThuc; }
    public function setSoTien($soTien) { $this->soTien = $soTien; }
    public function setNgayThanhToan($ngayThanhToan) { $this->ngayThanhToan = $ngayThanhToan; }
    public function setTrangThai($trangThai) { $this->trangThai = $trangThai; }
    public function setGhiChu($ghiChu) { $this->ghiChu = $ghiChu; }

    // Các phương thức update, delete, getter/setter tương tự
}
?>