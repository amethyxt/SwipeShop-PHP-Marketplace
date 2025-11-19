<?php
session_start(); // Start session
include 'db.php'; // Connect to the database

// Check if the user is logged in
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

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user data from the database
$sql = "SELECT user_id, username, email, profile_picture, created_at FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$user_result = $stmt->get_result();
$user_data = $user_result->fetch_assoc();

// Fetch orders data from the database with additional details
$sql_orders = "
    SELECT o.order_id, o.item_id, o.user_id AS buyer_id, o.shipping_method, o.status, o.created_at, 
           p.product_name, p.price, 
           u.username AS seller_username
    FROM orders AS o 
    JOIN products AS p ON o.item_id = p.id
    JOIN users AS u ON p.user_id = u.user_id
    WHERE o.user_id = ? 
    ORDER BY o.created_at DESC
";
$stmt_orders = $conn->prepare($sql_orders);
$stmt_orders->bind_param('i', $_SESSION['user_id']);
$stmt_orders->execute();
$order_result = $stmt_orders->get_result();

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .profile-button {
            background-color: #007bff;
            color: white;
            transition: background-color 0.3s;
        }

        .profile-button:hover {
            background-color: #0056b3;
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

        .link-item:hover {
            color: #007bff;
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

        .alert {
            margin-bottom: 20px;
        }

        .order-box {
            border: 1px solid #007bff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .order-box h5 {
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <?php include './header.php'; ?>
    <div class="container rounded bg-white mt-5 mb-5 shadow-sm">
        <div class="row">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5 profile-header">
                    <img src="<?php echo $user_data['profile_picture'] ?: 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg'; ?>" alt="Profile Picture">
                    <span class="font-weight-bold"><?php echo htmlspecialchars($user_data['username']); ?></span>
                    <span class="text-black-50"><?php echo htmlspecialchars($user_data['email']); ?></span>
                </div>
            </div>
            <div class="col-md-5 border-right">
                <div class="p-3 py-5">
                    <h4 class="text-center mb-4 mt-5">Order Details</h4>
                    <?php if ($order_result->num_rows > 0): ?>
                        <p>Number of orders: <?php echo $order_result->num_rows; ?></p>
                        <?php while ($row = $order_result->fetch_assoc()): ?>
                            <div class="order-box">
                                <h5>Status: <?php echo htmlspecialchars($row['status']); ?></h5>
                                <p><strong>สินค้า:</strong> <?php echo htmlspecialchars($row['product_name']); ?></p>
                                <p><strong>ราคา:</strong> <?php echo htmlspecialchars($row['price']); ?> บาท</p>
                                <p><strong>ผู้ซื้อ:</strong> <?php echo htmlspecialchars($user_data['username']); ?></p>
                                <p><strong>ผู้ขาย:</strong> <?php echo htmlspecialchars($row['seller_username']); ?></p>
                                <p><strong>วันที่สั่งซื้อ:</strong> <?php echo date('F j, Y', strtotime($row['created_at'])); ?></p>
                                <button class="chat-btn btn btn-primary mt-2" data-buyer-id="<?php echo $_SESSION['user_id']; ?>" data-item-id="<?php echo htmlspecialchars($row['item_id']); ?>">Chat</button>
                                <button class="confirm-btn btn btn-success mt-2" data-order-id="<?php echo $row['order_id']; ?>">Confirm</button> <!-- Confirm Button -->
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="alert alert-info" role="alert">
                            No order details available.
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

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    $(document).ready(function() {
        // Function to generate a unique chat code
        function generateChatCode() {
            return Math.random().toString(36).substr(2, 9); // Simple random string generator
        }

        // Event listener for chat buttons
        $('.chat-btn').on('click', function() {
            const userId = $(this).data('buyer-id'); // Get buyer ID
            const itemId = $(this).data('item-id');   // Get item ID
            
            // Generate a unique chat code
            const chatCode = generateChatCode(); // Call a function to generate the code

            // Send the chat code and item information to notification.php
            $.ajax({
                url: 'notification.php',
                method: 'POST',
                data: {
                    userId: userId,
                    itemId: itemId,
                    chatCode: chatCode,
                },
                success: function(response) {
                    console.log('Notification sent successfully:', response);
                    // Redirect to chat page or open chat modal
                    const username = "<?php echo urlencode($user_data['username']); ?>";
                    window.location.href = `index.html?chatCode=${chatCode}&username=${username}`;
                },
                error: function(xhr, status, error) {
                    console.error('Error sending notification:', error);
                }
            });
        });

        // Event listener for confirm buttons
        $('.confirm-btn').on('click', function() {
            const orderId = $(this).data('order-id'); // Get order ID

            // Confirm order status via AJAX
            $.ajax({
                url: 'confirm_order.php',
                method: 'POST',
                data: {
                    orderId: orderId,
                },
                success: function(response) {
                    alert('Order confirmed successfully!'); // Notify the user
                    location.reload(); // Reload the page to see the changes
                },
                error: function(xhr, status, error) {
                    console.error('Error confirming order:', error);
                }
            });
        });
    });
    </script>
</body>

</html>
