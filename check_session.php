<?php
session_start(); // เริ่มเซสชัน

// ตรวจสอบว่า user_id ถูกตั้งค่าหรือไม่
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['loggedIn' => false]);
} else {
    // ถ้า user_id ถูกตั้งค่า ให้ส่ง username กลับไปด้วย
    echo json_encode(['loggedIn' => true, 'username' => $_SESSION['username']]);
}
?>
