<?php
include '../../includes/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $stock_quantity = intval($_POST['stock_quantity'] ?? 0);
    $description = trim($_POST['description'] ?? '');

    // Validate inputs
    if (empty($name) || empty($category) || $price <= 0 || $stock_quantity < 0) {
        echo "<script>alert('Invalid input values!'); window.history.back();</script>";
        exit;
    }

    // Handle image upload
    $image_name = "";
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../../uploads/images/";
        $image_name = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;

        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "<script>alert('Image upload failed!'); window.history.back();</script>";
            exit;
        }
    }

    // Insert product into database
    $query = "INSERT INTO products (name, category, price, stock_quantity, description, image_url) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssdiss", $name, $category, $price, $stock_quantity, $description, $image_name);

    if ($stmt->execute()) {
        echo "<script>alert('Product added successfully!'); window.location.href='manage_products.php';</script>";
    } else {
        echo "<script>alert('Error adding product: " . $conn->error . "'); window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - MK Bakery</title>
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

aside nav ul li a:hover {
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

/* Form Styling */
.add-product-form {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    max-width: 600px;
}

.add-product-form label {
    display: block;
    font-weight: bold;
    margin-top: 10px;
}

.add-product-form input,
.add-product-form textarea {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.add-product-form button {
    background-color: #ffcc00;
    color: black;
    border: none;
    padding: 10px 15px;
    margin-top: 15px;
    cursor: pointer;
    font-size: 16px;
    border-radius: 5px;
}

.add-product-form button:hover {
    background-color: #ff9900;
}

    </style>
</head>
<body>
    <header>
        <div class="logo">MK Bakery Admin</div>
        <div class="admin-info">Welcome, Admin | <a href="logout.php">Logout</a></div>
    </header>

    <div class="container">
        <aside>
            <nav>
                <ul>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="manage_products.php">Manage Products</a></li>
                    <li><a href="manage_orders.php">Orders</a></li>
                    <li><a href="manage_users.php">Users</a></li>
                    <li><a href="settings.php">Settings</a></li>
                </ul>
            </nav>
        </aside>

        <main>
            <h1>Add New Product</h1>
            <form action="" method="POST" enctype="multipart/form-data" class="add-product-form">
                <label for="name">Product Name:</label>
                <input type="text" name="name" required>

                <label for="category">Category:</label>
                <input type="text" name="category" required>

                <label for="price">Price:</label>
                <input type="number" step="0.01" name="price" required>

                <label for="stock_quantity">Stock Quantity:</label>
                <input type="number" name="stock_quantity" required>

                <label for="description">Description:</label>
                <textarea name="description" required></textarea>

                <label for="image">Product Image:</label>
                <input type="file" name="image">

                <button type="submit">Add Product</button>
            </form>
        </main>
    </div>
</body>
</html>
