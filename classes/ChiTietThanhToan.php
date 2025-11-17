<?php
namespace PetCare;

require_once 'config/database.php';

class ChiTietThanhToan {
    private $maCTTT;
    private $maTT;
    private $maTP;
    private $moTa;
    private $soLuong;
    private $donGia;
    private $thanhTien;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function create($maTT, $maTP, $moTa, $soLuong, $donGia) {
        $query = "INSERT INTO ChiTietThanhToan (MaTT, MaTP, MoTa, SoLuong, DonGia) VALUES (:maTT, :maTP, :moTa, :soLuong, :donGia)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maTT', $maTT);
        $stmt->bindParam(':maTP', $maTP);
        $stmt->bindParam(':moTa', $moTa);
        $stmt->bindParam(':soLuong', $soLuong);
        $stmt->bindParam(':donGia', $donGia);
        return $stmt->execute();
    }

    public function read($maCTTT) {
        $query = "SELECT * FROM ChiTietThanhToan WHERE MaCTTT = :maCTTT";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maCTTT', $maCTTT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->maCTTT = $row['MaCTTT'];
            $this->maTT = $row['MaTT'];
            $this->maTP = $row['MaTP'];
            $this->moTa = $row['MoTa'];
            $this->soLuong = $row['SoLuong'];
            $this->donGia = $row['DonGia'];
            $this->thanhTien = $row['ThanhTien'];
            return true;
        }
        return false;
    }

    // UPDATE
    // -------------------------------
    public function update($maCTTT, $moTa, $soLuong, $donGia) {
        $query = "UPDATE ChiTietThanhToan 
                  SET MoTa = :moTa, SoLuong = :soLuong, DonGia = :donGia, ThanhTien = :thanhTien 
                  WHERE MaCTTT = :maCTTT";
        $stmt = $this->db->prepare($query);
        $thanhTien = $soLuong * $donGia;

        $stmt->bindParam(':maCTTT', $maCTTT);
        $stmt->bindParam(':moTa', $moTa);
        $stmt->bindParam(':soLuong', $soLuong);
        $stmt->bindParam(':donGia', $donGia);
        $stmt->bindParam(':thanhTien', $thanhTien);

        return $stmt->execute();
    }

    // -------------------------------
    // DELETE
    // -------------------------------
    public function delete($maCTTT) {
        $query = "DELETE FROM ChiTietThanhToan WHERE MaCTTT = :maCTTT";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maCTTT', $maCTTT);
        return $stmt->execute();
    }

    // -------------------------------
    // GETTERS & SETTERS
    // -------------------------------
    public function getMaCTTT() { return $this->maCTTT; }
    public function getMaTT() { return $this->maTT; }
    public function getMaTP() { return $this->maTP; }
    public function getMoTa() { return $this->moTa; }
    public function getSoLuong() { return $this->soLuong; }
    public function getDonGia() { return $this->donGia; }
    public function getThanhTien() { return $this->thanhTien; }

    public function setMaCTTT($maCTTT) { $this->maCTTT = $maCTTT; }
    public function setMaTT($maTT) { $this->maTT = $maTT; }
    public function setMaTP($maTP) { $this->maTP = $maTP; }
    public function setMoTa($moTa) { $this->moTa = $moTa; }
    public function setSoLuong($soLuong) { $this->soLuong = $soLuong; }
    public function setDonGia($donGia) { $this->donGia = $donGia; }
    public function setThanhTien($thanhTien) { $this->thanhTien = $thanhTien; }

    // Các phương thức update, delete, getter/setter tương tự
}
?>