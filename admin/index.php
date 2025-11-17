<?php
// Bắt đầu phiên làm việc PHP, dùng để lưu trữ thông tin người dùng giữa các trang
session_start();  

// Nhúng file cấu hình cơ sở dữ liệu (database) để kết nối với DB
require_once '../config/database.php';  

// Nhúng file chứa class AdminController
require_once '../controller/AdminController.php';  


// Sử dụng namespace PetCare để truy cập class AdminController
use PetCare\AdminController;  


// Lấy tên controller từ URL (?controller=...), nếu không có thì mặc định là 'AdminController'
$controller = $_GET['controller'] ?? 'AdminController';  

// Lấy tên action từ URL (?action=...), nếu không có thì mặc định là 'hienThiTrangChu'
$action     = $_GET['action'] ?? 'hienThiTrangChu';  


// Tạo tên đầy đủ của class controller, bao gồm namespace
$controllerClass = "PetCare\\$controller";  


// Kiểm tra xem class controller có tồn tại hay không
if (class_exists($controllerClass)) {
    // Tạo đối tượng của class controller
    $obj = new $controllerClass();  


    // Kiểm tra xem phương thức (action) có tồn tại trong class không
    if (method_exists($obj, $action)) {
        // Gọi phương thức (action) tương ứng
        $obj->$action();
    } else {
        // Nếu không tìm thấy action trong controller, hiển thị lỗi
        echo "<h3>❌ Không tìm thấy hành động '$action' trong $controller</h3>";
    }
} else {
    // Nếu không tìm thấy controller, hiển thị lỗi
    echo "<h3>❌ Không tìm thấy controller '$controller'</h3>";
}
?>
