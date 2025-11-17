<?php
namespace PetCare;

require_once 'config/database.php';

class DatLich {
    private $maLich;
    private $maKH;
    private $maTC;
    private $maNV_DuKien;
    private $ngayDat;
    private $ngayHen;
    private $gioHen;
    private $trangThai;
    private $tongTien;
    private $ghiChu;
    private $createdAt;
    private $updatedAt;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function create($maKH, $maTC, $ngayHen, $gioHen, $trangThai, $tongTien, $ghiChu = null, $maNV_DuKien = null) {
        $query = "INSERT INTO DatLich (MaKH, MaTC, MaNV_DuKien, NgayHen, GioHen, TrangThai, TongTien, GhiChu) 
                  VALUES (:maKH, :maTC, :maNV_DuKien, :ngayHen, :gioHen, :trangThai, :tongTien, :ghiChu)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maKH', $maKH);
        $stmt->bindParam(':maTC', $maTC);
        $stmt->bindParam(':maNV_DuKien', $maNV_DuKien);
        $stmt->bindParam(':ngayHen', $ngayHen);
        $stmt->bindParam(':gioHen', $gioHen);
        $stmt->bindParam(':trangThai', $trangThai);
        $stmt->bindParam(':tongTien', $tongTien);
        $stmt->bindParam(':ghiChu', $ghiChu);
        return $stmt->execute();
    }

    public function read($maLich) {
        $query = "SELECT * FROM DatLich WHERE MaLich = :maLich";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maLich', $maLich);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->maLich = $row['MaLich'];
            $this->maKH = $row['MaKH'];
            $this->maTC = $row['MaTC'];
            $this->maNV_DuKien = $row['MaNV_DuKien'];
            $this->ngayDat = $row['NgayDat'];
            $this->ngayHen = $row['NgayHen'];
            $this->gioHen = $row['GioHen'];
            $this->trangThai = $row['TrangThai'];
            $this->tongTien = $row['TongTien'];
            $this->ghiChu = $row['GhiChu'];
            $this->createdAt = $row['CreatedAt'];
            $this->updatedAt = $row['UpdatedAt'];
            return true;
        }
        return false;
    }

     // ==============================================================
    // UPDATE
    // ==============================================================
    public function update($maLich, $maNV_DuKien, $ngayHen, $gioHen, $trangThai, $tongTien, $ghiChu) {
        $query = "UPDATE DatLich 
                  SET MaNV_DuKien = :maNV_DuKien, NgayHen = :ngayHen, GioHen = :gioHen, 
                      TrangThai = :trangThai, TongTien = :tongTien, GhiChu = :ghiChu, UpdatedAt = NOW()
                  WHERE MaLich = :maLich";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maLich', $maLich);
        $stmt->bindParam(':maNV_DuKien', $maNV_DuKien);
        $stmt->bindParam(':ngayHen', $ngayHen);
        $stmt->bindParam(':gioHen', $gioHen);
        $stmt->bindParam(':trangThai', $trangThai);
        $stmt->bindParam(':tongTien', $tongTien);
        $stmt->bindParam(':ghiChu', $ghiChu);
        return $stmt->execute();
    }

    // ==============================================================
    //  DELETE
    // ==============================================================
    public function delete($maLich) {
        $query = "DELETE FROM DatLich WHERE MaLich = :maLich";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maLich', $maLich);
        return $stmt->execute();
    }

    // ==============================================================
    // 5️ GETTERS & SETTERS
    // ==============================================================
    public function getMaLich() { return $this->maLich; }
    public function getMaKH() { return $this->maKH; }
    public function getMaTC() { return $this->maTC; }
    public function getMaNV_DuKien() { return $this->maNV_DuKien; }
    public function getNgayDat() { return $this->ngayDat; }
    public function getNgayHen() { return $this->ngayHen; }
    public function getGioHen() { return $this->gioHen; }
    public function getTrangThai() { return $this->trangThai; }
    public function getTongTien() { return $this->tongTien; }
    public function getGhiChu() { return $this->ghiChu; }
    public function getCreatedAt() { return $this->createdAt; }
    public function getUpdatedAt() { return $this->updatedAt; }

    public function setMaKH($maKH) { $this->maKH = $maKH; }
    public function setMaTC($maTC) { $this->maTC = $maTC; }
    public function setMaNV_DuKien($maNV_DuKien) { $this->maNV_DuKien = $maNV_DuKien; }
    public function setNgayDat($ngayDat) { $this->ngayDat = $ngayDat; }
    public function setNgayHen($ngayHen) { $this->ngayHen = $ngayHen; }
    public function setGioHen($gioHen) { $this->gioHen = $gioHen; }
    public function setTrangThai($trangThai) { $this->trangThai = $trangThai; }
    public function setTongTien($tongTien) { $this->tongTien = $tongTien; }
    public function setGhiChu($ghiChu) { $this->ghiChu = $ghiChu; }


}
?>