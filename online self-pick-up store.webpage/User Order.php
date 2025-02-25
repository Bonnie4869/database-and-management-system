<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Paid Order</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .order-item {
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
        }
        .order-item:last-child {
            border-bottom: none;
        }
        .order-details {
            display: flex;
            justify-content: space-between;
        }
        .order-details div {
            width: 48%;
        }
        .order-details p {
            margin: 5px 0;
        }
        .product-info {
            font-size: 14px;
            color: #555;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <h1>My Order</h1>
            <ul class="nav-links">
            <?php
                    include "conn.php";

                    $customer_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 1; 
                    
                    if ($customer_id == 0) {
                        header("Location: customer_login.php");
                        exit();
                    }
                ?>
                <li><a href="shoppingCart.php?user_id=<?php echo $customer_id; ?>">Shopping Cart</a></li>
                <li><a href="C_Personal Information.php?user_id=<?php echo $customer_id; ?>">Me</a></li>
                <li><a href="Homepage.php?user_id=<?php echo $customer_id; ?>">Back to Select Store</a></li>
                <li><a href="customer_login.php">Log Out</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="container">
            <h2>Your Paid Orders</h2>
            <?php

$start_time = microtime(true);
$sql = "SELECT o.oid, GROUP_CONCAT(DISTINCT CONCAT('Product: ', p.p_name, ', Quantity: ', bf.b_quantity, ', Price: $', p.price) SEPARATOR ' || ') AS order_details, o.pickup_id, o.order_time
FROM orders o
JOIN buy_from bf ON o.oid = bf.oid
JOIN product p ON bf.pid = p.pid
GROUP BY o.oid";

$result = mysqli_query($conn, $sql);

$end_time = microtime(true);
$execution_time = $end_time - $start_time;
echo "<p>Execution time is:  $execution_time</p>";

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='order-item'>
                <div class='order-details'>
                    <div>
                        <h3>Order #" . htmlspecialchars($row['oid']) . "</h3>
                        <p class='product-info'>" . nl2br(htmlspecialchars($row['order_details'])) . "</p>
                    </div>
                    <div>
                        <p>Pick-up Order #" . htmlspecialchars($row['pickup_id']) . "</p>
                        <p>Order Date: " . htmlspecialchars($row['order_time']) . "</p>
                    </div>
                </div>
            </div>";
    }
} else {
    echo "<p>No paid orders found.</p>";
}
$conn->close();
?>
        </div>
    </main>
    <footer>
        <p>&copy; Group 05 DBMS Project. All rights reserved.</p>
    </footer>
    <script>
    </script>
</body>
</html>