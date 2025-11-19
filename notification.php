<?php
session_start(); // Start session
include 'db.php'; // Include database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Database connection details
$host = 'localhost';
$db = 'swipeshop';
$user = 'swipeshop';
$pass = 'swipeshop';
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user data
$sql = "SELECT user_id, username, profile_picture, email, created_at FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$user_result = $stmt->get_result();
$user_data = $user_result->fetch_assoc();

// Mark notifications as read
$updateSql = "UPDATE notifications SET is_read = 1 WHERE user_id = ? AND is_read = 0";
$updateStmt = $conn->prepare($updateSql);
$updateStmt->bind_param('i', $_SESSION['user_id']);
$updateStmt->execute();

// Get notifications
$sql = "SELECT notification_text, created_at FROM notifications WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

try {
    // Handle POST requests for item interest notifications
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userId'], $_POST['itemId'], $_POST['chatCode'])) {
        $user_id = $_POST['userId'];
        $item_id = $_POST['itemId'];
        $chat_code = $_POST['chatCode'];

        // Use prepared statements for better security
        $checkQuery = "SELECT * FROM products WHERE id = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param('i', $item_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 0) {
            echo json_encode(["status" => "error", "message" => "สินค้าไม่พบในระบบ"]);
            exit();
        }

        // Get seller information
        $sellerQuery = "SELECT u.user_id, u.username FROM products p JOIN users u ON p.user_id = u.user_id WHERE p.id = ?";
        $stmt = $conn->prepare($sellerQuery);
        $stmt->bind_param('i', $item_id);
        $stmt->execute();
        $seller = $stmt->get_result()->fetch_assoc();

        if ($seller) {
            // Insert notification for the seller
            $notification_sql = "INSERT INTO notifications (user_id, notification_text, is_read, created_at) VALUES (?, ?, 0, NOW())";
            $insert_notification_stmt = $conn->prepare($notification_sql);
            $seller_notification_text = "ผู้ใช้ " . htmlspecialchars($user_data['username']) . " สนใจสินค้าของคุณ: " .
                "ห้องแชทของคุณคือ: <a href='index.html?chatCode=" . urlencode($chat_code) . "&username=" . urlencode($user_data['username']) . "'>" .
                htmlspecialchars($chat_code) . "</a>";

            $seller_id = $seller['user_id'];
            $insert_notification_stmt->bind_param('is', $seller_id, $seller_notification_text);
            $insert_notification_stmt->execute();

            echo json_encode([
                "status" => "success",
                "message" => "คุณได้ถูกใจสินค้านี้เรียบร้อยแล้ว!",
                "chat_code" => $chat_code // Return chat code if needed
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "ไม่พบผู้ขายสำหรับสินค้านี้"]);
        }
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "เกิดข้อผิดพลาดในฐานข้อมูล: " . $e->getMessage()]);
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .link-item {
            margin-bottom: 10px;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            color: #343a40;
            text-decoration: none;
            transition: color 0.3s;
        }

        .link-item i {
            margin-right: 10px;
        }

        .notification-item {
            background-color: #ffffff;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .notification-item:hover {
            background-color: #f1f1f1;
        }

        .notification-time {
            font-size: 0.8rem;
            color: #999;
        }

        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-header img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <?php include './header.php'; ?>
    <div class="container rounded bg-white mt-5 mb-5 shadow-sm">
        <div class="row">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5 profile-header">
                    <img src="<?php echo $user_data['profile_picture'] ?: 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg'; ?>"
                        alt="Profile Picture">
                    <span class="font-weight-bold"><?php echo htmlspecialchars($user_data['username']); ?></span>
                    <span class="text-black-50"><?php echo htmlspecialchars($user_data['email']); ?></span>
                </div>
            </div>
            <div class="col-md-5 border-right">
                <div class="p-3 py-5">
                    <div class="text-center mb-4">
                        <h4>Notifications</h4>
                    </div>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <div class="notification-item">
                                <!-- Display notification text directly from the database -->
                                <p><?php echo $row['notification_text']; ?></p>
                                <span
                                    class="notification-time"><?php echo date('F j, Y, g:i a', strtotime($row['created_at'])); ?></span>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="alert alert-info" role="alert">
                            ไม่มีการแจ้งเตือนใหม่
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4">
                    <h4 class="text-center mb-4">Menu</h4>
                    <div class="d-flex flex-column align-items-start">
                        <a href="account.php" class="link-item"><i class="fas fa-user"></i> Account</a>
                        <a href="order.php" class="link-item"><i class="fas fa-box"></i> Order</a>
                        <a href="notification.php" class="link-item"><i class="fas fa-bell"></i> Notification</a>
                        <a href="logout.php" class="link-item"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>