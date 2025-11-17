
-- PetCare
CREATE TABLE TaiKhoan (
    MaTK INT PRIMARY KEY AUTO_INCREMENT,
    TenDangNhap VARCHAR(100) UNIQUE NOT NULL,
    MatKhau VARCHAR(255) NOT NULL,                -- lưu hash mật khẩu
    Email VARCHAR(150) UNIQUE,                    -- dùng cho quên mật khẩu, thông báo
    VaiTro ENUM('Admin','Khách hàng') NOT NULL DEFAULT 'Khách hàng',
    TrangThai ENUM('Hoạt động','Khóa') DEFAULT 'Hoạt động',
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO TaiKhoan (TenDangNhap, MatKhau, Email, VaiTro, TrangThai)
VALUES
('admin01', 'admin@123', 'admin@petcare.vn', 'Admin', 'Hoạt động'),
('kh01', 'kh01@123', 'lan@gmail.com', 'Khách hàng', 'Hoạt động'),
('kh02', 'kh02@123', 'nam@gmail.com', 'Khách hàng', 'Hoạt động');


-- 2. NHANVIEN (thêm MaTK để liên kết với TaiKhoan)
CREATE TABLE NhanVien (
    MaNV INT PRIMARY KEY AUTO_INCREMENT,
    HoTen NVARCHAR(150) NOT NULL,
    ChucVu ENUM('Bác sỹ thú y','Lễ Tân','Quản lý','Khác') DEFAULT 'Lễ Tân',
    SDT VARCHAR(20),
    Email VARCHAR(150),
    DiaChi NVARCHAR(255),
    NgayVaoLam DATE,
    TrangThai ENUM('Làm việc','Nghỉ việc') DEFAULT 'Làm việc',
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO NhanVien (HoTen, ChucVu, SDT, Email, DiaChi, NgayVaoLam, TrangThai)
VALUES
(N'Nguyễn Văn Quản', 'Quản lý', '0911111111', 'manager@petcare.vn', N'Hà Nội', '2022-05-01', 'Làm việc'),
(N'Lê Thu Trang', 'Bác sỹ thú y', '0922222222', 'bs.trang@petcare.vn', N'Hà Nội', '2023-03-12', 'Làm việc'),
(N'Phạm Đức Long', 'Lễ Tân', '0933333333', 'long@petcare.vn', N'Hà Nội', '2024-01-10', 'Làm việc'),
(N'Trần Văn Minh', 'Bác sỹ thú y', '0944444444', 'minh@petcare.vn', N'Hải Phòng', '2024-02-20', 'Làm việc'),
(N'Hoàng Mai Hương', 'Lễ Tân', '0955555555', 'huong@petcare.vn', N'Bắc Ninh', '2023-07-15', 'Làm việc');


-- 3. KHACHHANG
CREATE TABLE KhachHang (
    MaKH INT PRIMARY KEY AUTO_INCREMENT,
    MaTK INT UNIQUE,
    HoTen NVARCHAR(150) NOT NULL,
    SDT VARCHAR(20),
    Email VARCHAR(150),
    DiaChi NVARCHAR(255),
    NgayDangKy DATETIME DEFAULT CURRENT_TIMESTAMP,
    GhiChu NVARCHAR(500),
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (MaTK) REFERENCES TaiKhoan(MaTK)
);

INSERT INTO KhachHang (MaTK, HoTen, SDT, Email, DiaChi, GhiChu)
VALUES
(2, N'Nguyễn Thị Lan', '0981111111', 'lan@gmail.com', N'Hà Nội', N'Khách quen'),
(3, N'Phạm Văn Nam', '0982222222', 'nam@gmail.com', N'Bắc Ninh', N'Chủ nuôi mới');


-- 4. THUCUNG
CREATE TABLE ThuCung (
    MaTC INT PRIMARY KEY AUTO_INCREMENT,
    MaKH INT NOT NULL,
    TenTC NVARCHAR(100) NOT NULL,
    Loai ENUM('Chó','Mèo','Khác') DEFAULT 'Chó',
    Giong NVARCHAR(100),
    NgaySinh DATE,
    CanNang DECIMAL(5,2),          -- kg
    GioiTinh ENUM('Đực','Cái','Không rõ') DEFAULT 'Không rõ',
    TinhTrangSucKhoe NVARCHAR(500),
    LichSuTiem NVARCHAR(500),      
    HinhAnh VARCHAR(255),
    TrangThai enum('Họat động', 'Ngưng') DEFAULT 'Hoạt động'
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (MaKH) REFERENCES KhachHang(MaKH)
);

-- Các KhachHang đã được tạo ở trên có MaKH = 1 và 2
INSERT INTO ThuCung (MaKH, TenTC, Loai, Giong, NgaySinh, CanNang, GioiTinh, TinhTrangSucKhoe, LichSuTiem)
VALUES
(1, N'Bông', 'Chó', N'Poodle', '2021-05-20', 5.2, 'Cái', N'Khỏe mạnh', N'Đã tiêm 2 mũi cơ bản'),
(2, N'Miu', 'Mèo', N'Maine Coon', '2022-02-10', 4.0, 'Đực', N'Bình thường', N'Chưa tiêm phòng dại');


-- 5. TIEMPHONG (Dịch vụ / vaccine)
CREATE TABLE TiemPhong (
    MaTP INT PRIMARY KEY AUTO_INCREMENT,
    TenThuoc NVARCHAR(150) NOT NULL,
    MoTa NVARCHAR(1000),
    LoaiThuCung ENUM('Chó','Mèo','Cả hai') DEFAULT 'Cả hai',
    SoLanTiem INT DEFAULT 0,
    Gia DECIMAL(12,2) NOT NULL,
    ThoiLuong INT,                -- phút
    HinhAnh VARCHAR(255),
    TrangThai ENUM('HoatDong','Ngung') DEFAULT 'HoatDong',
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO TiemPhong (TenThuoc, MoTa, LoaiThuCung, SoLanTiem, Gia, ThoiLuong, HinhAnh)
VALUES
(N'Vaccine Dại', N'Tiêm phòng bệnh dại cho chó mèo', 'Cả hai', 1, 150000, 15, 'vac_dai.jpg'),
(N'Vaccine 7 bệnh', N'Phòng 7 bệnh nguy hiểm cho chó', 'Chó', 3, 250000, 20, 'vac_7b.jpg'),
(N'Vaccine Mèo dại', N'Phòng bệnh dại cho mèo', 'Mèo', 1, 180000, 15, 'vac_meo.jpg');


-- 6. DATLICH
CREATE TABLE DatLich (
    MaLich INT PRIMARY KEY AUTO_INCREMENT,
    MaKH INT NOT NULL,
    MaTC INT NOT NULL,
    MaTP INT NOT NULL,
    MaNV_DuKien INT DEFAULT NULL,  -- nhân viên dự kiến (có thể NULL)
    NgayDat DATETIME DEFAULT CURRENT_TIMESTAMP,
    NgayHen DATE NOT NULL,
    GioHen TIME NOT NULL,
    TrangThai ENUM('Chờ xác nhận','Đã xác nhận','Đang thực hiện','Hoàn thành','Hủy') DEFAULT 'Chờ xác nhận',
    TongTien DECIMAL(12,2) DEFAULT 0.00, -- có thể tính từ ChiTietDatLich
    GhiChu NVARCHAR(500),
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (MaKH) REFERENCES KhachHang(MaKH),
    FOREIGN KEY (MaTC) REFERENCES ThuCung(MaTC),
     FOREIGN KEY (MaTP) REFERENCES TiemPhong(MaTP),
    FOREIGN KEY (MaNV_DuKien) REFERENCES NhanVien(MaNV)
);

-- DatLich tham chiếu MaKH = 1 và 2; MaTC = 1 và 2
INSERT INTO DatLich (MaKH, MaTC, MaNV_DuKien, NgayHen, GioHen, TrangThai, TongTien, GhiChu)
VALUES
(1, 1, NULL, '2025-11-10', '09:00:00', 'Đã xác nhận', 150000, N'Tiêm phòng dại cho Bông'),
(2, 2, NULL, '2025-11-11', '10:30:00', 'Chờ xác nhận', 180000, N'Tiêm vaccine dại cho Miu');


-- 7. THANHTOAN (Admin xác nhận bằng MaAdmin_XacNhan -> TaiKhoan.MaTK)
CREATE TABLE ThanhToan (
    MaTT INT PRIMARY KEY AUTO_INCREMENT,
    MaLich INT NOT NULL,
    MaKH INT NOT NULL,
    MaAdmin_XacNhan INT DEFAULT NULL,  
    PhuongThuc ENUM('Tiền mặt','Chuyển khoản') NOT NULL,
    SoTien DECIMAL(12,2) NOT NULL,
    NgayThanhToan DATETIME DEFAULT CURRENT_TIMESTAMP,
    TrangThai ENUM('Chưa thanh toán','Đã thanh toán') DEFAULT 'Chưa thanh toán',
    GhiChu NVARCHAR(500),
    FOREIGN KEY (MaLich) REFERENCES DatLich(MaLich),
    FOREIGN KEY (MaKH) REFERENCES KhachHang(MaKH),
    FOREIGN KEY (MaAdmin_XacNhan) REFERENCES TaiKhoan(MaTK)
);

-- Lưu ý: MaAdmin_XacNhan = 1 (tài khoản admin01)
INSERT INTO ThanhToan (MaLich, MaKH, MaAdmin_XacNhan, PhuongThuc, SoTien, TrangThai, GhiChu)
VALUES
(1, 1, 1, 'Chuyển khoản', 150000, 'Đã thanh toán', N'Khách thanh toán đầy đủ'),
(2, 2, NULL, 'Tiền mặt', 180000, 'Chưa thanh toán', N'Khách sẽ thanh toán sau khi tiêm');


-- 8. CHITIET_THANHTOAN
CREATE TABLE ChiTietThanhToan (
    MaCTTT INT PRIMARY KEY AUTO_INCREMENT,
    MaTT INT NOT NULL,
    MaTP INT DEFAULT NULL,      
    MoTa NVARCHAR(300),
    SoLuong INT DEFAULT 1,
    DonGia DECIMAL(12,2) NOT NULL,
    ThanhTien DECIMAL(12,2) AS (SoLuong * DonGia) STORED,
    FOREIGN KEY (MaTT) REFERENCES ThanhToan(MaTT),
    FOREIGN KEY (MaTP) REFERENCES TiemPhong(MaTP)
);

INSERT INTO ChiTietThanhToan (MaTT, MaTP, MoTa, SoLuong, DonGia)
VALUES
(1, 1, N'Tiêm vaccine dại cho chó Bông', 1, 150000),
(2, 3, N'Tiêm vaccine dại cho mèo Miu', 1, 180000);


-- 9. LICH_SU_TIEU_PHONG
CREATE TABLE LichSuTiemPhong (
    MaLSTP INT PRIMARY KEY AUTO_INCREMENT,
    MaTC INT NOT NULL,
    MaTP INT DEFAULT NULL,         -- nếu tiêm là 1 dịch vụ
    TenVacXin NVARCHAR(200),
    LieuLuong NVARCHAR(100),
    NgayTiem DATE NOT NULL,
    MaNV_Tiem INT DEFAULT NULL,
    GhiChu NVARCHAR(500),
    FOREIGN KEY (MaTC) REFERENCES ThuCung(MaTC),
    FOREIGN KEY (MaTP) REFERENCES TiemPhong(MaTP),
    FOREIGN KEY (MaNV_Tiem) REFERENCES NhanVien(MaNV)
);

INSERT INTO LichSuTiemPhong (MaTC, MaTP, TenVacXin, LieuLuong, NgayTiem, MaNV_Tiem, GhiChu)
VALUES
(1, 1, N'Vaccine Dại', N'1ml', '2025-11-10', 2, N'Tiêm tại cơ sở chính'),
(2, 3, N'Vaccine Mèo Dại', N'0.8ml', '2025-11-11', 4, N'Sẽ tiêm trong lịch hẹn');


-- 10. BAOCAO_THONGKE
CREATE TABLE BaoCaoThongKe (
    MaBCTK INT PRIMARY KEY AUTO_INCREMENT,
    MaNV_Tao INT DEFAULT NULL,
    TenBaoCao NVARCHAR(200),
    ThoiGianBatDau DATE,
    ThoiGianKetThuc DATE,
    TongDoanhThu DECIMAL(15,2),
    TongSoLuongDV INT,
    SoKhachHangMoi INT,
    NoiDung NVARCHAR(2000),
    NgayTao DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (MaNV_Tao) REFERENCES NhanVien(MaNV)
);

INSERT INTO BaoCaoThongKe (MaNV_Tao, TenBaoCao, ThoiGianBatDau, ThoiGianKetThuc, TongDoanhThu, TongSoLuongDV, SoKhachHangMoi, NoiDung)
VALUES
(1, N'Báo cáo tháng 11/2025', '2025-11-01', '2025-11-30', 330000, 2, 1, N'Tổng hợp doanh thu dịch vụ tiêm phòng trong tháng 11/2025.');
