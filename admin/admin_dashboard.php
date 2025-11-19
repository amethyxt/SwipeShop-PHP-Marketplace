<?php
session_start();

// ตรวจสอบสิทธิ์ว่าเป็น Admin หรือไม่
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'Admin') {
    header("Location: login.php");
    exit();
}

// เชื่อมต่อฐานข้อมูล
include('db_connect.php');

// ดึงข้อมูลจำนวนผู้ใช้
$userCountQuery = "SELECT COUNT(*) as totalUsers FROM users";
$userCountResult = mysqli_query($conn, $userCountQuery);
$totalUsers = mysqli_fetch_assoc($userCountResult)['totalUsers'];

// ดึงข้อมูลจำนวนสินค้า
$productCountQuery = "SELECT COUNT(*) as totalProducts FROM products";
$productCountResult = mysqli_query($conn, $productCountQuery);
$totalProducts = mysqli_fetch_assoc($productCountResult)['totalProducts'];

// ดึงจำนวนการชำระเงิน
$paymentCountQuery = "SELECT COUNT(*) as totalPayments FROM payments";
$paymentCountResult = mysqli_query($conn, $paymentCountQuery);
$totalPayments = mysqli_fetch_assoc($paymentCountResult)['totalPayments'];

// ดึงข้อมูลจำนวนการแจ้งเตือน
$notificationCountQuery = "SELECT COUNT(*) as totalNotifications FROM notifications WHERE is_read = 0"; 
$notificationCountResult = mysqli_query($conn, $notificationCountQuery);
$totalNotifications = mysqli_fetch_assoc($notificationCountResult)['totalNotifications'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Arial', sans-serif;
        }

        .navbar {
            background: linear-gradient(90deg, #007bff, #6f42c1);
        }

        .navbar-brand,
        .nav-link {
            color: #fff !important;
        }

        .nav-link:hover {
            color: #ffdd57 !important;
        }

        .dashboard-card {
            border-radius: 12px;
            transition: transform 0.3s, box-shadow 0.3s;
            overflow: hidden;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .card-icon {
            font-size: 3.5rem;
        }

        .header-title {
            font-size: 2.5rem;
            margin-bottom: 30px;
            color: #343a40;
        }

        .section-title {
            margin-top: 40px;
            margin-bottom: 20px;
            color: #495057;
            font-weight: bold;
        }

        .btn {
            transition: background-color 0.3s, transform 0.3s;
        }

        .btn:hover {
            background-color: #007bff;
            transform: scale(1.05);
            color: #fff !important;
        }

        .admin-actions a {
            margin: 10px;
            width: 180px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="admin_dashboard.php">Home</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="manage_users.php">จัดการผู้ใช้</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manage_products.php">จัดการสินค้า</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manage_payments.php">จัดการการชำระเงิน</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manage_notifications.php">จัดการการแจ้งเตือน</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../logout.php">ออกจากระบบ</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center header-title">Admin Dashboard</h1>

        <div class="row">
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-4 dashboard-card">
                    <div class="card-body text-center">
                        <i class="fas fa-users card-icon"></i>
                        <h5 class="card-title">จำนวนผู้ใช้</h5>
                        <p class="card-text"><?php echo $totalUsers; ?> คน</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success mb-4 dashboard-card">
                    <div class="card-body text-center">
                        <i class="fas fa-box-open card-icon"></i>
                        <h5 class="card-title">จำนวนสินค้า</h5>
                        <p class="card-text"><?php echo $totalProducts; ?> รายการ</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning mb-4 dashboard-card"> <!-- Changed to bg-warning -->
                    <div class="card-body text-center">
                        <i class="fas fa-credit-card card-icon"></i>
                        <h5 class="card-title">การชำระเงิน</h5>
                        <p class="card-text"><?php echo $totalPayments; ?> รายการ</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-info mb-4 dashboard-card"> <!-- Changed to bg-info -->
                    <div class="card-body text-center">
                        <i class="fas fa-bell card-icon"></i>
                        <h5 class="card-title">การแจ้งเตือน</h5>
                        <p class="card-text"><?php echo $totalNotifications; ?> รายการ</p>
                    </div>
                </div>
            </div>
        </div>

        <h3 class="text-center section-title">การจัดการข้อมูล</h3>
        <div class="text-center mb-4">
            <div class="admin-actions">
                <a href="manage_users.php" class="btn btn-primary">จัดการผู้ใช้</a>
                <a href="manage_products.php" class="btn btn-success">จัดการสินค้า</a>
                <a href="manage_payments.php" class="btn btn-warning">จัดการการชำระเงิน</a>
                <a href="manage_notifications.php" class="btn btn-info">จัดการการแจ้งเตือน</a> <!-- Changed to btn-info -->
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

<?php
// ปิดการเชื่อมต่อฐานข้อมูล
mysqli_close($conn);
?>
