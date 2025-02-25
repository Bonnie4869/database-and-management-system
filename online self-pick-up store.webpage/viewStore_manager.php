<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store List</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .container { display: flex; height: 100%; width: 100%; }
        .sidebar { width: 15%; background-color: #f4f4f4; padding: 20px; height: 80%; box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1); position: fixed;}
        .sidebar h2 { font-size: 18px; margin-bottom: 20px; }
        button:hover { background-color: #007fff;}
        .sidebar-content button {
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
        .sidebar-content button:hover { background-color: #007fff;}
        .sidebar-content {
            position: relative;
            flex-grow: 1;
            overflow-y: auto;
            padding: 10px;
        }
        .content { flex: 1; padding: 20px; margin-left: 15%; width: 100%;}
        .Header {
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .header-button {
            width: 60px;
            height: 30px;
            border: none;
            background-color: #007bdd;
            color: white;
        }
        .search-button {
            width: 60px;
            height: 25px;
            border: none;
            background-color: #007bdd;
            color: white;
        }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; margin-bottom: 20px; }
        table th, table td { border: 1px solid #ddd; text-align: center; padding: 10px; }
        table th { background-color: #f4f4f4; }
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
            <h1>Store List</h1>
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
                    <div class="Header">
                        <h1 id="storeName"></h1>
                        <input type="text" id="store" style="height: 30px; width: 250px; text-align: center;" placeholder="Search Store">&nbsp;&nbsp;
                        <select style="height: 30px; text-align: center" id="storeType">
                            <option style="height: 25px;" value="id">Search by Store ID</option>
                            <option value="name">Search by Store Name</option>
                        </select>&nbsp;&nbsp;
                        <button class="header-button" onclick="searchStore()">Search</button><br><br>
                        <input type="text" id="product" style="height: 30px; width: 250px; text-align: center;" placeholder="Search Product">&nbsp;&nbsp;
                        <select style="height: 30px; text-align: center;" id="productType">
                            <option style="height: 25px;" value="id">Search by Product ID</option>
                            <option value="name">Search by Product Name</option>
                        </select>&nbsp;&nbsp;
                        <button class="header-button" onclick="searchProduct()">Search</button>
                        <p id="hint"></p>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Product ID</th>
                                <th>Product Name</th>
                                <th>Number</th>
                                <th>Selling Price</th>
                                <th>Product Image</th>
                            </tr>
                        </thead>
                        <tbody id = "showBody"></tbody>
                    </table>
                    <div id="page"></div>
                </div>
            </div>    
        </section>
    </main>
    <footer>
        <p>&copy; Group 05 DBMS Project. All rights reserved.</p>
    </footer>
    <script>
        let local = [], storeName = "";

        function searchStore() {
            let store = document.getElementById('store').value.trim();
            let storeType = document.getElementById('storeType').value.trim();
            if (store === "") {
                document.getElementById('hint').innerHTML = "You should select a store first!";
                return;
            } else document.getElementById('hint').innerHTML = "";
            fetch('viewStore_manager_function.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `store=${encodeURIComponent(store)}&storeType=${encodeURIComponent(storeType)}&product=${encodeURIComponent("")}&productType=${encodeURIComponent("")}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    if (storeType === "name") storeName = store;
                    else {
                        const names = data.name;
                        let name = "";
                        names.forEach(oup => {
                            name = oup.s_name;
                        });
                        storeName = name;
                    }
                    const orders = data.data;
                    let idx = 0;
                    local = [];
                    orders.forEach(order => {
                        local[idx++] = [ parseInt(order.pid), order.p_name, parseInt(order.s_quantity), order.price, order.image ];
                    });
                    showPageButton(idx);
                    show(1);
                } else {
                    document.getElementById('showBody').innerHTML = `<tr><td colspan="5">${data.message}</td></tr>`;
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
        function searchProduct() {
            let store = document.getElementById('store').value.trim();
            let storeType = document.getElementById('storeType').value.trim();
            let product = document.getElementById('product').value.trim();
            let productType = document.getElementById('productType').value.trim();
            if (store === "") {
                document.getElementById('hint').innerHTML = "You should select a store first!";
                return;
            } else document.getElementById('hint').innerHTML = "";
            if (product === "") {
                document.getElementById('hint').innerHTML = "You should select a product!";
                return;
            } else document.getElementById('hint').innerHTML = "";
            fetch('viewStore_manager_function.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `store=${encodeURIComponent(store)}&storeType=${encodeURIComponent(storeType)}&product=${encodeURIComponent(product)}&productType=${encodeURIComponent(productType)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    if (storeType === "name") storeName = store;
                    else {
                        const names = data.name;
                        let name = "";
                        names.forEach(oup => {
                            name = oup.s_name;
                        });
                        storeName = name;
                    }
                    const orders = data.data;
                    let idx = 0;
                    local = [];
                    orders.forEach(order => {
                        local[idx++] = [ parseInt(order.pid), order.p_name, parseInt(order.s_quantity), order.price, order.image ];
                    });
                    showPageButton(idx);
                    show(1);
                } else {
                    document.getElementById('showBody').innerHTML = `<tr><td colspan="5">${data.message}</td></tr>`;
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        function show(pg) {
            document.getElementById('storeName').innerHTML = storeName;
            let output = "";
            for (i = (pg - 1) * 40; i < pg * 40 && i < local.length; i++) {
                output += `<tr><td>` + local[i][0] + `</td><td>` + local[i][1] + `</td><td>` + local[i][2] + `</td><td>` + local[i][3] + `</td>`;
                if (local[i][4]) {
                    const pictureURL = URL.createObjectURL(local[i][4]);
                    output += `<td><img src="${pictureURL}" alt="Image" style="max-width: 100px; max-height: 100px;"></td></tr>`;
                } else {
                    output += `<td></td></tr>`;
                }
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