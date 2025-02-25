<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Information</title>
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
        .content { flex: 1; padding: 20px; margin-left: 15%;}
        
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
        .seller-info {
            margin-bottom: 20px;
        }
        .seller-info p {
            margin: 5px 0;
        }
        .buttons {
            margin-top: 10px;
        }
        .buttons button {
            margin-right: 20px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>
<!-- <?php session_start() ?> -->
<body>
    <header>
        <nav>
            <h1>Employee Profile</h1>
            <ul class="nav-links">
                <?php
                    include "conn.php";

                    // session_start();
                    if (isset($_GET['id'])) {
                        $id = $_GET['id'];
                        //echo "User ID: " . $user_id;  // Display the user ID for validation
                    } else {
                        // echo "No user ID provided.";
                       $id = null; // If no user_id is passed, set it to null.
                    }
                ?>
               <li><a href="B_Personal Information.php?id=<?php echo $id; ?>">Me</a></li>
                <li><a href="seller_login.php <?php session_destroy()?>">Log Out</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section>
            <div class="container">
                <div class="sidebar">
                    <h2 style="position: fixed; margin-top: 0;">Page Selection</h2>
                    <div class="sidebar-content" style="margin-top: 15%; height: 95%;">
                        <?php
                            include "conn.php";
                            $type = "";
                            if (isset($_SESSION['type'])) $type = $_SESSION['type'];
                            else if (isset($_GET['type']))  $type = $_GET['type'];
                            else $type = "employee";
                        ?>
                        <?php if ($type === "employee") { ?>
                            <button><a href="viewStore_employee.php?id=<?php echo $id; ?>&type=<?php echo $type?>">View Store Inventory</a></button>
                            <button><a href="soldProduct.php?id=<?php echo $id; ?>&type=<?php echo $type?>">View Pickup Order</a></button>
                        <?php } ?>

                        <?php if ($type === "manager") { ?>
                            <button><a href="customerInformation.php?id=<?php echo $id; ?>&type=<?php echo $type?>">Customer Information</a></button>
                            <button><a href="salesHistory.php?id=<?php echo $id; ?>&type=<?php echo $type?>">View Sales History</a></button>
                            <button><a href="viewStore_manager.php?id=<?php echo $id; ?>&type=<?php echo $type?>">View All Store Inventory</a></button>
                            <button><a href="soldProduct.php?id=<?php echo $id; ?>&type=<?php echo $type?>">View Pickup Order</a></button>
                            <button><a href="productInformation.php?id=<?php echo $id; ?>&type=<?php echo $type?>">Product Information</a></button>
                            <button><a href="employeeInformation.php?id=<?php echo $id; ?>&type=<?php echo $type?>">View Employee Information</a></button> 
                            <button><a href="employeeInformation.php?id=<?php echo $id; ?>&type=<?php echo $type?>">View Employee Information</a></button>
                            <button><a href="managerSalesOrderLog.php?id=<?php echo $id?>&type=<?php echo $type?>">Product Consumption Record</a></button> 
                        <?php } ?>

                        <?php if ($type === "senior_manager") { ?>
                            <button><a href="customerInformation.php?id=<?php echo $id;?>&type=<?php echo $type?>">Customer Information</a></button>
                            <button><a href="salesHistory.php?id=<?php echo $id;?>&type=<?php echo $type?>">View Sales History</a></button>
                            <button><a href="add_manager.php?id=<?php echo $id; ?>&type=<?php echo $type?>">Add New Employee</a></button>
                            <button><a href="viewStore_manager.php?id=<?php echo $id; ?>&type=<?php echo $type?>">View All Store Inventory</a></button>
                            <button><a href="soldProduct.php?id=<?php echo $id; ?>&type=<?php echo $type?>">View Pickup Order</a></button>
                            <button><a href="productInformation.php?id=<?php echo $id; ?>&type=<?php echo $type?>">Product Information</a></button>
                            <button><a href="employeeInformation.php?id=<?php echo $id; ?>&type=<?php echo $type?>">View Employee Information</a></button> 
                            <button><a href="employeeInformation.php?id=<?php echo $id; ?>&type=<?php echo $type?>">View Employee Information</a></button>
                            <button><a href="managerSalesOrderLog.php?id=<?php echo $id?>&type=<?php echo $type?>">Product Consumption Record</a></button> 
                        <?php } ?>

                        <!-- <button><a href="customerInformation.php?id=<?php echo $id; ?>">Customer Information</a></button>
                        <button><a href="salesHistory.php?id=<?php echo $id; ?>">View Sales History</a></button>
                        <button><a href="add_manager.php?id=<?php echo $id; ?>">Add New Employee</a></button>
                        <button><a href="viewStore_employee.php?id=<?php echo $id; ?>">View Store Inventory</a></button>
                        <button><a href="viewStore_manager.php?id=<?php echo $id; ?>">View All Store Inventory</a></button>
                        <button><a href="viewInventory.php?id=<?php echo $id; ?>">View Total Inventory</a></button>
                        <button><a href="soldProduct.php?id=<?php echo $id; ?>">View Pickup Order</a></button>
                        <button><a href="productInformation.php?id=<?php echo $id; ?>">Product Information</a></button> 
                        <button><a href="employeeInformation.php?id=<?php echo $id; ?>">View Employee Information</a></button> 111
                        <button><a href="managerSalesOrderLog.html">Product Consumption Record</a></button>  -->
                    </div>
                </div>
                <div class="content">
                    <div class="container">
                        <div class="seller-info">
                            <h2>Employee Personal Information</h2>
                            <?php
                                $start_time = microtime(true);
                                
                                $sql = "SELECT p.id, p.first_name, p.last_name, p.email, p.phone_number, p.age, e.sid, s.s_name 
                                        FROM person p 
                                        JOIN employee e ON p.id = e.id 
                                        JOIN store s ON e.sid = s.sid 
                                        WHERE e.id = ?";

                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("i", $employee_id);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                $end_time = microtime(true);
                                $execution_time = $end_time - $start_time;
                                echo "<p>Execution time is:  $execution_time</p>";

                                if ($result && mysqli_num_rows($result) > 0) {
                                    $row = mysqli_fetch_assoc($result);
                                    echo "<p>Employee id: " . $row['id'] . "</p>";
                                    echo "<p>Employee Name: " . $row['first_name'] . ' ' . $row['last_name'] . "</p>";
                                    echo "<p>Email: " . $row['email'] . "</p>";
                                    echo "<p>Phone Number: " . $row['phone_number'] . "</p>";
                                    echo "<p>Age: " . $row['age'] . "</p>";
                                    echo "<p>Position: Employee </p>";
                                    echo "<p>Belong Store ID: " . $row['sid'] . "</p>";
                                    echo "<p>Belong Store Name: " . $row['s_name'] . "</p>";
                                } else {
                                    echo "<p>No results found.</p>";
                                }
                
                                // 关闭连接
                                $stmt->close();
                                $conn->close();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; Group 05 DBMS Project. All rights reserved.</p>
    </footer>
    <script>
    </script>
</body>
</html>