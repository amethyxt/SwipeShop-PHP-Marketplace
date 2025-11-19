<?php
include 'db_connect.php';

// ตรวจสอบว่ามีการส่ง ID ของการแจ้งเตือนเข้ามาหรือไม่
if (isset($_GET['notification_id'])) {
    $notificationId = $_GET['notification_id'];

    // ดึงข้อมูลการแจ้งเตือนจากฐานข้อมูลเพื่อนำมาแสดง
    $sql = "SELECT * FROM notifications WHERE notification_id = $notificationId";
    $result = mysqli_query($conn, $sql);
    $notification = mysqli_fetch_assoc($result);

    // ถ้ามีการกดปุ่มแก้ไขให้ทำการอัพเดทข้อมูล
    if (isset($_POST['update'])) {
        $notificationText = $_POST['notification_text'];
        $isRead = isset($_POST['is_read']) ? 1 : 0; // เช็คว่ามีการติ๊กเป็น 'อ่านแล้ว' หรือไม่

        // อัพเดทข้อมูลในฐานข้อมูล
        $sql = "UPDATE notifications SET notification_text='$notificationText', is_read='$isRead' WHERE notification_id = $notificationId";
        
        if (mysqli_query($conn, $sql)) {
            header('Location: manage_notifications.php'); // กลับไปที่หน้าจัดการการแจ้งเตือน
            exit;
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Notification</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Edit Notification</h1>
        <form action="" method="POST">
            <div class="form-group">
                <label for="notification_text">Notification Text</label>
                <input type="text" class="form-control" id="notification_text" name="notification_text" value="<?php echo htmlspecialchars($notification['notification_text']); ?>" required>
            </div>
            <div class="form-group">
                <input type="checkbox" id="is_read" name="is_read" <?php echo $notification['is_read'] ? 'checked' : ''; ?>>
                <label for="is_read">Mark as Read</label>
            </div>
            <button type="submit" name="update" class="btn btn-primary">Update Notification</button>
            <a href="manage_notifications.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>
