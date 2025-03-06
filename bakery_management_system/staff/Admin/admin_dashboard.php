<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - MK Bakery</title>
    <link rel="stylesheet" href="assets/admin_style.css">
    <style>
        aside nav ul li a:hover,
aside nav ul li a.active {
    background-color: #ffcc00;
    color: black;
}
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
                    <li><a href="#">Dashboard</a></li>
                    <li><a href="manage_products.php">Manage Products</a></li>
                    <li><a href="manage_orders.php">Orders</a></li>
                    <li><a href="manage_users.php">Users</a></li>
                    <li><a href="settings.php">Settings</a></li>
                </ul>
            </nav>
        </aside>

        <main>
            <h1>Admin Dashboard</h1>
            <div class="dashboard-cards">
                <div class="card">
                    <h3>Total Orders</h3>
                    <p>120</p>
                </div>
                <div class="card">
                    <h3>Total Sales</h3>
                    <p>₹50,000</p>
                </div>
                <div class="card">
                    <h3>Products Listed</h3>
                    <p>45</p>
                </div>
            </div>
        </main>
    </div>
</body>
</html>