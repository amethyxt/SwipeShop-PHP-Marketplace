<?php
include 'db_connect.php';

// Fetch all payments
$sql_payments = "SELECT * FROM payments";
$result_payments = mysqli_query($conn, $sql_payments);

// Fetch all orders
$sql_orders = "SELECT * FROM orders";
$result_orders = mysqli_query($conn, $sql_orders);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment & Order Management</title>
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
        <h1>Order Management</h1>

        <!-- Order Management Section -->
        <h2>Order Management</h2>
        <form action="update_status.php" method="post">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Order ID</th>
                        <th>User ID</th>
                        <th>Item ID</th>
                        <th>Shipping Method</th>
                        <th>Status</th>
                        <th>Notification</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row_order = mysqli_fetch_assoc($result_orders)) { ?>
                        <tr>
                            <td><?php echo $row_order['order_id']; ?></td>
                            <td><?php echo $row_order['user_id']; ?></td>
                            <td><?php echo $row_order['item_id']; ?></td>
                            <td><?php echo $row_order['shipping_method']; ?></td>
                            <td>
                                <input type="hidden" name="order_id[]" value="<?php echo $row_order['order_id']; ?>">
                                <select name="status[]" class="form-control">
                                    <option value="pending" <?php echo $row_order['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="completed" <?php echo $row_order['status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
                                    <option value="canceled" <?php echo $row_order['status'] == 'canceled' ? 'selected' : ''; ?>>Canceled</option>
                                </select>
                            </td>
                            <td>
                                <?php 
                                    if ($row_order['status'] == 'pending') {
                                        echo '<span class="badge badge-warning">Confirmation Needed</span>'; 
                                    } else {
                                        echo '<span class="badge badge-success">No Action</span>'; 
                                    }
                                ?>
                            </td>
                            <td><?php echo $row_order['created_at']; ?></td>
                            <td><?php echo $row_order['updated_at']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <!-- Save button for order status updates -->
            <div class="text-center mt-3">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>

    <script>
        function confirmDelete() {
            return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบการชำระเงินนี้?');
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

<?php
// Close database connection
mysqli_close($conn);
?>
