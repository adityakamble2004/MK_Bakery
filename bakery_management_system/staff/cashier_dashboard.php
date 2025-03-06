<?php
session_start();
if (!isset($_SESSION['staff_role']) || $_SESSION['staff_role'] != 'cashier') {
    header("Location: ../staff_login.php");
    exit();
}
echo "Welcome, Cashier " . $_SESSION['staff_name'];
?>
<a href="logout.php">Logout</a>
