<?php
session_start();
include '../../includes/db_connection.php';

// Check if admin is logged in
if (!isset($_SESSION['staff_id'])) {
    header("Location: login.php");
    exit;
}

$admin_id = $_SESSION['staff_id'];
$message = "";

// Fetch current settings
$query = "SELECT * FROM staff WHERE id = ?";
if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();
    $stmt->close();
} else {
    die("Error preparing statement: " . $conn->error);
}

// Update Profile Info
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);

    if (!empty($name) && !empty($email)) {
        $query = "UPDATE staff SET name = ?, email = ? WHERE id = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("ssi", $name, $email, $admin_id);
            if ($stmt->execute()) {
                $message = "Profile updated successfully!";
            } else {
                $message = "Error updating profile: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $message = "Database error: " . $conn->error;
        }
    } else {
        $message = "All fields are required!";
    }
}

// Update Password
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_password'])) {
    $old_password = trim($_POST['old_password']);
    $new_password = trim($_POST['new_password']);

    if (!empty($old_password) && !empty($new_password)) {
        // Verify old password
        if (password_verify($old_password, $admin['password'])) {
            // Hash new password
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

            $query = "UPDATE staff SET password = ? WHERE id = ?";
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("si", $hashed_password, $admin_id);
                if ($stmt->execute()) {
                    $message = "Password updated successfully!";
                } else {
                    $message = "Error updating password: " . $stmt->error;
                }
                $stmt->close();
            } else {
                $message = "Database error: " . $conn->error;
            }
        } else {
            $message = "Old password is incorrect!";
        }
    } else {
        $message = "All fields are required!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Settings - MK Bakery</title>
    <link rel="stylesheet" href="assets/admin_style.css">
    <style>
        /* General Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5;
    margin: 0;
    padding: 0;
}

/* Header */
header {
    background-color: #333;
    color: white;
    padding: 15px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo {
    font-size: 20px;
    font-weight: bold;
}

.admin-info a {
    color: #ffcc00;
    text-decoration: none;
    margin-left: 10px;
}

/* Sidebar */
.container {
    display: flex;
}

aside {
    width: 250px;
    background-color: #222;
    color: white;
    min-height: 100vh;
    padding: 20px;
}

aside nav ul {
    list-style: none;
    padding: 0;
}

aside nav ul li {
    margin-bottom: 15px;
}

aside nav ul li a {
    color: white;
    text-decoration: none;
    font-size: 18px;
    display: block;
    padding: 10px;
    border-radius: 5px;
}

aside nav ul li a:hover,
aside nav ul li a.active {
    background-color: #ffcc00;
    color: black;
}

/* Main Content */
main {
    flex: 1;
    padding: 30px;
}

h1 {
    color: #333;
}

/* Settings Sections */
.settings-section {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    max-width: 500px;
}

.settings-section h2 {
    margin-bottom: 15px;
}

.settings-section label {
    display: block;
    font-weight: bold;
    margin-top: 10px;
}

.settings-section input {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.settings-section button {
    background-color: #ffcc00;
    color: black;
    border: none;
    padding: 10px 15px;
    margin-top: 15px;
    cursor: pointer;
    font-size: 16px;
    border-radius: 5px;
}

.settings-section button:hover {
    background-color: #ff9900;
}

/* Message Box */
.message {
    background: #d4edda;
    color: #155724;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 15px;
}

    </style>

</head>
<body>
    <header>
        <div class="logo">MK Bakery Admin</div>
        <div class="admin-info">Welcome, <?php echo htmlspecialchars($admin['name']); ?> | <a href="logout.php">Logout</a></div>
    </header>

    <div class="container">
        <aside>
            <nav>
                <ul>
                    <li><a href="admin_dashboard.php">Dashboard</a></li>
                    <li><a href="manage_products.php">Manage Products</a></li>
                    <li><a href="manage_orders.php">Orders</a></li>
                    <li><a href="manage_users.php">Users</a></li>
                    <li><a href="settings.php" class="active">Settings</a></li>
                </ul>
            </nav>
        </aside>

        <main>
            <h1>Admin Settings</h1>
            <?php if ($message): ?>
                <p class="message"><?php echo htmlspecialchars($message); ?></p>
            <?php endif; ?>

            <section class="settings-section">
                <h2>Update Profile</h2>
                <form action="" method="POST">
                    <label for="name">Name:</label>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($admin['name']); ?>" required>

                    <label for="email">Email:</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>" required>

                    <button type="submit" name="update_profile">Save Changes</button>
                </form>
            </section>

            <section class="settings-section">
                <h2>Change Password</h2>
                <form action="" method="POST">
                    <label for="old_password">Old Password:</label>
                    <input type="password" name="old_password" required>

                    <label for="new_password">New Password:</label>
                    <input type="password" name="new_password" required>

                    <button type="submit" name="update_password">Update Password</button>
                </form>
            </section>
        </main>
    </div>
</body>
</html>
