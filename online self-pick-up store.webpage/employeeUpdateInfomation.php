<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Employee Information</title>
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
            padding: 20px;
            background-color: #f4f4f4;
        }
        .conta{
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2 {
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .form-group input[type="radio"] {
            width: auto;
        }
        .form-group .radio-group {
            display: flex;
            flex-direction: column;
        }
        .form-group .radio-group label {
            margin-right: 10px;
        }
        .btn-submit {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            font-size: 16px;
        }
        .btn-submit:hover {
            background-color: #218838;
        }
        </style>
</head>
<body>
    <header>
        <nav>
            <h1>Update Employee Information</h1>
            <ul class="nav-links">
            <?php
                    include "conn.php";

                    session_start();
                    if (isset($_GET['id'])) {
                        $employee_id = $_GET['id'] ;
                        //echo "User ID: " . $user_id;  // Display the user ID for validation
                    } else {
                        // echo "No user ID provided.";
                       $employee_id = null; // If no user_id is passed, set it to null.
                    }
                ?>
               <li><a href="B_Personal Information.php?id=<?php echo $employee_id; ?>">Me</a></li>
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
                        <button><a href="customerInformation.php?id=<?php echo $employee_id; ?>">Customer Information</a></button>
                        <button><a href="salesHistory.php?id=<?php echo $employee_id; ?>">View Sales History</a></button>
                        <button><a href="add_manager.php?id=<?php echo $employee_id; ?>">Add New Employee</a></button>
                        <button><a href="viewStore_employee.php?id=<?php echo $employee_id; ?>">View Store Inventory</a></button>
                        <button><a href="viewStore_manager.php?id=<?php echo $employee_id; ?>">View All Store Inventory</a></button>
                        <button><a href="viewInventory.php?id=<?php echo $employee_id; ?>">View Total Inventory</a></button>
                        <button><a href="soldProduct.php?id=<?php echo $employee_id; ?>">View Pickup Order</a></button>
                        <button><a href="productInformation.php?id=<?php echo $employee_id; ?>">Product Information</a></button> 
                        <button><a href="employeeInformation.php?id=<?php echo $employee_id; ?>">View Employee Information</a></button> 
                        <button><a href="salesOrderLog.php?id=<?php echo $employee_id; ?>">Store Product Consumption Record</a></button> 
                        <button><a href="managerSalesOrderLog.php?id=<?php echo $employee_id; ?>">Product Consumption Record</a></button> 
                    </div>
                </div>
                <div class="content">
                    <div class="conta">
                        <h2>Update Employee Information</h2>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <div class="form-group">
                                <label for="firstName">First Name:</label>
                                <input type="text" id="firstName" name="firstName" required>
                            </div>
                            <div class="form-group">
                                <label for="lastName">Last Name:</label>
                                <input type="text" id="lastName" name="lastName" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone:</label>
                                <input type="tel" id="phone" name="phone" required>
                            </div>
                            <div class="form-group">
                                <label for="age">Age:</label>
                                <input type="number" id="age" name="age" required>
                            </div>
                            <div class="form-group">
                                <label>Gender:</label>
                                <div class="radio-group">
                                    <label><input type="radio" name="sex" value="M" required> Male</label>
                                    <label><input type="radio" name="sex" value="F"> Female</label>
                                </div>
                            </div>
                           
                            <button type="submit" class="btn-submit">Update</button>
                        </form>
                    </div>
                    <?php
                    include "conn.php";

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $firstName = $_POST['firstName'];
                        $lastName = $_POST['lastName'];
                        $email = $_POST['email'];
                        $phone = $_POST['phone'];
                        $age = $_POST['age'];
                        $sex = $_POST['sex'];
                        //$position = $_POST['position'];

                        $sqlPerson = "UPDATE person SET first_name = '$firstName', last_name = '$lastName', email = '$email', phone_number = '$phone', age = '$age', sex = '$sex' WHERE id = '$employee_id'";
                        mysqli_query($conn, $sqlPerson);

                        if (mysqli_affected_rows($conn) > 0) {
                            echo "Employee information updated successfully.";
                        } else {
                            echo "Error updating customer information.";
                        }

                        $conn->close();
                    }
                    ?>
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