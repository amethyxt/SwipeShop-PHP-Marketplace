<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Delete the product from the database
    $sql = "DELETE FROM products WHERE id = $productId";
    if (mysqli_query($conn, $sql)) {
        header('Location: manage_products.php'); // Redirect back to the product management page
        exit;
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
