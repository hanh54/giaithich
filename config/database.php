<?php
/**
 * Cấu hình Hệ thống & Cơ sở dữ liệu (OOP)
 * Website: Hệ Thống chăm sóc thú y / PetCare
 */

namespace PetCare; // tránh xung đột \Petcare\user

use PDO; //PHP database objects, kết nối csdl
use PDOException; // xử lý lỗi csdl


date_default_timezone_set('Asia/Ho_Chi_Minh'); // Múi giờ Việt Nam, dùng thiết lập múi giờ cho tất cả các hàm xử lý ngày giờ

// Hằng số cấu hình cơ bản
define('BASE_URL', 'http://localhost/petcare'); // định nghĩa hằng số , khác với biến là giá trị hằng số không thay đổi trong quá trình chạy
define('DEFAULT_LANGUAGE', 'vi');

/**
 * Lớp cấu hình kết nối cơ sở dữ liệu sử dụng PDO
 */
class Database {
    private $host = 'localhost';
    private $db_name = 'petcare';
    private $username = 'root';
    private $password = '';
    private $conn;

    /**
     * Hàm khởi tạo: Tự động kết nối khi tạo đối tượng
     * @throws PDOException Nếu kết nối thất bại
     */
    public function __construct() { // luôn tự động chạy khi tạo 1 object từ class
        $this->connect(); //this là object hiện tại, khi constructor chạy, nó sẽ tự động gọi hàm kết nối database
    }

    /**
     * Kết nối tới cơ sở dữ liệu MySQL bằng PDO
     * @return PDO Kết nối database
     * @throws PDOException Nếu có lỗi kết nối
     */
    private function connect() {  // là hàm riêng tư chỉ dùng bên trong 
        try {  // chạy thử ở try, nếu lỗi sẽ sang catch
            $this->conn = new PDO(  // tạo kết nối MySQL kiểu PDO + 3 tham số Chuỗi định danh nguồn dữ liệu
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Kết nối cơ sở dữ liệu thất bại: " . $e->getMessage());
            throw new PDOException("Không thể kết nối tới cơ sở dữ liệu. Vui lòng thử lại sau.");
        }
    }

    /**
     * Trả về kết nối để các lớp Model sử dụng
     * @return PDO
     */
    public function getConnection() { //Truyền đối tượng kết nối đã tạo ra ngoài lớp.
        return $this->conn;
    }

    /**
     * Đóng kết nối khi đối tượng bị hủy
     */
    public function __destruct() {
        $this->conn = null; // PDO tự động đóng khi unset
    }
}

/**
 * Lớp tiện ích chung (Utility functions)
 */
class Utils {
    /**
     * Làm sạch đầu vào người dùng (chống XSS)
     * @param mixed $input Dữ liệu đầu vào
     * @return string Dữ liệu đã làm sạch
     */
    public static function sanitizeInput($input) {
        if (is_array($input)) {
            return array_map([self::class, 'sanitizeInput'], $input);
        }
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8'); //trim là khoảng trắng, chuyển đổi ký tự đặc biệt biệt có nghĩa trong html
    }

    /**
     * Ghi log lỗi
     * @param string $message Tin nhắn lỗi
     */
    public static function logError($message) {
        error_log(date('[Y-m-d H:i:s] ') . $message . PHP_EOL, 3, 'error.log');
    }
}

// 🔌 Khởi tạo kết nối toàn cục (có thể thay bằng dependency injection)
try {
    $db = new Database();
    $conn = $db->getConnection();
} catch (PDOException $e) {
    Utils::logError("Lỗi khởi tạo database: " . $e->getMessage());
    die("Có lỗi hệ thống. Vui lòng liên hệ quản trị viên.");
}
?>
