<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager View Pick Up Order Dashboard</title>
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
        .store-select {
            margin-bottom: 20px;
        }
        .store-selected {
            font-weight: bold;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<?php
        include "conn.php";
        $type = "";
        if (isset($_GET['type']))  $type = $_GET['type'];
        else $type = "employee";
    ?>
    <header>
        <nav>
            <h1>Manager View Pick Up Order Dashboard</h1>
            <ul class="nav-links">
                <li><a href="B_Personal Information.php?id=<?php echo $id; ?>&type=<?php echo $type?>">Me</a></li>
                <li><a href="seller_login.php <?php session_destroy()?>">Log Out</a></li>
            </ul>
        </nav>
        <?php
        $id = $_GET['id'] ?? '1';
        ?>

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
                    </div>
                </div>
                <?php
                include "conn.php";
                $start_time = microtime(true);
                echo '<div class="content">
                <form id="storeForm" target="responseFrame" method="POST" action="fetch_store_log_details.php">
                    <div class="store-select">
                        <p>Search and Select Store:</p>';
                    
                        echo '<select id="storeSelect" name="sid" title="Select a store" onchange="document.getElementById(\'storeForm\').submit()">
                            <option value="">Select a Store</option>';
                            $sql = "SELECT * FROM store";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                                $name = $row["s_name"];
                                $sid = $row["sid"];
                                echo "<option value=" . $sid . ">" . $name . "</option>";
                            }
                        echo '</select>';
                        
                    echo '</div>
                </form>';
                $end_time = microtime(true);
                $execution_time = $end_time - $start_time;
                echo "<p>Execution time is:  $execution_time</p>";
                echo "<p id='newTime'></p>";
                ?>
                    <div id="storeDetails" class="store-selected">No store selected yet.</div>
            <h2 id="storeTitle">Select a store to view orders.</h2>
            <table id="ordersTable" style="display: none;">
                <thead>
                    <tr>
                        <th>Pickup_center ID</th>
                        <th>Order number</th>
                        <th>Buyer's name</th>
                        <th>Buyer ID</th>
                        <th>Order time</th>
                        <th>Pickup confirmation time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; Group 05 DBMS Project. All rights reserved.</p>
    </footer>
    <iframe id="responseFrame" name="responseFrame" style="display: none;" onload="processResponse(this)"></iframe>
    <script>
            function processResponse(iframe) {
                const doc = iframe.contentDocument || iframe.contentWindow.document;
                const response = doc.body.innerHTML;  
                const data = JSON.parse(response); 
                updateContent(data); 
            }

            function updateContent(data) {
                const storeDetailsDiv = document.getElementById('storeDetails');
                const ordersTable = document.getElementById('ordersTable');
                const tableBody = ordersTable.querySelector('tbody');
                const title = document.getElementById('storeTitle');

                if (data.data.length === 0) {
                    ordersTable.style.display = 'none';
                    title.innerHTML = 'Select a store to view orders.';
                    storeDetailsDiv.innerHTML = `No store selected yet.`;
                    return;
                }

                storeDetailsDiv.innerHTML = `Details for Store <u>${data.data[0].store_name}</u>`;
                title.innerHTML = '';
                document.getElementById("newTime").innerHTML = `Execution time is: ${data.execution_time}`;

                ordersTable.style.display = 'table';
                tableBody.innerHTML = ''; 

                data.data.forEach((row, index) => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${row.pickup_id}</td>
                        <td>${row.oid}</td>
                        <td>${row.buyer_name}</td>
                        <td>${row.bid}</td>
                        <td>${row.order_time}</td>
                        <td id="confirmTime${index}">
                            ${row.pickup_time !== "0000-00-00 00:00:00" ? row.pickup_time : ""}
                        </td>
                        <td>
                            ${
                                row.pickup_time !== "0000-00-00 00:00:00"
                                    ? '<button class="btn" disabled>Confirm Pickup</button>'
                                    : `
                                    <form action="manager_update_pickupTime.php" method="POST">
                                        <input type="hidden" name="order_id" value="${row.oid}">
                                        <input type="hidden" name="name" value="${row.buyer_name}">
                                        <button class="btn" type="submit">Confirm Pickup</button>
                                    </form>`
                            }
                        </td>
                    `;
                    tableBody.appendChild(tr);
                });
            }
        </script>
</body>
</html>
