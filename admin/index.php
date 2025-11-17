<?php
session_start();
require_once '../config/database.php';
require_once '../controller/AdminController.php';


use PetCare\AdminController;


// Mặc định controller/action
$controller = $_GET['controller'] ?? 'AdminController';
$action     = $_GET['action'] ?? 'hienThiTrangChu';


$controllerClass = "PetCare\\$controller";


if (class_exists($controllerClass)) {
    $obj = new $controllerClass();


    if (method_exists($obj, $action)) {
        $obj->$action();
    } else {
        echo "<h3>❌ Không tìm thấy hành động '$action' trong $controller</h3>";
    }
} else {
    echo "<h3>❌ Không tìm thấy controller '$controller'</h3>";
}
?>



