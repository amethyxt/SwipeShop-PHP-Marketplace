<?php
session_start();

header('Content-Type: application/json'); // Specify content type as JSON
error_reporting(0); // Disable error reporting

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die(json_encode(["status" => "error", "message" => "คุณต้องเข้าสู่ระบบก่อนที่จะกดถูกใจสินค้า"]));
}

$user_id = $_SESSION['user_id'];
$item_id = isset($_POST['item_id']) ? intval($_POST['item_id']) : 0;
$shipping_method = 'pickup'; // You can set this based on user choice

if ($item_id <= 0) {
    echo json_encode(["status" => "error", "message" => "item_id ไม่ถูกต้อง"]);
    exit();
}

// Connect to the database
$host = 'localhost';   
$dbname = 'swipeshop';
$username = 'swipeshop';
$password = 'swipeshop';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the item exists
    $product_check_query = "SELECT id, user_id, product_name FROM products WHERE id = :item_id"; // Include product_name
    $stmt = $conn->prepare($product_check_query);
    $stmt->bindParam(':item_id', $item_id);
    $stmt->execute();

    if ($stmt->rowCount() == 0) {
        echo json_encode(["status" => "error", "message" => "สินค้าไม่พบในระบบ"]);
        exit();
    }

    $product = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch product details

    // Check if the item has already been swiped
    $checkQuery = "SELECT * FROM swipes WHERE user_id = :user_id AND item_id = :item_id";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':item_id', $item_id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // If the user has already swiped this item
        echo json_encode(["status" => "error", "message" => "คุณได้กดถูกใจสินค้านี้ไปแล้ว"]);
    } else {
        // Get seller information
        $sellerQuery = "SELECT u.user_id, u.username FROM products p JOIN users u ON p.user_id = u.user_id WHERE p.id = :item_id"; // Fetch username
        $stmt = $conn->prepare($sellerQuery);
        $stmt->bindParam(':item_id', $item_id);
        $stmt->execute();
        $seller = $stmt->fetch(PDO::FETCH_ASSOC);

        // If not swiped yet, insert into the database
        $insertQuery = "INSERT INTO swipes (user_id, item_id, swipe_action, created_at) VALUES (:user_id, :item_id, 'right', NOW())";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':item_id', $item_id);
        $stmt->execute();

        // Insert order details
        if ($seller) {
            // Insert into orders table
            $orderQuery = "INSERT INTO orders (user_id, item_id, shipping_method, status, created_at, updated_at) 
                           VALUES (:user_id, :item_id, :shipping_method, 'pending', NOW(), NOW())";
            $order_stmt = $conn->prepare($orderQuery);
            $order_stmt->bindParam(':user_id', $user_id); // This is the buyer
            $order_stmt->bindParam(':item_id', $item_id);
            $order_stmt->bindParam(':shipping_method', $shipping_method);
            $order_stmt->execute();

            // Insert notification for the seller
            $notification_sql = "INSERT INTO notifications (user_id, notification_text, created_at) VALUES (:seller_id, :notification_text, NOW())";
            $notification_stmt = $conn->prepare($notification_sql);
            $notification_text = "ผู้ใช้ " . $seller['username'] . " ได้แสดงความสนใจในสินค้าของคุณ: " . $product['product_name']; // Use username and product name
            $seller_id = $seller['user_id'];
            $notification_stmt->bindParam(':seller_id', $seller_id);
            $notification_stmt->bindParam(':notification_text', $notification_text);
            $notification_stmt->execute();
        }

        // Retrieve order details for confirmation
        $order_id = $conn->lastInsertId(); // Get the last inserted order ID
        $orderDetailsQuery = "
            SELECT 
                o.order_id, 
                o.item_id, 
                o.shipping_method, 
                o.status, 
                b.username AS buyer_username, 
                s.username AS seller_username
            FROM orders o
            JOIN users b ON o.user_id = b.user_id  -- This is the buyer
            JOIN products p ON o.item_id = p.id
            JOIN users s ON p.user_id = s.user_id  -- This is the seller
            WHERE o.order_id = :order_id";
        $order_stmt = $conn->prepare($orderDetailsQuery);
        $order_stmt->bindParam(':order_id', $order_id);
        $order_stmt->execute();
        $orderDetails = $order_stmt->fetch(PDO::FETCH_ASSOC);

        echo json_encode([
            "status" => "success", 
            "message" => "คุณได้ถูกใจสินค้านี้เรียบร้อยแล้ว!",
            "seller_id" => $seller['user_id'], // Return seller_id if needed
            "order_details" => $orderDetails // Include order details in the response
        ]);
    }
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "เกิดข้อผิดพลาดในฐานข้อมูล"]);
}

$conn = null;
?>
