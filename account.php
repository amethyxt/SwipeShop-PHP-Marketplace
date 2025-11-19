<?php
session_start(); // Start session
include 'db.php'; // Connect to database

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header('Location: login.php');
    exit();
}

// Database connection details
$host = 'localhost';
$db = 'swipeshop';
$user = 'swipeshop';
$pass = 'swipeshop';

// Connect to database
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get data from form
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $bio = $_POST['bio'];

    // Initialize profile picture path
    $profile_picture = null;

    // Check if a file has been uploaded
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
        // Set upload directory
        $upload_dir = 'uploads/';
        $file_name = basename($_FILES['profile_picture']['name']);
        $upload_file = $upload_dir . $file_name;

        // Check if file uploaded successfully
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $upload_file)) {
            $profile_picture = $upload_file;
        } else {
            $message = "Error uploading the file.";
        }
    }

    // Update database using prepared statement
    $sql = "UPDATE users SET username=?, email=?, bio=?";
    if ($profile_picture) {
        $sql .= ", profile_picture=?";
    }
    $sql .= " WHERE user_id=?";
    
    $stmt = $conn->prepare($sql);
    
    if ($profile_picture) {
        $stmt->bind_param('ssssi', $username, $email, $bio, $profile_picture, $user_id);
    } else {
        $stmt->bind_param('sssi', $username, $email, $bio, $user_id);
    }
    
    if ($stmt->execute()) {
        $message = "Profile updated successfully";
    } else {
        $message = "Error updating profile: " . $conn->error;
    }
}

// Fetch user data
$sql = "SELECT user_id, username, email, profile_picture, bio FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

// Check if results exist
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "0 results";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .profile-button {
            background-color: #007bff;
            color: white;
            transition: background-color 0.3s;
        }
        .profile-button:hover {
            background-color: #0056b3;
        }
        .link-item {
            margin-bottom: 10px;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            color: #343a40;
            text-decoration: none;
            transition: color 0.3s;
        }
        .link-item i {
            margin-right: 10px;
        }
        .link-item:hover {
            color: #007bff;
        }
        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .profile-header img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
        .alert {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php include './header.php'; ?>
    <div class="container rounded bg-white mt-5 mb-5 shadow-sm">
        <div class="row">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5 profile-header">
                    <img src="<?php echo $row['profile_picture'] ? $row['profile_picture'] : 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg'; ?>" alt="Profile Picture">
                    <span class="font-weight-bold"><?php echo $row['username']; ?></span>
                    <span class="text-black-50"><?php echo $row['email']; ?></span>
                </div>
            </div>
            <div class="col-md-5 border-right">
                <div class="p-4">
                    <h4 class="text-center mb-4">Profile Settings</h4>
                    <?php if (isset($message)): ?>
                        <div class="alert alert-info" role="alert">
                            <?php echo $message; ?>
                        </div>
                    <?php endif; ?>
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $row['username']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo $row['email']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Bio</label>
                            <textarea name="bio" class="form-control" rows="3"><?php echo $row['bio']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Profile Picture</label>
                            <input type="file" name="profile_picture" class="form-control" accept="image/*">
                        </div>
                        <div class="text-center">
                            <button class="btn profile-button" type="submit">Save Profile</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4">
                    <h4 class="text-center mb-4">Menu</h4>
                    <div class="d-flex flex-column align-items-start">
                        <a href="account.php" class="link-item"><i class="fas fa-user"></i> Account</a>
                        <a href="order.php" class="link-item"><i class="fas fa-box"></i> Order</a>
                        <a href="notification.php" class="link-item"><i class="fas fa-bell"></i> Notification</a>
                        <a href="logout.php" class="link-item"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
