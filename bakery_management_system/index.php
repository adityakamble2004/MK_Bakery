<?php
include 'includes/db_connection.php';
session_start();

// Fetch products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MK Bakery</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<!-- Header Section -->
<header>
    <h1>Mahek's Bakery</h1>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="#" onclick="toggleCart()">Cart (<span id="cart-count">0</span>)</a></li>
            <li><a href="orders.php">My Orders</a></li>
            <li><a href="staff_login.php">Login</a></li>
        </ul>
    </nav>
</header>

<!-- Product Display Section -->
<section class="product-list">
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="product">
            <img src="uploads/images/<?php echo $row['image_url']; ?>" alt="<?php echo $row['name']; ?>">
            <h2><?php echo $row['name']; ?></h2>
            <p><?php echo $row['description']; ?></p>
            <p><strong>Price: ₹<?php echo $row['price']; ?></strong></p>
            <button onclick="addToCart(<?php echo $row['product_id']; ?>, '<?php echo $row['name']; ?>', <?php echo $row['price']; ?>)">Add to Cart</button>
        </div>
    <?php endwhile; ?>
</section>

<!-- Floating Cart -->
<div id="cart-box" class="hidden">
    <h3>Shopping Cart</h3>
    <ul id="cart-items"></ul>
    <p id="cart-total">Total: ₹0.00</p>
    <button onclick="toggleCart()">Close</button>
    <a href="cart.php"><button>Place order</button></a>
</div>

<script src="assets/script.js"></script>
</body>
</html>
