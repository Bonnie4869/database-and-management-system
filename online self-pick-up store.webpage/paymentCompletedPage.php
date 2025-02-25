<?php
session_start();  

include "conn.php";

if (isset($_GET['user_id']) && isset($_GET['oid'])) {
    $user_id = $_GET['user_id'];
    $order_id = $_GET['oid'];

    if (!filter_var($order_id, FILTER_VALIDATE_INT)) {
        die("Invalid order ID.");
    }

    $query = "SELECT * FROM buy_from JOIN orders USING(oid) JOIN product USING(pid) JOIN store USING(sid) WHERE oid = ?";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $order_id);

        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['order_info'] = [];
            while ($row = $result->fetch_assoc()) {
                $_SESSION['order_info'][] = $row;  
            }
        } else {
            echo "No orders found with the specified order ID.";
            exit();
        }

        $stmt->close();
    } else {
        echo "Error preparing the query: " . $conn->error;
        exit();
    }
} else {
    echo "Invalid request! Missing user_id or order_id.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Completed</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .payment-completed-container {
            max-width: 800px;
            margin: auto;
            text-align: center;
        }
        .payment-completed-container a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            text-decoration: none;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 8px 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <h1>Payment Completed</h1>
            <ul class="nav-links">
            <li><a href="shoppingCart.php?user_id=<?php echo $user_id; ?>">Shopping Cart</a></li>
            <li><a href="C_Personal Information.php?user_id=<?php echo $user_id; ?>">Me</a></li>
            <li><a href="Homepage.php?user_id=<?php echo $user_id; ?>">Back to Select Store</a></li>
            <li><a href="customer_login.php">Log Out</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="payment-completed-container">
            <h1>Payment Successful</h1>
            <h2>Your Order Details</h2>

            <?php
            if (isset($_SESSION['order_info']) && !empty($_SESSION['order_info'])) {
                $order_info = $_SESSION['order_info'][0];  
                ?>

                <p><strong>Order ID:</strong> <?php echo htmlspecialchars($order_info['oid']); ?></p>
                <p><strong>Pickup ID:</strong> <?php echo htmlspecialchars($order_info['pickup_id']); ?></p>
                <p><strong>Order Time:</strong> <?php echo htmlspecialchars($order_info['order_time']); ?></p>

                <table>
                    <thead>
                        <tr>
                            <th>Store ID (sid)</th>
                            <th>Store Name (s_name)</th>
                            <th>Product Name (p_name)</th>
                            <th>Quantity (b_quantity)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($_SESSION['order_info'] as $item) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($item['sid']) . "</td>";
                            echo "<td>" . htmlspecialchars($item['s_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($item['p_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($item['b_quantity']) . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>

            <?php
            } else {
                echo "<p>No order details found.</p>";
            }
            ?>

<a href="Homepage.php?user_id=<?php echo $user_id; ?>">Back to Select Store</a>
        </div> 
    </main> 
    <footer> 
        <p>&copy; Group 05 DBMS Project. All rights reserved.</p> 
    </footer> 
</body> 
</html>