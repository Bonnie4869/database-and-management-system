<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Information</title>
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
    <?php
        include "conn.php";
        $type = ""; $id = "";
        if (isset($_GET['type']))  $type = $_GET['type'];
        else $type = "employee";
        if (isset($_GET['id']))  $id = $_GET['id'];
        else $id = 0;
    ?>
    <header>
        <nav>
            <h1>Update Information</h1>
            <ul class="nav-links">
    <li><a href="B_Personal Information.php?id=<?php echo $person_id; ?>&type=<?php echo $type?>">Me</a></li>
    <li><a href="seller_login.php?id=<?php echo $person_id; ?> <?php session_destroy() ?>">Log Out</a></li>
</ul>
        </nav>
    </header>
    <main>
        <section>
            <div class="container">
                <div class="sidebar">
                    <h2 style="position: fixed; margin-top: 0;">Page Selection</h2>
                    <div class="sidebar-content" style="margin-top: 15%; height: 95%;">
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
                            <button><a href="managerSalesOrderLog.php?id=<?php echo $id?>&type=<?php echo $type?>">Product Consumption Record</a></button> 
                        <?php } ?>

                        <?php if ($type === "senior_manager") { ?>
                            <button><a href="customerInformation.php?id=<?php echo $id;?>&type=<?php echo $type?>">Customer Information</a></button>
                            <button><a href="salesHistory.php?id=<?php echo $id; ?>&type=<?php echo $type?>">View Sales History</a></button>
                            <button><a href="add_manager.php?id=<?php echo $id; ?>&type=<?php echo $type?>">Add New Employee</a></button>
                            <button><a href="viewStore_manager.php?id=<?php echo $id; ?>&type=<?php echo $type?>">View All Store Inventory</a></button>
                            <button><a href="soldProduct.php?id=<?php echo $id; ?>&type=<?php echo $type?>">View Pickup Order</a></button>
                            <button><a href="productInformation.php?id=<?php echo $id; ?>&type=<?php echo $type?>">Product Information</a></button>
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
                    <div class="conta">
                        <h2>Update Information</h2>
                        <form action="add_manager.php" method="POST">
                            <div class="form-group">
                                <label for="ID">ID:</label>
                                <input type="INT" id="ID" name="ID" required>
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
                                    <label><input type="radio" name="sex" value="male" required> Male</label>
                                    <label><input type="radio" name="sex" value="female"> Female</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="position">Position:</label>
                                <select id="position" name="position" required>
                                    <option value="">Select Position</option>
                                    <option value="manager">Manager</option>
                                    <option value="employee">Employee</option>
                                </select>
                            </div>
                            <div class="form-group" id="storeIdGroup" style="display: none;">
                                <label for="storeId">Store ID:</label>
                                <input type="number" id="storeId" name="storeId">
                            </div>
                            <script>
     document.getElementById('position').addEventListener('change', function() {
    var storeIdGroup = document.getElementById('storeIdGroup');
    if (this.value === 'employee') {
        storeIdGroup.style.display = 'block';
    } else {
        storeIdGroup.style.display = 'none';
    }
});
</script>
                            <button type="submit" class="btn-submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; Group 05 DBMS Project. All rights reserved.</p>
    </footer>

    <?php
include "conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $age = $_POST['age'];
    $gender = $_POST['sex'];
    $position = $_POST['position'];
    $storeId = isset($_POST['storeId']) ? $_POST['storeId'] : null; 

    $sql_person = "INSERT INTO person (first_name, last_name, email, age, phone_number, sex) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_person = $conn->prepare($sql_person);
    $stmt_person->bind_param("ssssis", $firstName, $lastName, $email, $age, $phone, $gender);

    if ($stmt_person->execute()) {
        $person_id = $conn->insert_id; 
        echo "New record created successfully in person table with ID: " . $person_id;
        
        if ($position == 'manager') {
            $sql_manager = "INSERT INTO manager (id) VALUES (?)";
            $stmt_manager = $conn->prepare($sql_manager);
            $stmt_manager->bind_param("i", $person_id);
            if (!$stmt_manager->execute()) {
                echo "Error: " . $stmt_manager->error;
            } else {
                echo "New manager record created successfully";
            }
            $stmt_manager->close();
        } elseif ($position == 'employee') {
            $sql_employee = "INSERT INTO employee (id, sid) VALUES (?, ?)"; 
            $stmt_employee = $conn->prepare($sql_employee);
            $stmt_employee->bind_param("ii", $person_id, $storeId); 
            if (!$stmt_employee->execute()) {
                echo "Error: " . $stmt_employee->error;
            } else {
                echo "New employee record created successfully with Store ID: " . $storeId;
            }
            $stmt_employee->close();
        }
    } else {
        echo "Error: " . $sql_person . "<br>" . $stmt_person->error;
    }
    
    $stmt_person->close();
    $conn->close();
}
?>
</body>
</html>