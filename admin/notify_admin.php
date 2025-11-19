<?php
session_start(); // Start the session
include 'db_connect.php'; // Include your database connection

// Check if the orderId is set in the POST request
if (isset($_POST['orderId'])) {
    $orderId = $_POST['orderId'];

    // Perform your logic to notify the admin about the order
    // For example, you might insert a record into a notifications table
    // Example: notifying admin logic (pseudo-code)
    $sql = "UPDATE orders SET admin_notified = 1 WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $orderId);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Admin notified successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database error']);
    }

    $stmt->close(); // Close the prepared statement
} else {
    // Handle the case where orderId is not set
    echo json_encode(['status' => 'error', 'message' => 'orderId is required']);
}

// Close database connection
$conn->close();
?>
