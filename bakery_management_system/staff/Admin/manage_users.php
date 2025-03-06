<?php
session_start();
include '../../includes/db_connection.php';

// Check if admin is logged in
if (!isset($_SESSION['staff_id'])) {
    header("Location: login.php");
    exit;
}

$message = "";

// Fetch Users
$query = "SELECT * FROM staff";
$result = $conn->query($query);

// Add User
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_user'])) {
    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    if (!empty($name) && !empty($username) && !empty($password) && !empty($role)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $insert_query = "INSERT INTO staff (name, username, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("ssss", $name, $username, $hashed_password, $role);
        if ($stmt->execute()) {
            $message = "User added successfully!";
        } else {
            $message = "Error adding user!";
        }
    } else {
        $message = "All fields are required!";
    }
}

// Delete User
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete_query = "DELETE FROM staff WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $message = "User deleted successfully!";
    } else {
        $message = "Error deleting user!";
    }
}

// Fetch updated users list
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - MK Bakery</title>
    <link rel="stylesheet" href="assets/admin_style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
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
        main {
            flex: 1;
            padding: 30px;
        }
        h1 {
            color: #333;
        }
        .message {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #ffcc00;
        }
        button {
            background-color: #ffcc00;
            color: black;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background-color: #ff9900;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">MK Bakery Admin</div>
        <div class="admin-info">Welcome, <?php echo $_SESSION['staff_id']; ?> | <a href="logout.php">Logout</a></div>
    </header>

    <div class="container">
        <aside>
            <nav>
                <ul>
                    <li><a href="admin_dashboard.php">Dashboard</a></li>
                    <li><a href="manage_products.php">Manage Products</a></li>
                    <li><a href="manage_orders.php">Orders</a></li>
                    <li><a href="manage_users.php" class="active">Users</a></li>
                    <li><a href="settings.php">Settings</a></li>
                </ul>
            </nav>
        </aside>

        <main>
            <h1>Manage Users</h1>
            <?php if ($message): ?>
                <p class="message"><?php echo $message; ?></p>
            <?php endif; ?>

            <!-- Add User -->
            <section class="settings-section">
                <h2>Add New User</h2>
                <form action="" method="POST">
                    <label for="name">Name:</label>
                    <input type="text" name="name" required>

                    <label for="username">Username:</label>
                    <input type="text" name="username" required>

                    <label for="password">Password:</label>
                    <input type="password" name="password" required>

                    <label for="role">Role:</label>
                    <select name="role" required>
                        <option value="admin">Admin</option>
                        <option value="manager">Manager</option>
                        <option value="cashier">Cashier</option>
                    </select>

                    <button type="submit" name="add_user">Add User</button>
                </form>
            </section>

            <!-- User List -->
            <section class="settings-section">
                <h2>User List</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['username']; ?></td>
                                <td><?php echo ucfirst($row['role']); ?></td>
                                <td>
                                    <a href="edit_user.php?id=<?php echo $row['id']; ?>">
                                        <button>Edit</button>
                                    </a>
                                    <a href="manage_users.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');">
                                        <button style="background-color: red; color: white;">Delete</button>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>
