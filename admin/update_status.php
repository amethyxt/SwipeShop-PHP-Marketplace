<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_ids = $_POST['order_id'];
    $statuses = $_POST['status'];

    for ($i = 0; $i < count($order_ids); $i++) {
        $order_id = $order_ids[$i];
        $status = $statuses[$i];

        // Update the status in the database
        $sql = "UPDATE orders SET status = ?, updated_at = NOW() WHERE order_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $status, $order_id);
        mysqli_stmt_execute($stmt);
    }

    // Redirect back to the manage orders page after updating
    header("Location: manage_Payments.php");
    exit();
}

// Close the database connection
mysqli_close($conn);
?>
