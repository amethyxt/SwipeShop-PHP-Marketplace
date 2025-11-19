<?php
session_start(); // Start session
include 'db.php'; // Connect to the database

// Check if the user is logged in and is a seller
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Check if order_id and new_status are set
if (isset($_POST['order_id']) && isset($_POST['new_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];
    
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

    // Update order status
    $sql = "UPDATE orders SET status = ? WHERE order_id = ? AND item_id IN (SELECT id FROM products WHERE user_id = ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sii', $new_status, $order_id, $_SESSION['user_id']);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Order status updated successfully.";
    } else {
        echo "Failed to update order status or you are not authorized to update this order.";
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>
