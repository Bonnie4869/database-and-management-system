<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Customer Information</title>
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
            <h1>Update Customer Information</h1>
            <ul class="nav-links">
                <?php
                    include "conn.php";
                    $customer_id = isset($_GET['id']) ? intval($_GET['id']) : 1; 
                    
                    if ($customer_id == 0) {
                        header("Location: customer_login.html");
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
        <section>
            <div class="container">
                <div class="sidebar">
                    <h2 style="position: fixed; margin-top: 0;">Page Selection</h2>
                    <div class="sidebar-content" style="margin-top: 15%; height: 95%;">
                        <button><a href="customerInformation.html">Customer Information</a></button>
                        <button><a href="salesHistory.html">View Sales History</a></button>
                        <button><a href="add_manager.html">Add New Employee</a></button>
                        <button><a href="viewStore_employee.html">View Store Inventory</a></button>
                        <button><a href="viewStore_manager.html">View All Store Inventory</a></button>
                        <button><a href="viewInventory.html">View Total Inventory</a></button>
                        <button><a href="soldProduct.html">View Pickup Order</a></button>
                        <button><a href="productInformation.html">Product Information</a></button> 
                        <button><a href="employeeInformation.html">View Employee Information</a></button> 
                        <button><a href="salesOrderLog.html">Store Product Consumption Record</a></button> 
                        <button><a href="managerSalesOrderLog.html">Product Consumption Record</a></button> 
                    </div>
                </div>
                <div class="content">
                    <div class="conta">
                        <h2>Update Customer Information</h2>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <div class="form-group">
                                <label for="userName">User Name:</label>
                                <input type="text" id="userName" name="userName" required>
                            </div>
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
                            <div class="form-group">
                                <label for="account">Account:</label>
                                <input type="number" id="account" name="account" required>
                            </div>
                            <button type="submit" class="btn-submit">Update</button>
                        </form>
                    </div>
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $userName = $_POST['userName'];
                        $account = $_POST['account'];
                        $firstName = $_POST['firstName'];
                        $lastName = $_POST['lastName'];
                        $email = $_POST['email'];
                        $phone = $_POST['phone'];
                        $age = $_POST['age'];
                        $gender = $_POST['sex'];

                        if ($userName != NULL && $account != NULL) {
                            $sqlCustomer = "UPDATE customer SET user_name = '$userName', c_money = '$account' WHERE id = '$customer_id'";
                            mysqli_query($conn, $sqlCustomer);
                        }

                        if ($firstName != NULL && $lastName != NULL && $email != NULL && $phone != NULL && $age != NULL && $gender != NULL) {
                            $sqlPerson = "UPDATE person SET first_name = '$firstName', last_name = '$lastName', email = '$email', phone_number = '$phone', age = '$age', sex = '$gender' WHERE id = '$customer_id'";
                            mysqli_query($conn, $sqlPerson);
                        }

                        if (mysqli_affected_rows($conn) > 0) {
                            echo "Customer information updated successfully.";
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