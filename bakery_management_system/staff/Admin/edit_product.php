<?php
include '../../includes/db_connection.php';

$product = null;

// Validate product_id
if (!isset($_GET['product_id']) || empty($_GET['product_id'])) {
    echo "<script>alert('Invalid product ID!'); window.location.href='manage_products.php';</script>";
    exit;
}

$product_id = intval($_GET['product_id']);

// Fetch product details
$query = "SELECT * FROM products WHERE product_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    echo "<script>alert('Product not found!'); window.location.href='manage_products.php';</script>";
    exit;
}

// Handle form submission
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
    $image_name = $product['image_url']; // Keep old image if not updated
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../../uploads/images/";
        $image_name = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;

        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "<script>alert('Image upload failed!'); window.history.back();</script>";
            exit;
        }
    }

    // Update product in database
    $update_query = "UPDATE products SET name=?, category=?, price=?, stock_quantity=?, description=?, image_url=? WHERE product_id=?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssdissi", $name, $category, $price, $stock_quantity, $description, $image_name, $product_id);

    if ($stmt->execute()) {
        echo "<script>alert('Product updated successfully!'); window.location.href='manage_products.php';</script>";
    } else {
        echo "<script>alert('Error updating product: " . $conn->error . "'); window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - MK Bakery</title>
    <link rel="stylesheet" href="assets/admin_style.css">
    <style>
        /* General styles */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

/* Header */
header {
    background: #333;
    color: white;
    padding: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo {
    font-size: 20px;
    font-weight: bold;
}

.admin-info a {
    color: white;
    text-decoration: none;
}

/* Container */
.container {
    display: flex;
}

/* Sidebar */
aside {
    width: 250px;
    background: #222;
    color: white;
    padding: 20px;
    height: 100vh;
}

aside nav ul {
    list-style: none;
    padding: 0;
}

aside nav ul li {
    padding: 10px 0;
}

aside nav ul li a {
    color: white;
    text-decoration: none;
    display: block;
}

/* Main Content */
main {
    flex: 1;
    padding: 20px;
}

h1 {
    text-align: center;
    color: #333;
}

/* Edit Product Form */
.edit-product-form {
    max-width: 500px;
    margin: 20px auto;
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.edit-product-form label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
    color: #333;
}

.edit-product-form input,
.edit-product-form textarea,
.edit-product-form select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
}

.edit-product-form button {
    width: 100%;
    padding: 10px;
    border: none;
    background: #28a745;
    color: white;
    cursor: pointer;
    font-size: 16px;
    border-radius: 5px;
}

.edit-product-form button:hover {
    background: #218838;
}

/* Image preview */
.image-preview {
    display: block;
    margin: 10px 0;
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 5px;
}

/* Back link */
.back-link {
    display: inline-block;
    margin-top: 10px;
    text-decoration: none;
    color: #007bff;
    font-size: 16px;
}

.back-link:hover {
    text-decoration: underline;
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
            <h1>Edit Product</h1>
            <?php if ($product): ?>
            <form action="" method="POST" enctype="multipart/form-data" class="edit-product-form">
                <label for="name">Product Name:</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>

                <label for="category">Category:</label>
                <input type="text" name="category" value="<?php echo htmlspecialchars($product['category']); ?>" required>

                <label for="price">Price:</label>
                <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>

                <label for="stock_quantity">Stock Quantity:</label>
                <input type="number" name="stock_quantity" value="<?php echo htmlspecialchars($product['stock_quantity']); ?>" required>

                <label for="description">Description:</label>
                <textarea name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>

                <label for="image">Product Image:</label>
                <input type="file" name="image">
                <p>Current Image:</p>
                <?php if (!empty($product['image_url'])): ?>
                    <img src="../../uploads/images<?php echo htmlspecialchars($product['image_url']); ?>" width="100" alt="Product Image">
                <?php else: ?>
                    <p>No image available</p>
                <?php endif; ?>

                <button type="submit">Update Product</button>
            </form>
            <?php else: ?>
                <p>Product not found!</p>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>
