<?php
/**
 * Header Template - Petcare
 */

// Get current user if logged in
$currentUser = getCurrentUser();

// Language is fixed to Vietnamese
$language = 'vi';
$lang = $language; // For compatibility with existing code

// Page-specific variables, default to empty if not set
$pageTitle = isset($pageTitle) ? $pageTitle : '';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo generatePageTitle($pageTitle, $language); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <?php if (basename($_SERVER['PHP_SELF']) == 'login.php' || basename($_SERVER['PHP_SELF']) == 'register.php' || basename($_SERVER['PHP_SELF']) == 'forgot-password.php'): ?>
        <link rel="stylesheet" href="assets/css/auth-styles.css">
    <?php endif; ?>
    <?php if (basename($_SERVER['PHP_SELF']) == 'index.php'): ?>
        <link rel="stylesheet" href="assets/css/home-styles.css">
    <?php endif; ?>
</head>
<!-- Header -->
<header class="site-header">
    <div class="container">
        <div class="logo">
            <a href="index.php">
                <img src="assets/images/logo.svg" alt="Petcare - Chăm sóc thú y và tiêm phòng vaccine">
            </a>
        </div>
        
        <nav class="main-navigation">
            <ul>
                <li><a href="index.php" <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'class="active"' : ''; ?>>Trang chủ</a></li>
                <li><a href="services.php" <?php echo basename($_SERVER['PHP_SELF']) == 'services.php' ? 'class="active"' : ''; ?>>Vacxin-Tiêm Phòng</a></li>
                <li><a href="appointments.php" <?php echo basename($_SERVER['PHP_SELF']) == 'appointments.php' ? 'class="active"' : ''; ?>>Đặt lịch</a></li>
                <li><a href="vaccination-history.php" <?php echo basename($_SERVER['PHP_SELF']) == 'vaccination-history.php' ? 'class="active"' : ''; ?>>Lịch sử tiêm phòng</a></li>
                <li><a href="contact.php" <?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'class="active"' : ''; ?>>Liên hệ</a></li>
            </ul>
        </nav>
        
        <div class="header-actions">
            <div class="user-actions">
                <?php if (isLoggedIn()): ?>
                    <div class="user-menu">
                        <span><i class="fas fa-user-circle"></i> <?php echo htmlspecialchars($currentUser['full_name']); ?></span>
                        <div class="dropdown-menu">
                            <a href="appointments.php"><i class="fas fa-calendar-check"></i> Lịch hẹn</a>
                            <?php if (isAdmin()): ?>
                                <a href="admin/index.php"><i class="fas fa-cog"></i> Quản trị</a>
                            <?php endif; ?>
                            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="login.php" class="btn btn-sm"><i class="fas fa-sign-in-alt"></i> Đăng nhập</a>
                    <a href="register.php" class="btn btn-sm btn-outline"><i class="fas fa-user-plus"></i> Đăng ký</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>