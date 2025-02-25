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

$itemsPerPage = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page <= 0) $page = 1;  

$start_time = microtime(true);

$sql = "SELECT COUNT(*) AS total FROM store";
$result = $conn->query($sql);
$totalItems = $result->fetch_assoc()['total'];
$totalPages = ceil($totalItems / $itemsPerPage);

$offset = ($page - 1) * $itemsPerPage;

$sql = "SELECT sid, s_name, st_hour, ed_hour, s_money, address, contact_phone, image FROM store LIMIT $itemsPerPage OFFSET $offset";
$result = $conn->query($sql);

$end_time = microtime(true);
$execution_time = $end_time - $start_time;

if ($result->num_rows > 0) {
    $stores = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $stores = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Price List</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .feedback-message {
            color: green;
            font-weight: bold;
            margin: 10px 0;
        }
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
        .content { flex: 1; padding: 20px; margin-left: 15%; display: flex; justify-content: flex-start; }
        .product-price-list-container { max-width: 800px; margin-right: 20px; flex-grow: 1; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; text-align: left; border: 1px solid #ddd; }
        button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #333;
            color: white;
            border: none;
            cursor: pointer;
        }
        form {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            background: #f9f9f9;
            max-width: 400px;
        }
        form input, form button {
            margin-bottom: 10px;
            padding: 10px;
            width: calc(100% - 20px);
        }
        form label {
            font-weight: bold;
        }
        .store-image {
            max-width: 80px;
            height: auto;
            display: block;
            margin: auto;
        }
        .edit-mode td input {
            width: calc(100% - 20px);
            padding: 5px;
        }

        .store-and-form-container {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }
        .form-container {
            max-width: 400px;
        }

.pagination {
    margin-top: 20px;
    text-align: center;
}

.pagination a {
    margin: 0 5px;
    padding: 8px 12px;
    text-decoration: none;
    color: #333;
    background-color: #f1f1f1;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
    transition: background-color 0.2s;
}

.pagination a.active {
    background-color: #007bdd;
    color: white;
    font-weight: bold;
}

.pagination a:hover {
    background-color: #ddd;
}

.pagination a.disabled {
    background-color: #e0e0e0;
    color: #999;
    cursor: not-allowed;
}

.pagination .prev, .pagination .next {
    font-weight: bold;
}
    </style>
</head>
<body>
    <header>
        <nav>
            <h1>Store Information</h1>
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
                <div class="store-and-form-container">
                        <div class="store-price-list-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Store ID</th>
                                    <th>Store Name</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Income</th>
                                    <th>Address</th>
                                    <th>Contact Phone</th>
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($stores as $store): ?>
                                    <tr>
                                        <td class="store-id"><?php echo htmlspecialchars($store['sid']); ?></td>
                                        <td class="store-name"><?php echo htmlspecialchars($store['s_name']); ?></td>
                                        <td class="st_hour"><?php echo htmlspecialchars($store['st_hour']); ?></td>
                                        <td class="ed_hour"><?php echo htmlspecialchars($store['ed_hour']); ?></td>
                                        <td class="s_money"><?php echo htmlspecialchars($store['s_money']); ?></td>
                                        <td class="address"><?php echo htmlspecialchars($store['address']); ?></td>
                                        <td class="contact_phone"><?php echo htmlspecialchars($store['contact_phone']); ?></td>
                                        <td>
                                            <?php if ($store['image']): ?>
                                                <img src="show_image_store.php?sid=<?php echo $store['sid']; ?>" alt="<?php echo htmlspecialchars($store['s_name']); ?>" class="store-image">
                                            <?php else: ?>
                                                <p>No Image Available</p>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <button class="edit-button" data-id="<?php echo htmlspecialchars($store['sid']); ?>">Edit</button>
                                            <button class="delete-button" data-id="<?php echo htmlspecialchars($store['sid']); ?>">Delete</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <div class="pagination">
                        <?php 
                                $rangeStart = max($page - 4, 1);
                                $rangeEnd = min($page + 4, $totalPages);

                                if ($page > 1) {
                                    echo '<a href="?page=1">&laquo; First</a>';
                                    echo '<a href="?page=' . ($page - 1) . '">Previous</a>';
                                }

                                for ($i = $rangeStart; $i <= $rangeEnd; $i++) {
                                    echo '<a href="?page=' . $i . '" class="' . ($i == $page ? 'active' : '') . '">' . $i . '</a>';
                                }

                                if ($page < $totalPages) {
                                    echo '<a href="?page=' . ($page + 1) . '">Next</a>';
                                    echo '<a href="?page=' . $totalPages . '">Last &raquo;</a>';
                                }
                            ?>
                        </div>
                        </div>
                        <div class="modify">
                            <div class="addform">
                                <h3>Add New Store</h3>
                                <form id="add-store-form" action="add_store.php" method="POST" enctype="multipart/form-data">
                                    
                                    <!-- Store Name -->
                                    <label for="s_name">Store Name</label>
                                    <input type="text" id="s_name" name="s_name" required>

                                    <!-- Start Hour -->
                                    <label for="st_hour">Start Hour</label>
                                    <input type="time" id="st_hour" name="st_hour" required>

                                    <!-- End Hour -->
                                    <label for="ed_hour">End Hour</label>
                                    <input type="time" id="ed_hour" name="ed_hour" required>

                                    <!-- Store Money -->
                                    <label for="s_money">Store Money</label>
                                    <input type="number" id="s_money" name="s_money" required>

                                    <!-- Store Address -->
                                    <label for="address">Address</label>
                                    <input type="text" id="address" name="address" required>

                                    <!-- Contact Phone -->
                                    <label for="contact_phone">Contact Phone</label>
                                    <input type="tel" id="contact_phone" name="contact_phone" required>

                                    <!-- Store Image -->
                                    <label for="image">Store Image</label>
                                    <input type="file" id="image" name="image" accept="image/*">

                                    <button type="submit">Add Store</button>
                                </form>
                                <?php echo "<p>Execution time is:  $execution_time</p>"; ?>
                            </div>
                            <div id="edit-form-container" class="form-container" style="display: none;">
                            </div>
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
        //edit form
        document.querySelectorAll('.edit-button').forEach(button => {
            button.addEventListener('click', function () {
                const storeId = this.getAttribute('data-id');
                const storeRow = this.closest('tr');
                const storeName = storeRow.querySelector('.store-name').innerText;
                const stHour = storeRow.querySelector('.st_hour').innerText;
                const edHour = storeRow.querySelector('.ed_hour').innerText;
                const sMoney = storeRow.querySelector('.s_money').innerText;
                const address = storeRow.querySelector('.address').innerText;
                const contactPhone = storeRow.querySelector('.contact_phone').innerText;
                const currentPicture = storeRow.querySelector('img') ? storeRow.querySelector('img').src : '';

                const formHTML = `
                    <h3>Edit Store</h3>
                    <form id="edit-form" action="edit_store.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="store_id" value="${storeId}">
                        <label for="s_name">Store Name</label>
                        <input type="text" id="s_name" name="s_name" value="${storeName}" required>

                        <label for="st_hour">Opening Hour</label>
                        <input type="time" id="st_hour" name="st_hour" value="${stHour}" required>

                        <label for="ed_hour">Closing Hour</label>
                        <input type="time" id="ed_hour" name="ed_hour" value="${edHour}" required>

                        <label for="s_money">Store Money</label>
                        <input type="number" id="s_money" name="s_money" value="${sMoney}" required>

                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" value="${address}" required>

                        <label for="contact_phone">Contact Phone</label>
                        <input type="text" id="contact_phone" name="contact_phone" value="${contactPhone}" required>

                        <label for="image">Store Image (Optional)</label>
                        <input type="file" id="image" name="image" accept="image/*">

                        <p>Current Image:</p>
                        ${currentPicture ? `<img src="${currentPicture}" alt="Current Store Image" style="max-width: 100px; height: auto;">` : '<p>No current image available.</p>'}

                        <button type="submit">Save Changes</button>
                    </form>
                `;
                
                document.getElementById('edit-form-container').innerHTML = formHTML;
                document.getElementById('edit-form-container').style.display = 'block';
            });
        });

        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function () {
                const storeId = this.getAttribute('data-id');

                window.location.href = `delete_product_store.php?sid=${storeId}`;
            });
        });
    </script>
</body>
</html>