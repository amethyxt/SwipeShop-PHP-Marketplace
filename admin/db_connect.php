<?php
$servername = "localhost";
$username = "root";  // username ของ MySQL
$password = "";  // password ของ MySQL
$dbname = "swipeshop"; // ชื่อฐานข้อมูล

// สร้างการเชื่อมต่อ
$conn = mysqli_connect($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
