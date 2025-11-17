<?php
namespace PetCare;

require_once 'config/database.php';

class TiemPhong {
    private $maTP;
    private $tenThuoc;
    private $moTa;
    private $loaiThuCung;
    private $soLanTiem;
    private $gia;
    private $thoiLuong;
    private $hinhAnh;
    private $trangThai;
    private $createdAt;
    private $updatedAt;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function create($tenThuoc, $moTa, $loaiThuCung, $soLanTiem, $gia, $thoiLuong, $hinhAnh = null) {
        $query = "INSERT INTO TiemPhong (TenThuoc, MoTa, LoaiThuCung, SoLanTiem, Gia, ThoiLuong, HinhAnh) 
                  VALUES (:tenThuoc, :moTa, :loaiThuCung, :soLanTiem, :gia, :thoiLuong, :hinhAnh)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':tenThuoc', $tenThuoc);
        $stmt->bindParam(':moTa', $moTa);
        $stmt->bindParam(':loaiThuCung', $loaiThuCung);
        $stmt->bindParam(':soLanTiem', $soLanTiem);
        $stmt->bindParam(':gia', $gia);
        $stmt->bindParam(':thoiLuong', $thoiLuong);
        $stmt->bindParam(':hinhAnh', $hinhAnh);
        return $stmt->execute();
    }

    public function read($maTP) {
        $query = "SELECT * FROM TiemPhong WHERE MaTP = :maTP";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maTP', $maTP);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->maTP = $row['MaTP'];
            $this->tenThuoc = $row['TenThuoc'];
            $this->moTa = $row['MoTa'];
            $this->loaiThuCung = $row['LoaiThuCung'];
            $this->soLanTiem = $row['SoLanTiem'];
            $this->gia = $row['Gia'];
            $this->thoiLuong = $row['ThoiLuong'];
            $this->hinhAnh = $row['HinhAnh'];
            $this->trangThai = $row['TrangThai'];
            $this->createdAt = $row['CreatedAt'];
            $this->updatedAt = $row['UpdatedAt'];
            return true;
        }
        return false;
    }

     public function readAll() {
        $query = "SELECT * FROM TiemPhong ORDER BY MaTP DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // =========================================================
    // UPDATE - cập nhật thông tin thuốc tiêm
    // =========================================================
    public function update($maTP, $tenThuoc, $moTa, $loaiThuCung, $soLanTiem, $gia, $thoiLuong, $hinhAnh = null, $trangThai = 'Hoạt động') {
        $query = "UPDATE TiemPhong SET 
                    TenThuoc = :tenThuoc,
                    MoTa = :moTa,
                    LoaiThuCung = :loaiThuCung,
                    SoLanTiem = :soLanTiem,
                    Gia = :gia,
                    ThoiLuong = :thoiLuong,
                    HinhAnh = :hinhAnh,
                    TrangThai = :trangThai,
                    UpdatedAt = NOW()
                  WHERE MaTP = :maTP";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maTP', $maTP);
        $stmt->bindParam(':tenThuoc', $tenThuoc);
        $stmt->bindParam(':moTa', $moTa);
        $stmt->bindParam(':loaiThuCung', $loaiThuCung);
        $stmt->bindParam(':soLanTiem', $soLanTiem);
        $stmt->bindParam(':gia', $gia);
        $stmt->bindParam(':thoiLuong', $thoiLuong);
        $stmt->bindParam(':hinhAnh', $hinhAnh);
        $stmt->bindParam(':trangThai', $trangThai);
        return $stmt->execute();
    }

    // =========================================================
    // DELETE - xóa thuốc tiêm (hoặc đánh dấu ngừng hoạt động)
    // =========================================================
    public function delete($maTP, $softDelete = true) {
        if ($softDelete) {
            $query = "UPDATE TiemPhong SET TrangThai = 'Ngừng hoạt động' WHERE MaTP = :maTP";
        } else {
            $query = "DELETE FROM TiemPhong WHERE MaTP = :maTP";
        }

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maTP', $maTP);
        return $stmt->execute();
    }

    // =========================================================
    // GETTERS
    // =========================================================
    public function getTenThuoc() { return $this->tenThuoc; }
    public function getGia() { return $this->gia; }
    public function getLoaiThuCung() { return $this->loaiThuCung; }

    // Các phương thức update, delete, getter/setter tương tự
}
?>