<?php
session_start();
include 'includes/db_connection.php';

// Check if cart is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Your cart is empty!";
    exit();
}

// Insert order into database
$total_price = 0;
foreach ($_SESSION['cart'] as $product_id => $quantity) {
    $sql = "SELECT price FROM products WHERE product_id = $product_id";
    $result = $conn->query($sql);
    if ($row = $result->fetch_assoc()) {
        $total_price += $row['price'] * $quantity;
    }
}

$customer_id = $_SESSION['user_id'] ?? 0;
$sql = "INSERT INTO orders (customer_id, total_price, order_status, payment_status) VALUES ('$customer_id', '$total_price', 'Pending', 'Unpaid')";
if ($conn->query($sql) === TRUE) {
    unset($_SESSION['cart']);
    echo "Order placed successfully! <a href='orders.php'>View Orders</a>";
} else {
    echo "Error placing order: " . $conn->error;
}
?>
