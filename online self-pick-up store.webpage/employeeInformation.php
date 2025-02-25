<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information Query</title>
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
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .search-form {
            margin-bottom: 20px;
        }
        .search-form label {
            display: block;
            margin-bottom: 5px;
        }
        .search-form input, .search-form select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }
        .search-form button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .search-form button:hover {
            background-color: #45a049;
        }
        #pagination a {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <?php
        include "conn.php";
        session_start();
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        } else {
            $id = 1; // Default ID if not provided
        }
        $type = isset($_GET['type']) ? $_GET['type'] : "employee";
    ?>
    <header>
        <nav>
            <h1>Employee Information Query</h1>
            <ul class="nav-links">
                <li><a href="B_Personal Information.php?id=<?php echo $id; ?>&type=<?php echo $type?>">Me</a></li>
                <li><a href="seller_login.php<?php session_destroy()?>">Log Out</a></li>
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
                            <button><a href="productInformation.php?id=<?php echo $id; ?>&type=<?php echo $type?>">Product Information</a></button> 
                        <?php } ?>

                        <?php if ($type === "manager") { ?>
                            <button><a href="customerInformation.php?id=<?php echo $id; ?>&type=<?php echo $type?>">Customer Information</a></button>
                            <button><a href="salesHistory.php?id=<?php echo $id; ?>&type=<?php echo $type?>">View Sales History</a></button>
                            <button><a href="viewStore_manager.php?id=<?php echo $id; ?>&type=<?php echo $type?>">View All Store Inventory</a></button>
                            <button><a href="viewInventory.php?id=<?php echo $id; ?>&type=<?php echo $type?>">View Total Inventory</a></button>
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
                            <button><a href="viewInventory.php?id=<?php echo $id; ?>&type=<?php echo $type?>">View Total Inventory</a></button>
                            <button><a href="soldProduct.php?id=<?php echo $id; ?>&type=<?php echo $type?>">View Pickup Order</a></button>
                            <button><a href="productInformation.php?id=<?php echo $id; ?>&type=<?php echo $type?>">Product Information</a></button>
                            <button><a href="employeeInformation.php?id=<?php echo $id; ?>&type=<?php echo $type?>">View Employee Information</a></button> 
                            <button><a href="managerSalesOrderLog.php?id=<?php echo $id?>&type=<?php echo $type?>">Product Consumption Record</a></button> 
                        <?php } ?>
                    </div>
                </div>
                <div class="content">
                    <div class="search-form">
                        <form method="get" action="">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="hidden" name="type" value="<?php echo $type; ?>">
                            <label for="searchById">Search by Employee ID:</label>
                            <input type="text" id="searchById" name="searchById">
                            <label for="searchByName">Search by Employee Name:</label>
                            <input type="text" id="searchByName" name="searchByName">
                            <button type="submit">Search</button>
                        </form>
                    </div>
                    <?php
                    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
                    $rowsPerPage = 10; 
                    $maxPages = 20; 

                    if ($_SERVER["REQUEST_METHOD"] == "GET" && (isset($_GET['searchById']) || isset($_GET['searchByName']))) {
                        $searchById = isset($_GET['searchById']) ? mysqli_real_escape_string($conn, $_GET['searchById']) : '';
                        $searchByName = isset($_GET['searchByName']) ? mysqli_real_escape_string($conn, $_GET['searchByName']) : '';

                        $whereClauses = [];
                        if ($searchById !== '') {
                            $whereClauses[] = "p.id LIKE '%$searchById%'";
                        }
                        if ($searchByName !== '') {
                            $whereClauses[] = "CONCAT(p.first_name, ' ', p.last_name) LIKE '%$searchByName%'";
                        }

                        $whereSQL = implode(' AND ', $whereClauses);
                        if ($whereSQL === '') {
                            $whereSQL = '1 = 1'; // Default condition if no search parameters are provided
                        }

                        $start_time = microtime(true);

                        $sqlCount = "SELECT COUNT(*) FROM person p 
                                     LEFT JOIN employee e ON p.id = e.id 
                                     WHERE $whereSQL";
                        $sql = "SELECT p.id, CONCAT(p.first_name, ' ', p.last_name) AS full_name, p.email, p.phone_number, p.age, p.sex 
                                FROM person p 
                                LEFT JOIN employee e ON p.id = e.id 
                                WHERE $whereSQL
                                LIMIT " . ($page - 1) * $rowsPerPage . ", $rowsPerPage";

                        $resultCount = mysqli_query($conn, $sqlCount);
                        $result = mysqli_query($conn, $sql);

                        $end_time = microtime(true);
                        $execution_time = $end_time - $start_time;
                        echo "<p>Execution time is:  $execution_time</p>";

                        if ($resultCount && $result) {
                            $rowCount = mysqli_fetch_array($resultCount);
                            $totalRows = $rowCount[0];
                            $totalPages = ceil($totalRows / $rowsPerPage);
                        } else {
                            $totalPages = 0;
                        }

                        if ($result && mysqli_num_rows($result) > 0) {
                            echo "<table>
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone Number</th>
                                            <th>Age</th>
                                            <th>Sex</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>
                                        <td>" . htmlspecialchars($row['id']) . "</td>
                                        <td>" . htmlspecialchars($row['full_name']) . "</td>
                                        <td>" . htmlspecialchars($row['email']) . "</td>
                                        <td>" . htmlspecialchars($row['phone_number']) . "</td>
                                        <td>" . htmlspecialchars($row['age']) . "</td>
                                        <td>" . htmlspecialchars($row['sex']) . "</td>
                                    </tr>";
                            }
                            echo "</tbody></table>";
                        } else {
                            echo "<p>No results found.</p>";
                        }

                        if ($totalPages > 0) {
                            $startPage = max(1, $page - ($maxPages / 2));
                            $endPage = min($totalPages, $page + ($maxPages / 2) - 1);
                            if ($endPage - $startPage + 1 < $maxPages) {
                                $startPage = max(1, $endPage - $maxPages + 1);
                            }
                            echo "<div id='pagination'>";
                            if ($page > 1) {
                                echo "<a href='?searchById=$searchById&searchByName=$searchByName&page=" . ($page - 1) . "&id=".$id."&type=".$type."'>Previous</a>";
                            }
                            for ($i = $startPage; $i <= $endPage; $i++) {
                                echo "<a href='?searchById=$searchById&searchByName=$searchByName&page=$i&id=$id&type=$type'" . ($page == $i ? " class='active'" : "") . ">$i</a> ";
                            }
                            if ($page < $totalPages) {
                                echo "<a href='?searchById=$searchById&searchByName=$searchByName&page=" . ($page + 1) . "&id=".$id."&type=".$type."'>Next</a>";
                            }
                            echo "</div>";
                        }
                    }
                    $conn->close();
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