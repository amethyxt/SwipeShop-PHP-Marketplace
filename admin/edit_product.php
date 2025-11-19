<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Fetch the product details
    $sql = "SELECT * FROM products WHERE id = $productId";
    $result = mysqli_query($conn, $sql);
    $product = mysqli_fetch_assoc($result);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $productName = $_POST['product_name'];
        $price = $_POST['price'];
        $category = $_POST['category'];

        // Update product in database
        $sql = "UPDATE products SET product_name='$productName', price='$price', category='$category' WHERE id=$productId";
        if (mysqli_query($conn, $sql)) {
            header('Location: manage_products.php'); // Redirect back to the product management page
            exit;
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Product</h1>
        <form method="POST">
            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="product_name" value="<?php echo $product['product_name']; ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Price</label>
                <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Category</label>
                <input type="text" name="category" value="<?php echo $product['category']; ?>" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="manage_products.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>

<?php
mysqli_close($conn);
?>
