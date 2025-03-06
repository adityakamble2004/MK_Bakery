<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - MK Bakery</title>
    <link rel="stylesheet" href="assets/admin_style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
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
        .container {
            display: flex;
        }
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
        main {
            flex: 1;
            padding: 20px;
        }
        .dashboard-cards {
            display: flex;
            gap: 20px;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 200px;
            text-align: center;
        }
        .card h3 {
            margin-bottom: 10px;
        }
        .manage-products {
            margin-top: 20px;
        }
        .manage-products button {
            padding: 10px;
            margin: 5px;
            border: none;
            background: #28a745;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }
        .manage-products button:hover {
            background: #218838;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background: #333;
            color: white;
        }
        .edit-btn {
            background: #ffc107;
            color: black;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
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
                    <li><a href="admin_dashboard.php">Dashboard</a></li>
                    <li><a href="manage_products.php">Manage Products</a></li>
                    <li><a href="manage_orders.php">Orders</a></li>
                    <li><a href="manage_users.php">Users</a></li>
                    <li><a href="settings.php">Settings</a></li>
                </ul>
            </nav>
        </aside>

        <main>
            <h1>Admin Dashboard</h1>
            
            <h2>Product List</h2>

            <?php
            include '../../includes/db_connection.php';
            
            // Error handling for database connection
            if ($conn->connect_error) {
                echo "<script>alert('Database connection failed: " . $conn->connect_error . "');</script>";
                exit();
            }
            
            // Fetch products safely
            $query = "SELECT * FROM products";
            $result = $conn->query($query);
            
            if (!$result) {
                echo "<script>alert('Error retrieving products: " . $conn->error . "');</script>";
                exit();
            }
            
            if ($result->num_rows > 0) {
                echo '<table>
                <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Actions</th>
                </tr>';
                
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                    <td>{$row['product_id']}</td>
                    <td><img src='../../uploads/images/{$row['image_url']}' class='product-image' alt='Product Image'></td>
                    <td>{$row['name']}</td>
                    <td>₹{$row['price']}</td>
                    <td>
                    <a href='edit_product.php?product_id={$row['product_id']}' class='edit-btn'>Edit</a>
                    </td>
                    </tr>";
                }
                
                echo '</table>';
            } else {
                echo "<p>No products found.</p>";
            }
            
            // Close the database connection
            $conn->close();
            ?>

<div class="manage-products">
    <h2>Manage Products</h2>
    <button onclick="location.href='add_product.php'">Add New Product</button>
</div>
</main>
</div>
</body>
</html>
