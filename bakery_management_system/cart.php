<?php
session_start();
include 'includes/db_connection.php';

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add product to cart
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Check if product already exists in cart
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }
}

// Fetch product details
$cart_items = [];
foreach ($_SESSION['cart'] as $product_id => $quantity) {
    $sql = "SELECT * FROM products WHERE product_id = $product_id";
    $result = $conn->query($sql);
    if ($row = $result->fetch_assoc()) {
        $row['quantity'] = $quantity;
        $cart_items[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - MK Bakery</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<header>
    <h1>MK Bakery</h1>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="cart.php">Cart</a></li>
            <li><a href="orders.php">My Orders</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>
</header>

<section class="cart">
    <h2>Your Cart</h2>
    <?php if (empty($cart_items)): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <table border="1">
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
            <?php $total_price = 0; ?>
            <?php foreach ($cart_items as $item): ?>
                <tr>
                    <td><?php echo $item['name']; ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>₹<?php echo $item['price']; ?></td>
                    <td>₹<?php echo $item['price'] * $item['quantity']; ?></td>
                </tr>
                <?php $total_price += $item['price'] * $item['quantity']; ?>
            <?php endforeach; ?>
        </table>
        <h3>Total: ₹<?php echo $total_price; ?></h3>
        <form action="place_order.php" method="POST">
            <button type="submit">Place Order</button>
        </form>
    <?php endif; ?>
</section>

</body>
</html>
