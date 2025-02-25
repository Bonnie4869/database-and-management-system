<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee View Pick Up Order Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .container { display: flex; height: 100%; }
        .sidebar { width: 15%; background-color: #f4f4f4; padding: 20px; height: 85%; box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1); position: fixed; }
        .sidebar h2 { font-size: 18px; margin-bottom: 20px; }
        .sidebar button {
            display: block;
            width: 100%;
            margin-bottom: 10px;
            padding: 10px;
            border: none;
            background-color: #007bdd;
            color: white;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
        }
        .sidebar-content {
            position: relative;
            flex-grow: 1;
            overflow-y: auto;
            padding: 10px;
            margin-top: 15%;
            height: 95%;
        }
        button:hover { background-color: #007fff;}
        .content { flex: 1; padding: 20px; margin-left: 15%; }
        .btn {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        .btn:disabled {
            background-color: #ccc;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #333;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <h1>Employee View Pick Up Order Dashboard</h1>
            <ul class="nav-links">
                <li><a href="B_Personal Information.php?id=<?php echo $id; ?>">Me</a></li>
                <li><a href="seller_login.php">Log Out</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section>
            <div class="container">
                <div class="sidebar">
                    <h2 style="position: fixed; margin-top: 0;">Page Selection</h2>
                    <div class="sidebar-content" style="margin-top: 15%; height: 95%;">
                    <button><a href="customerInformation.php?id=<?php echo $id; ?>">Customer Information</a></button>
                        <button><a href="salesHistory.php?id=<?php echo $id; ?>">View Sales History</a></button>
                        <button><a href="add_manager.php?id=<?php echo $id; ?>">Add New Employee</a></button>
                        <button><a href="viewStore_employee.php?id=<?php echo $id; ?>">View Store Inventory</a></button>
                        <button><a href="viewStore_manager.php?id=<?php echo $id; ?>">View All Store Inventory</a></button>
                        <button><a href="viewInventory.php?id=<?php echo $id; ?>">View Total Inventory</a></button>
                        <button><a href="soldProduct.php?id=<?php echo $id; ?>">View Pickup Order</a></button>
                        <button><a href="productInformation.php?id=<?php echo $id; ?>">Product Information</a></button> 
                        <button><a href="employeeInformation.php?id=<?php echo $id; ?>">View Employee Information</a></button> 
                        <button><a href="salesOrderLog.php?id=<?php echo $id; ?>">Store Product Consumption Record</a></button> 
                        <button><a href="managerSalesOrderLog.php?id=<?php echo $id; ?>">Product Consumption Record</a></button> 
                    </div>
                </div>
                <div class="content">
                    <h1>Order confirmed Page</h1>
                    <?php
                        include "conn.php";
                        $start_time = microtime(true);
                        $currentTime = date('Y-m-d H:i:s');
                        $oid = $_POST['order_id'];
                        $b_name = $_POST['name'];
                        $sql = "UPDATE orders SET pickup_time = '$currentTime' WHERE oid = $oid";
                        if(mysqli_query($conn, $sql)) echo "Thank you! You have successfully confirmed customer <b>" . $b_name ."'s</b> order <b>" . $oid ."</b> at time <b>" . $currentTime . "</b> .\n";
                        echo '<p><a href = "managerSalesOrderLog.php">Back to OrderLog Page(for manager)</a></p>';
                        $end_time = microtime(true);
                        $execution_time = $end_time - $start_time;
                    ?>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <p>Execution time is: <?php echo $execution_time; ?></p>
        <p>&copy; Group 05 DBMS Project. All rights reserved.</p>
    </footer>
</html>
