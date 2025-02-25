<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History Search</title>
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

        .filters {
            margin-bottom: 20px;
        }

        .filters label {
            margin-right: 10px;
            font-weight: bold;
        }

        .filters input {
            padding: 5px;
            margin: 5px 10px;
            width: 200px;
        }

        button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<?php
    include "conn.php";
    session_start();
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        //echo "User ID: " . $user_id;  // Display the user ID for validation
    } else {
        // echo "No user ID provided.";
        $id = null; // If no user_id is passed, set it to null.
    }
?>
<body>
    <?php
        include "conn.php";
        $type = "";
        if (isset($_GET['type']))  $type = $_GET['type'];
        else $type = "employee";
    ?>
    <header>
        <nav>
            <h1>Order History Search</h1>
            <ul class="nav-links">
                <li><a href="B_Personal Information.php?id=<?php echo $id; ?>&type=<?php echo $type?>">Me</a></li>
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
                    <h1>Order History Search</h1>

                    <div class="filters">
                        <label for="orderId">Order ID:</label>
                        <input type="text" id="orderId" placeholder="Enter Order ID">
                        <label for="pickUpId">Pickup ID:</label>
                        <input type="text" id="pickUpId" placeholder="Enter Pickup ID"><br>
                        <label for="buyerId">Buyer ID:</label>
                        <input type="text" id="buyerId" placeholder="Enter Buyer ID">
                        <label for="username">Username:</label>
                        <input type="text" id="username" placeholder="Enter Username"><br>
                        <label for="paymentTime">Payment Time:</label>
                        <input type="date" id="paymentTime">
                        <label for="pickUpTime">Pickup Time:</label>
                        <input type="date" id="pickUpTime"><br>
                        <button onclick="filterOrders()">Search</button>
                    </div>
                    <table id="orderTable">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Pickup ID</th>
                                <th>Buyer ID</th>
                                <th>Username</th>
                                <th>Payment Time</th>
                                <th>Pickup Time</th>
                            </tr>
                        </thead>
                        <tbody id="showBody">
                        </tbody>
                    </table>
                    <div id = "page">
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; Group 05 DBMS Project. All rights reserved.</p>
    </footer>
    <script>
        let local = [], info = [];
        function filterOrders() {
            let oid = document.getElementById("orderId").value.trim(), pid = document.getElementById("pickUpId").value.trim();
            let bid = document.getElementById("buyerId").value.trim(), usrnm = document.getElementById("username").value.trim();
            let pyt = document.getElementById("paymentTime").value.trim(), put = document.getElementById("pickUpTime").value.trim();
            if (oid === "" && pid === "" && bid === "" && usrnm === "" && put === "" && pyt === "") {
                local = info;
                showPageButton(info.length);
                show(1);
                return;
            }
            let out = "", num = 0;
            local = [];
            for (let i = 0; i < info.length; i++) {
                //if (!info[i] || !Array.isArray(info[i])) continue;
                let flag = true;
                if (!put.length && !pyt.length) flag = false;
                for (let j = 0; j < pyt.length; j++) if (pyt[j] !== info[i][4][j]) { flag = false; break; }
                for (let j = 0; j < put.length; j++) if (put[j] !== info[i][5][j]) { flag = false; break; }
                if (flag || info[i][0] === parseInt(oid) || info[i][1] === parseInt(pid) || info[i][2] === parseInt(bid) || info[i][3] === usrnm) {
                    local[num] = info[i];
                    //console.log("YES");
                    num++;
                }
            }
            // console.log(local.length);
            showPageButton(num);
            show(1);
        }

        function init() {
            fetch('salesHistory_function.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: ``
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    const orders = data.data;
                    let output = '';
                    let i = 0;
                    local = [];
                    orders.forEach(order => {
                        info[i] = [ parseInt(order.oid), parseInt(order.pickup_id), parseInt(order.id), order.user_name, order.order_time, order.pickup_time ];
                        local[i] = [ parseInt(order.oid), parseInt(order.pickup_id), parseInt(order.id), order.user_name, order.order_time, order.pickup_time ];
                        i++;
                    });
                    showPageButton(i);
                    show(1);
                } else {
                    document.getElementById('showBody').innerHTML = `<tr><td colspan="6">${data.message}</td></tr>`;
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
        init();

        function show(pg) {
            let output = "";
            for (i = (pg - 1) * 40; i < Math.min(pg * 40, local.length); i++) {
                output += `<tr><td>` + local[i][0] + `</td><td>` + local[i][1] + `</td><td>` + local[i][2] + `</td><td>` + local[i][3] + `</td>`;
                if (String(local[i][4]) === "0000-00-00 00:00:00") output += `<td></td>`;
                else output += `<td>` + local[i][4] + `</td>`;
                if (String(local[i][5]) === "0000-00-00 00:00:00") output += `<td></td></tr>`;
                else output += `<td>` + local[i][5] + `</td></tr>`;
            }
            document.getElementById('showBody').innerHTML = output;
        }

        function showPageButton(tot) {
            let output = `Page: <select style="height: 30px; text-align: left;" onchange = show(this.value)>`;
            for (i = 1; i <= (tot + 39) / 40; i++) output += `<option value = '` + i + `'>` + i + `</button>`;
            output += `</select>`;
            document.getElementById('page').innerHTML = output;
        }
    </script>
</body>
</html>
