<?php
// Check if the user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SwipeShop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="bg-blue-600">
        <div class="container mx-auto p-4">
            <header class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-white">SwipeShop</h1>
                <nav>
                    <ul class="flex space-x-8">
                        <li>
                            <a href="index.php" class="text-lg font-medium text-white hover:text-blue-200 transition duration-200 ease-in-out">Home</a>
                        </li>
                        <li>
                            <a href="index.html" class="text-lg font-medium text-white hover:text-blue-200 transition duration-200 ease-in-out">Chat</a>
                        </li>
                        <li>
                            <a href="seller.php" class="text-lg font-medium text-white hover:text-blue-200 transition duration-200 ease-in-out">Sell</a>
                        </li>
                        <li>
                            <a href="account.php" class="text-lg font-medium text-white hover:text-blue-200 transition duration-200 ease-in-out">Account</a>
                        </li>
                    </ul>
                </nav>
                <div>
                    <?php if ($isLoggedIn): ?>
                        <div class="flex items-center">
                            <span class="mr-2"></span>
                            <a href="logout.php" class="bg-red-500 text-white px-4 py-2 rounded shadow-lg hover:bg-red-600 transition duration-200 ease-in-out">Logout</a>
                        </div>
                    <?php else: ?>
                        <div>
                            <a href="login.php" class="bg-blue-500 text-white px-4 py-2 rounded shadow-lg hover:bg-blue-600 transition duration-200 ease-in-out">Login</a>
                            <a href="register.php" class="bg-green-500 text-white px-4 py-2 rounded shadow-lg hover:bg-green-600 transition duration-200 ease-in-out ml-2">Register</a>
                        </div>
                    <?php endif; ?>
                </div>
            </header>
        </div>
    </div>
    <!-- Add your main content here -->
</body>
</html>
