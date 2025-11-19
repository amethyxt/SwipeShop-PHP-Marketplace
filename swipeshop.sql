-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2024 at 08:04 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `swipeshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `notification_text` varchar(255) NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `user_id`, `notification_text`, `is_read`, `created_at`) VALUES
(1, 1, 'สินค้าของคุณได้ถูกเพิ่มเรียบร้อยแล้ว: 3141', 1, '2024-10-16 07:51:54'),
(2, 2, 'สินค้าของคุณได้ถูกเพิ่มเรียบร้อยแล้ว: 421', 1, '2024-10-16 09:07:57'),
(3, 2, 'สินค้าของคุณได้ถูกเพิ่มเรียบร้อยแล้ว: 4141', 1, '2024-10-16 09:43:15'),
(4, 1, 'สินค้าของคุณได้ถูกเพิ่มเรียบร้อยแล้ว: boss', 1, '2024-10-16 09:47:51'),
(11, 1, 'สินค้าของคุณได้ถูกเพิ่มเรียบร้อยแล้ว: Somtom', 1, '2024-10-16 14:28:49'),
(13, 1, 'สินค้าของคุณได้ถูกเพิ่มเรียบร้อยแล้ว: God', 1, '2024-10-16 14:30:18'),
(14, 1, 'ผู้ใช้ 1 ได้ถูกใจสินค้าของคุณ: 9', 1, '2024-10-16 14:30:29'),
(15, 1, 'สินค้าของคุณได้ถูกเพิ่มเรียบร้อยแล้ว: 5231', 1, '2024-10-16 14:41:31'),
(16, 1, 'ผู้ใช้ 1 ได้แสดงความสนใจในสินค้าของคุณ: 10', 1, '2024-10-16 14:41:35'),
(17, 1, 'ผู้ใช้ 2 ได้แสดงความสนใจในสินค้าของคุณ: 8', 1, '2024-10-16 14:42:09'),
(18, 1, 'ผู้ใช้ 2 ได้แสดงความสนใจในสินค้าของคุณ: 9', 1, '2024-10-16 14:42:09'),
(19, 1, 'ผู้ใช้ 2 ได้แสดงความสนใจในสินค้าของคุณ: 10', 1, '2024-10-16 14:42:10'),
(20, 1, 'สินค้าของคุณได้ถูกเพิ่มเรียบร้อยแล้ว: 5255', 1, '2024-10-16 14:56:13'),
(21, 1, 'ผู้ใช้ 2 ได้แสดงความสนใจในสินค้าของคุณ: 11', 1, '2024-10-16 14:57:42'),
(22, 2, 'สินค้าของคุณได้ถูกเพิ่มเรียบร้อยแล้ว: petch', 1, '2024-10-16 15:15:17'),
(23, 2, 'ผู้ใช้ 1 ได้แสดงความสนใจในสินค้าของคุณ: 12', 1, '2024-10-16 15:15:27'),
(24, 2, 'สินค้าของคุณได้ถูกเพิ่มเรียบร้อยแล้ว: user111', 1, '2024-10-16 16:50:02'),
(25, 2, 'ผู้ใช้ 1 ได้แสดงความสนใจในสินค้าของคุณ: 13', 1, '2024-10-16 16:50:10'),
(26, 2, 'สินค้าของคุณได้ถูกเพิ่มเรียบร้อยแล้ว: 5215215215215', 1, '2024-10-16 16:55:10'),
(27, 2, 'ผู้ใช้ 1 ได้แสดงความสนใจในสินค้าของคุณ: 14', 1, '2024-10-16 16:55:23'),
(28, 2, 'ผู้ใช้ user1 ได้แสดงความสนใจในสินค้าของคุณ: 14. ห้องแชทของคุณคือ: 73qgz83p3', 1, '2024-10-16 17:04:18'),
(29, 2, 'ผู้ใช้ user1 ได้แสดงความสนใจในสินค้าของคุณ: 14. ห้องแชทของคุณคือ: <a href=\'chat.php?chat_code=4oq3ygjdd\'>4oq3ygjdd</a>', 1, '2024-10-16 17:09:27'),
(30, 2, 'ผู้ใช้ user1 ได้แสดงความสนใจในสินค้าของคุณ: 13. ห้องแชทของคุณคือ: <a href=\'chat.php?chat_code=xmjl1div7\'>xmjl1div7</a>', 1, '2024-10-16 17:12:25'),
(31, 2, 'ผู้ใช้ user1 ได้แสดงความสนใจในสินค้าของคุณ: 12. ห้องแชทของคุณคือ: <a href=\'index.html?chatCode=one7ze4cl&username=user1\'>one7ze4cl</a>', 1, '2024-10-16 17:14:53'),
(32, 2, 'ผู้ใช้ user1 ได้แสดงความสนใจในสินค้าของคุณ: 12. ห้องแชทของคุณคือ: <a href=\'index.html?chatCode=16lfm73oy&username=user1\'>16lfm73oy</a>', 1, '2024-10-16 17:15:19'),
(33, 2, 'ผู้ใช้ user1 ได้แสดงความสนใจในสินค้าของคุณ: 14. ห้องแชทของคุณคือ: <a href=\'index.html?chatCode=p4ajgkm45&username=user1\'>p4ajgkm45</a>', 1, '2024-10-16 17:53:21'),
(34, 2, 'ผู้ใช้ user1 ได้แสดงความสนใจในสินค้าของคุณ: 14. ห้องแชทของคุณคือ: <a href=\'index.html?chatCode=19fqj3796&username=user1\'>19fqj3796</a>', 1, '2024-10-16 17:53:30'),
(35, 2, 'ผู้ใช้ user1 ได้แสดงความสนใจในสินค้าของคุณ: 14. ห้องแชทของคุณคือ: <a href=\'index.html?chatCode=xiyadk0ox&username=user1\'>xiyadk0ox</a>', 1, '2024-10-16 17:53:40'),
(36, 2, 'ผู้ใช้ user1 ได้แสดงความสนใจในสินค้าของคุณ: 12. ห้องแชทของคุณคือ: <a href=\'index.html?chatCode=1p6l4xffm&username=user1\'>1p6l4xffm</a>', 1, '2024-10-16 17:53:53'),
(37, 2, 'ผู้ใช้ user1 ได้แสดงความสนใจในสินค้าของคุณ: 14. ห้องแชทของคุณคือ: <a href=\'index.html?chatCode=sp5b6pzvb&username=user1\'>sp5b6pzvb</a>', 1, '2024-10-16 17:54:38'),
(38, 2, 'ผู้ใช้ user1 ได้แสดงความสนใจในสินค้าของคุณ: 14. ห้องแชทของคุณคือ: <a href=\'index.html?chatCode=yci1gsx8a&username=user1\'>yci1gsx8a</a>', 1, '2024-10-16 17:55:17'),
(39, 2, 'ผู้ใช้ user1 ได้แสดงความสนใจในสินค้าของคุณ: 14. ห้องแชทของคุณคือ: <a href=\'index.html?chatCode=euc9ou6kn&username=user1\'>euc9ou6kn</a>', 1, '2024-10-16 17:56:16'),
(40, 2, 'ผู้ใช้ user1 ได้แสดงความสนใจในสินค้าของคุณ: 14. ห้องแชทของคุณคือ: <a href=\'index.html?chatCode=8cyqiewx6&username=user1\'>8cyqiewx6</a>', 1, '2024-10-16 17:58:38'),
(41, 2, 'ผู้ใช้ user1 ได้แสดงความสนใจในสินค้าของคุณ: 14. ห้องแชทของคุณคือ: <a href=\'index.html?chatCode=en5rz5lz6&username=user1\'>en5rz5lz6</a>', 1, '2024-10-16 17:59:15'),
(42, 2, 'ผู้ใช้ user1 ได้แสดงความสนใจในสินค้าของคุณ: 14. ห้องแชทของคุณคือ: <a href=\'index.html?chatCode=22b2k0vy5&username=user1\'>22b2k0vy5</a>', 1, '2024-10-16 18:03:57'),
(43, 2, 'ผู้ใช้ user1 ได้แสดงความสนใจในสินค้าของคุณ: 14. ห้องแชทของคุณคือ: <a href=\'index.html?chatCode=m9a62hujd&username=user1\'>m9a62hujd</a>', 1, '2024-10-16 18:03:58'),
(44, 2, 'ผู้ใช้ user1 ได้แสดงความสนใจในสินค้าของคุณ: 14. ห้องแชทของคุณคือ: <a href=\'index.html?chatCode=bx13voa6t&username=user1\'>bx13voa6t</a>', 1, '2024-10-16 18:03:59'),
(45, 2, 'ผู้ใช้ user1 ได้แสดงความสนใจในสินค้าของคุณ: 14. ห้องแชทของคุณคือ: <a href=\'index.html?chatCode=2vi32dstv&username=user1\'>2vi32dstv</a>', 1, '2024-10-16 18:04:11'),
(46, 2, 'ผู้ใช้ user1 ได้แสดงความสนใจในสินค้าของคุณ: 14. ห้องแชทของคุณคือ: <a href=\'index.html?chatCode=7vxqbzs76&username=user1\'>7vxqbzs76</a>', 1, '2024-10-16 18:04:11'),
(47, 2, 'ผู้ใช้ user1 ได้แสดงความสนใจในสินค้าของคุณ: 14. ห้องแชทของคุณคือ: <a href=\'index.html?chatCode=riolhwe7w&username=user1\'>riolhwe7w</a>', 1, '2024-10-16 18:04:12'),
(48, 2, 'ผู้ใช้ user1 ได้แสดงความสนใจในสินค้าของคุณ: 14. ห้องแชทของคุณคือ: <a href=\'index.html?chatCode=qgeusgb24&username=user1\'>qgeusgb24</a>', 1, '2024-10-16 18:04:41'),
(49, 2, 'ผู้ใช้ user1 ได้แสดงความสนใจในสินค้าของคุณ: 14. ห้องแชทของคุณคือ: <a href=\'index.html?chatCode=mkjy6bw6w&username=user1\'>mkjy6bw6w</a>', 1, '2024-10-16 18:04:41'),
(50, 2, 'ผู้ใช้ user1 ได้แสดงความสนใจในสินค้าของคุณ: 14. ห้องแชทของคุณคือ: <a href=\'index.html?chatCode=rz7pn6wbp&username=user1\'>rz7pn6wbp</a>', 1, '2024-10-16 18:04:42'),
(51, 2, 'ผู้ใช้ user1 ได้แสดงความสนใจในสินค้าของคุณ: 14. ห้องแชทของคุณคือ: <a href=\'index.html?chatCode=gst8qjgpi&username=user1\'>gst8qjgpi</a>', 1, '2024-10-16 18:05:10'),
(52, 2, 'ผู้ใช้ user1 ได้แสดงความสนใจในสินค้าของคุณ: 14. ห้องแชทของคุณคือ: <a href=\'index.html?chatCode=cv1zt78ai&username=user1\'>cv1zt78ai</a>', 1, '2024-10-16 18:05:21'),
(53, 1, 'ผู้ใช้ user11 สนใจสินค้าของคุณ: ห้องแชทของคุณคือ: <a href=\'index.html?chatCode=xsko95sd3&username=user11\'>xsko95sd3</a>', 0, '2024-10-17 03:22:41'),
(54, 1, 'ผู้ใช้ user11 สนใจสินค้าของคุณ: ห้องแชทของคุณคือ: <a href=\'index.html?chatCode=2ha6hg5v7&username=user11\'>2ha6hg5v7</a>', 0, '2024-10-17 03:22:48'),
(55, 1, 'ผู้ใช้ user11 สนใจสินค้าของคุณ: ห้องแชทของคุณคือ: <a href=\'index.html?chatCode=cz4mca3t3&username=user11\'>cz4mca3t3</a>', 0, '2024-10-17 03:23:34'),
(56, 1, 'ผู้ใช้ user11 สนใจสินค้าของคุณ: ห้องแชทของคุณคือ: <a href=\'index.html?chatCode=qn8ch2t00&username=user11\'>qn8ch2t00</a>', 0, '2024-10-17 03:23:39'),
(57, 2, 'สินค้าของคุณได้ถูกเพิ่มเรียบร้อยแล้ว: VGA ASUS GEFORCE RTX 4090 ROG STRIX O24G GAMING - 24GB GDDR6X', 1, '2024-10-17 04:20:23'),
(58, 2, 'สินค้าของคุณได้ถูกเพิ่มเรียบร้อยแล้ว: Stussy Basic Stussy T-Shirt Black (SS22)', 1, '2024-10-17 04:21:36'),
(59, 2, 'สินค้าของคุณได้ถูกเพิ่มเรียบร้อยแล้ว: WashG1 เครื่องดูดถูพื้น (95 วัตต์, 1 ลิตร) รุ่น WR01 WASHG1 BK/BU', 1, '2024-10-17 04:22:26'),
(60, 2, 'ผู้ใช้ user11 ได้แสดงความสนใจในสินค้าของคุณ: VGA ASUS GEFORCE RTX 4090 ROG STRIX O24G GAMING - 24GB GDDR6X', 1, '2024-10-17 04:22:28'),
(61, 2, 'สินค้าของคุณได้ถูกเพิ่มเรียบร้อยแล้ว: UMBRO Neo Swerve ลูกฟุตบอล', 1, '2024-10-17 04:23:59'),
(62, 2, 'สินค้าของคุณได้ถูกเพิ่มเรียบร้อยแล้ว: Umbro UMBRO Neo Swerve Match 21261U-LN5', 1, '2024-10-17 04:24:51');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `item_id` int(10) UNSIGNED NOT NULL,
  `shipping_method` enum('pickup','delivery') NOT NULL,
  `status` enum('pending','completed','canceled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `item_id`, `shipping_method`, `status`, `created_at`, `updated_at`) VALUES
(8, 2, 15, 'pickup', 'pending', '2024-10-17 04:22:28', '2024-10-17 05:18:58');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `item_id` int(10) UNSIGNED DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_status` enum('pending','completed','failed') NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `price`, `category`, `description`, `image_path`, `created_at`, `user_id`) VALUES
(15, 'VGA ASUS GEFORCE RTX 4090 ROG STRIX O24G GAMING - 24GB GDDR6X', 90500.00, 'Electronics', 'Memory Size : 24GB\r\nMemory Type : GDDR6X\r\nMemory Interface : 384-bit\r\nBus Interface : PCI Express 4.0\r\nOutput : HDMI x 1, DisplayPort x 3\r\n\r\nROG Strix GeForce RTX® 4090 OC Edition 24GB GDDR6X buffed-up design with chart-topping thermal performance.\r\nNVIDIA Ada Lovelace Streaming Multiprocessors: Up to 2x performance and power efficiency\r\n4th Generation Tensor Cores: Up to 2X AI performance\r\n3rd Generation RT Cores: Up to 2X ray tracing performance\r\nAxial-tech fans scaled up for 23% more airflow\r\nNew patented vapor chamber with milled heatspreader for lower GPU temps \r\n3.5-slot design: massive fin array optimized for airflow from the three Axial-tech fans \r\nDiecast shroud, frame, and backplate add rigidity and are vented to further maximize airflow and heat dissipation\r\nDigital power control with high-current power stages and 15K capacitors to fuel maximum performance\r\nAuto-Extreme precision automated manufacturing for higher reliability \r\nGPU Tweak III software provides intuitive performance tweaking, thermal controls, and system monitoring\r\n', 'A0146692OK_BIG_1.webp', '2024-10-17 04:20:23', 2),
(16, 'Stussy Basic Stussy T-Shirt Black (SS22)', 2290.00, 'Fashion', 'มือสองสภาพดี', 'stussy-basic-stussy-t-shirt-black--ss22--1.jpg', '2024-10-17 04:21:36', 2),
(17, 'WashG1 เครื่องดูดถูพื้น (95 วัตต์, 1 ลิตร) รุ่น WR01 WASHG1 BK/BU', 26900.00, 'Home', 'รายละเอียดสินค้า\r\nระบบดูด: แห้ง/น้ำ\r\nกำลังไฟ(วัตต์): 95 วัตต์\r\nความจุฝุ่น(ลิตร): 1\r\nระยะเวลาที่ใช้ดูด(นาที): 35\r\nสายไฟยาว(เมตร): 1.6\r\nมอก.(Yes/No):Yes (2217-2548)', '000300968 WR01 WASHG1 BKBU.webp', '2024-10-17 04:22:26', 2),
(18, 'UMBRO Neo Swerve ลูกฟุตบอล', 340.00, 'Sports', 'ลูกฟุตบอล UMBRO Neo Swerve ผลิตจากวัสดุคุณภาพ มีความแข็งแรงทนทานสูง พร้อมเคลือบผิวสัมผัสด้วย TPU เพื่อให้ลูกบอลมีวิถีที่แม่นยำพร้อมทุกสนามแข่ง และพิมพ์ลายกราฟิกสวยงามและช่วยในการมองเห็นลูกบอลได้ง่ายบนสนาม เหมาะสำหรับใช้ฝึกซ้อมได้ทุกโอกาส\r\n\r\nผลิตจากวัสดุที่มีคุณภาพสูง\r\nพื้นผิวด้านนอกทำจากโพลียูรีเทนเพื่อให้ลูกบอลมีความทนทานสูง\r\nพิมพ์ลายกราฟิกสวยงามและช่วยในการมองเห็นลูกบอลได้ง่ายบนสนาม\r\nลูกบอลเบอร์ 5\r\nลูกฟุตบอล UMBRO\r\nสีขาว\r\n\r\n', 'MoveOnTop25TH.avif', '2024-10-17 04:23:59', 2),
(19, 'Umbro UMBRO Neo Swerve Match 21261U-LN5', 340.00, 'Sports', 'ลูกฟุตบอล UMBRO Neo Swerve Match ผลิตจากวัสดุที่มีความแข็งแรงทนทาน พร้อมเคลือบผิวสัมผัส\r\nผลิตจากยาง 48%, โพลีเอสเตอร์ 30%, EVA 15%, เทอร์โมพลาสติกยูรีเทน 7% หน้าสัมผัสแบบ 16 panels ให้วิถีการพุ่งขอ\r\nบอลที่แม่นยำและเป็นธรรมชาติ พื้นผิวด้านนอกทำจาก TPU ที่มีความทนทาน\r\nลายกราฟิกสวยงามและช่วยในการมองเห็นลูกบอลได้ง่ายบนสนาม ลูกบอลเบอร์ 5', '9093270.webp', '2024-10-17 04:24:51', 2);

-- --------------------------------------------------------

--
-- Table structure for table `shipping`
--

CREATE TABLE `shipping` (
  `shipping_id` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `item_id` int(10) UNSIGNED DEFAULT NULL,
  `method` enum('admin_mediated','meetup') NOT NULL,
  `status` enum('pending','completed') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swipes`
--

CREATE TABLE `swipes` (
  `swipe_id` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `item_id` int(10) UNSIGNED DEFAULT NULL,
  `swipe_action` enum('left','right') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `swipes`
--

INSERT INTO `swipes` (`swipe_id`, `user_id`, `item_id`, `swipe_action`, `created_at`) VALUES
(29, 2, 15, 'right', '2024-10-17 04:22:28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `role` enum('User','Admin') DEFAULT 'User',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `profile_picture`, `bio`, `role`, `created_at`) VALUES
(1, 'user1', '$2y$10$0j.b34U8NCcJGCKmgH2JF.WezFgl.2b4RZDon/VldjFB9eG.oLIg.', 'user1@user1.com', 'uploads/454145459_909274441049036_855567327165331642_n.jpg', '', 'User', '2024-10-15 07:55:11'),
(2, 'user11', '$2y$10$uUquU1ApG47LQK6queAD5OZiYEAFy4e77IE/FeFjyR6TsFAvLcOzK', 'user11@user11.com', NULL, NULL, 'User', '2024-10-15 08:34:56'),
(3, 'user111', '$2y$10$dL1qQBB3SAMnBx4Np9bN8uPA851w.4usHBtsh2yEegrdMP6uZJgaW', 'user111@user111.com', NULL, NULL, 'User', '2024-10-15 10:30:57'),
(4, 'admin', '$2y$10$aTISU8mhjIZ.NF4fDMuju.hvXOTyjvI5XzeigaUWf3/xU3bL.qf.S', 'admin@admin.com', NULL, NULL, 'Admin', '2024-10-17 04:28:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`shipping_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `swipes`
--
ALTER TABLE `swipes`
  ADD PRIMARY KEY (`swipe_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `shipping`
--
ALTER TABLE `shipping`
  MODIFY `shipping_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `swipes`
--
ALTER TABLE `swipes`
  MODIFY `swipe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shipping`
--
ALTER TABLE `shipping`
  ADD CONSTRAINT `shipping_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `shipping_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `swipes`
--
ALTER TABLE `swipes`
  ADD CONSTRAINT `swipes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `swipes_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
