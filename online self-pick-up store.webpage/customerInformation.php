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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Information Query</title>
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
        
        #pagination button {
            padding: 5px 10px;
            margin: 0 5px;
            background-color: #f4f4f4;
            border: 1px solid #ddd;
            cursor: pointer;
        }
        #pagination button.active {
            background-color: #007bdd;
            color: white;
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
            <h1>Customer Information Query</h1>
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
                    <div class="search-form">
                        <form method="get" action="customerInformation.php">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="hidden" name="type" value="<?php echo $type; ?>">

                            <label for="searchID">Search by Customer ID:</label>
                            <input type="text" id="searchID" name="searchID" value="<?= isset($_GET['searchID']) ? htmlspecialchars($_GET['searchID']) : '' ?>">

                            <label for="searchName">Search by Customer Name:</label>
                            <input type="text" id="searchName" name="searchName" value="<?= isset($_GET['searchName']) ? htmlspecialchars($_GET['searchName']) : '' ?>">

                            <button type="submit">Search</button>
                            <button onclick="window.location.href='customerUpdateInfomation.html'">Update Customer Information</button>
                            <button type="button" onclick="displayAll()">Display All</button>
                        </form>
                    </div>
                    <div id="table-container"></div>
                    <div id="pagination" class="pagination"></div>
                    <?php
                        function display(){
                            include "conn.php";

                            $searchID = isset($_GET['searchID']) ? $_GET['searchID'] : '';
                            $searchName = isset($_GET['searchName']) ? $_GET['searchName'] : '';

                            $whereClauses = [];
                            if ($searchID) {
                                $whereClauses[] = "id LIKE '%" . mysqli_real_escape_string($conn, $searchID) . "%'";
                            }
                            if ($searchName) {
                                $whereClauses[] = "user_name LIKE '%" . mysqli_real_escape_string($conn, $searchName) . "%'";
                            }

                            $whereSQL = '';
                            if (count($whereClauses) > 0) {
                                $whereSQL = "WHERE " . implode(' AND ', $whereClauses);
                            }

                            $start_time = microtime(true);
                            $sql1 = "SELECT * FROM `customer` JOIN person USING(id) " . $whereSQL;
                            $result1 = mysqli_query($conn, $sql1);
                            $end_time = microtime(true);
                            $execution_time = $end_time - $start_time;
                            echo "<p>Execution time is:  $execution_time</p>";
                            
                            if (!$result1) {
                                die('Query failed: ' . mysqli_error($conn));
                            }

                            $rows = [];
                            if (mysqli_num_rows($result1) > 0) {
                                while ($row = mysqli_fetch_assoc($result1)) {
                                    $rows[] = $row; 
                                }
                            }

                            echo '<script>';
                            echo 'const tableData = ' . json_encode($rows) . ';'; 
                            echo 'renderTable(1);'; 
                            echo 'renderPagination();'; 
                            echo '</script>';
                            
                            mysqli_close($conn);
                        }
                        display();
                    ?>


        </section>
    </main>
    <footer>
        <p>&copy; Group 05 DBMS Project. All rights reserved.</p>
    </footer>
    <script>
        function displayAll(){
            // Clear the search inputs
            document.getElementById('searchID').value = '';
            document.getElementById('searchName').value = '';

            // Reload the page without any search parameters
            window.location.href = 'customerInformation.php';
        }
        const rowsPerPage = 20;
        let currentPage = 1;
        const maxPagesToShow = 10;

        function renderTable(page) {
            const tableContainer = document.getElementById('table-container');
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            const currentPageData = tableData.slice(start, end);
            let tableHTML = `
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User Name</th>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Age</th>
                            <th>Sex</th>
                            <th>Account</th>
                        </tr>
                    </thead>
                    <tbody>
            `;
            currentPageData.forEach(row => {
                tableHTML += `
                    <tr>
                        <td>${row.id}</td>
                        <td>${row.user_name}</td>
                        <td>${row.firstname}</td>
                        <td>${row.lastname}</td>
                        <td>${row.email}</td>
                        <td>${row.phone_number}</td>
                        <td>${row.age}</td>
                        <td>${row.sex}</td>
                        <td>${row.account}</td>
                    </tr>
                `;
            });
            tableHTML += `</tbody></table>`;
            tableContainer.innerHTML = tableHTML;
        }

        function renderPagination() {
            const totalPages = Math.ceil(tableData.length / rowsPerPage);
            const paginationContainer = document.getElementById('pagination');
            let pageNumbers = [];

            const startPage = Math.max(1, currentPage - Math.floor(maxPagesToShow / 2));
            const endPage = Math.min(totalPages, currentPage + Math.floor(maxPagesToShow / 2));

            if (startPage > 1) {
                pageNumbers.push(1);
                if (startPage > 2) pageNumbers.push('...');
            }
            for (let i = startPage; i <= endPage; i++) {
                pageNumbers.push(i);
            }
            if (endPage < totalPages) {
                if (endPage < totalPages - 1) pageNumbers.push('...');
                pageNumbers.push(totalPages);
            }

            let paginationHTML = '';
            paginationHTML += `<button onclick="goToPage(1)">First</button>`;
            paginationHTML += `<button onclick="goToPage(currentPage - 1)">Previous</button>`;
            pageNumbers.forEach(page => {
                paginationHTML += `<button class="${page === currentPage ? 'active' : ''}" onclick="goToPage(${page})">${page}</button>`;
            });
            paginationHTML += `<button onclick="goToPage(currentPage + 1)">Next</button>`;
            paginationHTML += `<button onclick="goToPage(${totalPages})">Last</button>`;

            paginationContainer.innerHTML = paginationHTML;
        }

        function goToPage(page) {
            const totalPages = Math.ceil(tableData.length / rowsPerPage);
            if (page < 1 || page > totalPages) return;
            currentPage = page;
            renderTable(page);
            renderPagination();
        }

        // Initial render
        renderTable(currentPage);
        renderPagination();

        //search form
        function performSearch() {
            const searchID = document.getElementById('searchID').value;
            const searchName = document.getElementById('searchName').value;

            // If both inputs are empty, alert the user
            if (!searchID && !searchName) {
                alert("Please enter at least one search parameter: Customer ID or User Name.");
                return;
            }

            // Construct the query string
            let queryString = "?";

            if (searchID) {
                queryString += `searchID=${encodeURIComponent(searchID)}&`;
            }
            if (searchName) {
                queryString += `searchName=${encodeURIComponent(searchName)}&`;
            }

            // Remove the trailing '&' if it exists
            queryString = queryString.slice(0, -1);

            // Redirect to the same page with the search parameters in the URL
            window.location.href = "customerInformation.php" + queryString;
        }



    </script>
</body>
</html>