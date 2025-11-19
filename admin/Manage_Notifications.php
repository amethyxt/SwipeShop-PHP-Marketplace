<?php
include 'db_connect.php';

// Fetch all notifications
$sql = "SELECT * FROM notifications";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Arial', sans-serif;
        }

        .navbar {
            background: linear-gradient(90deg, #007bff, #6f42c1);
            margin-bottom: 20px;
        }

        .navbar-brand,
        .nav-link {
            color: #fff !important;
        }

        .nav-link:hover {
            color: #ffdd57 !important;
        }

        h1 {
            margin: 20px 0;
            text-align: center;
            color: #343a40;
        }

        .table {
            margin-top: 20px;
        }

        .btn {
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0056b3;
            color: white;
        }

        .actions a {
            margin-right: 10px;
        }

        .read-status {
            font-weight: bold;
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
        <h1>Notification Management</h1> <!-- เปลี่ยนข้อความที่นี่ -->
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Notification ID</th>
                    <th>User ID</th>
                    <th>Notification Text</th>
                    <th>Read Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['notification_id']; ?></td>
                        <td><?php echo $row['user_id']; ?></td>
                        <td><?php echo htmlspecialchars($row['notification_text']); ?></td>
                        <td class="read-status"><?php echo $row['is_read'] ? 'Read' : 'Unread'; ?></td>
                        <td class="actions">
                            <a href="edit_notification.php?notification_id=<?php echo $row['notification_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_notification.php?notification_id=<?php echo $row['notification_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirmDelete()">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script>
        function confirmDelete() {
            return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบการแจ้งเตือนนี้?');
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

<?php
// ปิดการเชื่อมต่อฐานข้อมูล
mysqli_close($conn);
?>
