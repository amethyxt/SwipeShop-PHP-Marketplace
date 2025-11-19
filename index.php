<?php
include 'db.php';
session_start();
$isLoggedIn = isset($_SESSION['user_id']);

// ดึงข้อมูลสินค้าจากฐานข้อมูล พร้อมรายละเอียดผู้ขาย
$stmt = $conn->prepare("
    SELECT p.*, s.username, s.email, s.profile_picture, s.bio 
    FROM products p 
    JOIN users s ON p.user_id = s.user_id
");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// หมวดหมู่ที่มีอยู่
$categories = ['Electronics', 'Fashion', 'Home', 'Sports'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SwipeShop - Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        /* Custom CSS for Sidebar */
        #sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 300px;
            overflow-y: auto;
            transition: transform 0.3s ease;
            transform: translateX(-100%);
            z-index: 10;
        }

        #sidebar.open {
            transform: translateX(0);
        }

        /* Add margin to the sidebar content */
        .sidebar-content {
            margin-top: 60px;
        }

        /* Adjusting main content */
        main {
            margin-left: 0;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        main.sidebar-open {
            margin-left: 300px;
        }

        /* Product Card Styles */
        #productCard {
            max-width: 400px;
            margin: 0 auto;
        }

        /* Button styles */
        .category-btn {
            margin-top: 10px;
            background-color: #3182ce;
            color: white;
            transition: background-color 0.3s ease;
        }

        .active-category {
            background-color: #2b6cb0;
        }

        /* User Information Alignment */
        #sidebarUserImage {
            margin-right: 16px;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">

    <!-- Include Header -->
    <?php include './header.php'; ?>

    <div class="flex">

        <!-- Sidebar for displaying product details -->
        <div id="sidebar" class="bg-white rounded-xl shadow-md p-4">
            <div class="sidebar-content">
                <h2 id="sidebarTitle" class="text-xl font-semibold mb-2"></h2>
                <img id="sidebarImage" src="" alt="" class="w-full h-48 object-cover rounded-lg mb-4">
                <p id="sidebarPrice" class="text-gray-600 text-lg"></p>

                <!-- Product Description -->
                <div class="mt-4 p-4 bg-white border border-gray-300 rounded-lg shadow-md">
                    <div class="bg-gray-200 p-2 rounded-md text-gray-800 mb-2 text-center font-bold text-lg">
                        รายละเอียดของสินค้า</div>
                    <textarea id="sidebarDescription" class="w-full h-24 p-2 border rounded mb-4" readonly></textarea>
                </div>

                <!-- User Information -->
                <div class="mt-4 p-4 bg-white border border-gray-300 rounded-lg shadow-md">
                    <div class="bg-gray-200 p-2 rounded-md text-gray-800 mb-2 text-center font-bold text-lg">ผู้ขาย
                    </div>
                    <div class="flex items-center">
                        <img id="sidebarUserImage" src="" alt="User Profile"
                            class="w-16 h-16 object-cover rounded-full mr-4">
                        <div>
                            <h3 class="text-lg font-semibold" id="sidebarUserUsername"></h3>
                            <p class="text-gray-600" id="sidebarUserEmail"></p>
                            <p class="text-gray-600" id="sidebarUserBio"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <main class="ml-0 w-full p-4">
        <?php if ($isLoggedIn): ?>
            <button id="toggleSidebarBtn" class="absolute top-4 left-4 z-50 bg-blue-500 text-white p-2 rounded-full">
                <i data-lucide="menu"></i>
            </button>
            <div id="productCard" class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-4">
                    <img id="productImage" src="" alt="" class="w-full h-64 object-cover rounded-lg mb-4 cursor-pointer">
                    <h2 id="productTitle" class="text-xl font-semibold mb-2"></h2>
                    <p id="productPrice" class="text-gray-600 text-lg"></p>
                </div>
                <div class="flex justify-between p-4">
                    <button id="swipeLeftBtn" class="bg-red-500 text-white p-4 rounded-full">
                        <i data-lucide="chevron-left"></i>
                    </button>
                    <button id="swipeRightBtn" class="bg-green-500 text-white p-4 rounded-full">
                        <i data-lucide="chevron-right"></i>
                    </button>
                </div>
            </div>

            <div class="mt-6">
                <h3 class="text-xl font-semibold mb-2">Categories</h3>
                <div class="flex flex-wrap gap-2">
                    <button class="category-btn px-4 py-2 rounded-full" data-category="All">All</button>
                    <?php foreach ($categories as $category): ?>
                        <button class="category-btn px-4 py-2 rounded-full"
                            data-category="<?php echo $category; ?>"><?php echo $category; ?></button>
                    <?php endforeach; ?>
                </div>
            </div>

        <?php else: ?>
            <div class="text-center">
                <h2 class="text-2xl font-bold mb-4">Welcome to SwipeShop</h2>
                <p class="mb-4">Please log in to start shopping!</p>
                <a href="login.php" class="bg-blue-500 text-white px-4 py-2 rounded">Login</a>
            </div>
        <?php endif; ?>
    </main>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        <?php if ($isLoggedIn): ?>
            // Product swipe functionality
            let products = <?php echo json_encode($products); ?>;
            let currentProductIndex = 0;
            let isSidebarOpen = false; // Track sidebar state

            function numberWithCommas(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            function updateProductDisplay() {
                const product = products[currentProductIndex];
                document.getElementById('productImage').src = 'uploads/products/' + product.image_path;
                document.getElementById('productTitle').textContent = product.product_name;
                const formattedPrice = '฿' + numberWithCommas(product.price);
                document.getElementById('productPrice').textContent = formattedPrice;

                updateSidebarDisplay(product);
            }

            function updateSidebarDisplay(product) {
                document.getElementById('sidebarTitle').textContent = product.product_name;
                document.getElementById('sidebarImage').src = 'uploads/products/' + product.image_path;
                const formattedPrice = '฿' + numberWithCommas(product.price);
                document.getElementById('sidebarPrice').textContent = formattedPrice;
                document.getElementById('sidebarDescription').textContent = product.description;

                document.getElementById('sidebarUserImage').src = product.profile_picture;
                document.getElementById('sidebarUserUsername').textContent = product.username;
                document.getElementById('sidebarUserEmail').textContent = product.email;
                document.getElementById('sidebarUserBio').textContent = product.bio;
            }

            document.getElementById('swipeLeftBtn').addEventListener('click', function () {
                currentProductIndex = (currentProductIndex - 1 + products.length) % products.length;
                updateProductDisplay();
            });

            document.getElementById('swipeRightBtn').addEventListener('click', function () {
            const product = products[currentProductIndex];

    // ส่ง AJAX ไปยัง swipe.php เพื่อบันทึกการ swipe
    fetch('swipe.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `item_id=${product.id}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert("คุณได้สนใจสินค้าชิ้นนี้แล้ว"); // เพิ่มบรรทัดนี้เพื่อแสดงข้อความ
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });

    currentProductIndex = (currentProductIndex + 1) % products.length;
    updateProductDisplay();
});

            document.getElementById('productImage').addEventListener('click', function () {
                toggleSidebar();
            });

            document.getElementById('toggleSidebarBtn').addEventListener('click', function () {
                toggleSidebar();
            });

            function toggleSidebar() {
                const sidebar = document.getElementById('sidebar');
                const mainContent = document.querySelector('main');
                if (isSidebarOpen) {
                    sidebar.classList.remove('open');
                    mainContent.classList.remove('sidebar-open');
                } else {
                    sidebar.classList.add('open');
                    mainContent.classList.add('sidebar-open');
                }
                isSidebarOpen = !isSidebarOpen; // Toggle sidebar state
            }

            // Category filter
            document.querySelectorAll('.category-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const category = this.getAttribute('data-category');
                    document.querySelectorAll('.category-btn').forEach(btn => {
                        btn.classList.remove('active-category');
                    });
                    this.classList.add('active-category');

                    if (category === 'All') {
                        products = <?php echo json_encode($products); ?>;
                    } else {
                        products = <?php echo json_encode($products); ?>;
                        products = products.filter(product => product.category === category);
                    }
                    currentProductIndex = 0;
                    updateProductDisplay();
                });
            });

            // Initial display
            updateProductDisplay();

        <?php endif; ?>
    </script>

</body>
<!-- Modal for showing seller information -->
<div id="sellerModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-lg p-6 max-w-lg">
        <h2 class="text-2xl font-bold mb-4">ข้อมูลผู้ขาย</h2>
        <img id="sellerProfilePicture" src="" alt="Profile Picture" class="w-16 h-16 object-cover rounded-full mb-4">
        <p><strong>Username:</strong> <span id="sellerUsername"></span></p>
        <p><strong>Email:</strong> <span id="sellerEmail"></span></p>
        <p><strong>Bio:</strong> <span id="sellerBio"></span></p>
        <button class="mt-4 bg-blue-500 text-white px-4 py-2 rounded" onclick="closeSellerModal()">Close</button>
    </div>
</div>

<script>
    function closeSellerModal() {
        document.getElementById('sellerModal').style.display = 'none';
    }
</script>

</html>
