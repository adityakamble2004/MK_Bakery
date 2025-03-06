<?php
session_start();
include 'includes/db_connection.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM staff WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['staff_id'] = $row['id'];
            $_SESSION['staff_name'] = $row['name'];
            $_SESSION['staff_role'] = $row['role'];

            if ($row['role'] == 'admin') {
                header("Location: staff/Admin/admin_dashboard.php");
            } elseif ($row['role'] == 'manager') {
                header("Location: staff/manager_dashboard.php");
            } elseif ($row['role'] == 'cashier') {
                header("Location: staff/cashier_dashboard.php");
            }
            exit();
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "User not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Staff Login - MK Bakery</title>

    <style>
        /* General Page Styling */
body {
    font-family: Arial, sans-serif;
    background-color: #f8f8f8;
    text-align: center;
    margin: 0;
    padding: 0;
}

/* Login Form Container */
form {
    background: #fff;
    max-width: 350px;
    margin: 80px auto;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

/* Form Headings */
h2 {
    color: #333;
    margin-bottom: 20px;
}

/* Input Fields */
input[type="text"],
input[type="password"] {
    width: 90%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

/* Login Button */
button {
    background-color: #ff6600;
    color: white;
    border: none;
    padding: 10px 15px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    width: 100%;
    margin-top: 10px;
}

button:hover {
    background-color: #e65c00;
}

/* Error Message */
.error {
    color: red;
    font-size: 14px;
    margin-top: 10px;
}

    </style>
</head>
<body>
    <h2>Staff Login</h2>
    <form method="POST">
        <label>Username:</label>
        <input type="text" name="username" required><br>
        <label>Password:</label>
        <input type="password" name="password" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
