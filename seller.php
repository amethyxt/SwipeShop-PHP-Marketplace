<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
$message = ''; // Variable to store success/error messages

if (!$isLoggedIn) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'db.php'; // Ensure this connects using PDO

    // Retrieve the user ID from the session
    $user_id = $_SESSION['user_id'];

    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $description = $_POST['description'];

    // Handle file upload
    $target_dir = "uploads/products/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if the image is a valid image (optional)
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        // Upload image
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Save product information to the database, including user_id
            $stmt = $conn->prepare("INSERT INTO products (product_name, price, category, description, image_path, user_id) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$product_name, $price, $category, $description, basename($_FILES["image"]["name"]), $user_id]);

            // Add notification
            $notification_sql = "INSERT INTO notifications (user_id, notification_text, created_at) VALUES (?, ?, NOW())";
            $notification_stmt = $conn->prepare($notification_sql);
            $notification_text = "สินค้าของคุณได้ถูกเพิ่มเรียบร้อยแล้ว: " . $product_name;
            $notification_stmt->execute([$user_id, $notification_text]);

            $message = "<div class='bg-green-200 text-green-800 p-4 mb-4 rounded'>Product added successfully!</div>";
        } else {
            $message = "<div class='bg-red-200 text-red-800 p-4 mb-4 rounded'>Sorry, there was an error uploading your file.</div>";
        }
    } else {
        $message = "<div class='bg-red-200 text-red-800 p-4 mb-4 rounded'>File is not an image.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - SwipeShop</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 min-h-screen">
    <?php include './header.php'; ?>
    <div class="container mx-auto p-4">
        <header class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-blue-600">Add New Product</h1>
        </header>

        <form action="seller.php" method="post" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md mb-4">
            <div class="mb-4">
                <input type="text" name="product_name" placeholder="Product Name" required class="border p-3 w-full rounded focus:outline-none focus:ring focus:ring-blue-300">
            </div>
            <div class="mb-4">
                <input type="number" step="0.01" name="price" placeholder="Price" required class="border p-3 w-full rounded focus:outline-none focus:ring focus:ring-blue-300">
            </div>
            <div class="mb-4">
                <select name="category" required class="border p-3 w-full rounded focus:outline-none focus:ring focus:ring-blue-300">
                    <option value="" disabled selected>Select Category</option>
                    <option value="Electronics">Electronics</option>
                    <option value="Fashion">Fashion</option>
                    <option value="Home">Home</option>
                    <option value="Sports">Sports</option>
                </select>
            </div>
            <div class="mb-4">
                <textarea name="description" placeholder="Description" required class="border p-3 w-full rounded focus:outline-none focus:ring focus:ring-blue-300"></textarea>
            </div>
            <div class="mb-4">
                <input type="file" name="image" required class="border p-3 w-full rounded focus:outline-none focus:ring focus:ring-blue-300">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Add Product</button>
        </form>
        
        <!-- Display message below the form -->
        <?php if ($message): ?>
            <div class="mt-4">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>
