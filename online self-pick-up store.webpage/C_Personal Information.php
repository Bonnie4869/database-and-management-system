<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Information</title>
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
        .user-info {
            margin-bottom: 20px;
        }
        .user-info p {
            margin: 5px 0;
        }
        .buttons {
            margin-top: 20px;
        }
        .buttons button {
            margin-right: 10px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <h1>User Profile</h1>
            <ul class="nav-links">
                <?php
                    include "conn.php";

                    $customer_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 1; //test to default 1
                    
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
            <h2>User Personal Information</h2>
            <div class="user-info">
                <?php
                    $start_time = microtime(true);
                    
                    $sql = "SELECT c.user_name, p.email, p.phone_number, p.age
                            FROM person p 
                            JOIN customer c ON p.id = c.id 
                            WHERE p.id = ?";

                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $customer_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    $end_time = microtime(true);
                    $execution_time = $end_time - $start_time;
                    echo "<p>Execution time is:  $execution_time</p>";

                    if ($result && mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        echo "<p>Username: " . htmlspecialchars($row['user_name']) . "</p>";
                        echo "<p>Email: " . htmlspecialchars($row['email']) . "</p>";
                        echo "<p>Phone Number: " . htmlspecialchars($row['phone_number']) . "</p>";
                        echo "<p>Age: " . htmlspecialchars($row['age']) . "</p>";
                    } else {
                        echo "<p>No results found.</p>";
                    }
                    
                    $stmt->close();
                    $conn->close();
                ?>
            </div>
            
            <div class="buttons">
                <button onclick="window.location.href='customerUpdateInfomation.php'">Change Personal Information</button>
                <button onclick="window.location.href='User Order.php'">View Orders</button>
            </div>
        </div>
    </main>
    <footer>
        <p>&copy; Group 05 DBMS Project. All rights reserved.</p>
    </footer>
</body>
</html>