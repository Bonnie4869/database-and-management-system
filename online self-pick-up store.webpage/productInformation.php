<?php
include "conn.php";
session_start();
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $id = null;
}

$itemsPerPage = 10;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page <= 0) $page = 1;  

$start_time = microtime(true);

$sql = "SELECT COUNT(*) AS total FROM product";
$result = $conn->query($sql);
$totalItems = $result->fetch_assoc()['total'];
$totalPages = ceil($totalItems / $itemsPerPage);

$offset = ($page - 1) * $itemsPerPage;

$sql = "SELECT pid, p_name, price, total_storage, picture FROM product LIMIT $itemsPerPage OFFSET $offset";
$result = $conn->query($sql);

$end_time = microtime(true);
$execution_time = $end_time - $start_time;

if ($result->num_rows > 0) {
    $products = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $products = [];
}

//delete successfully
$showSuccessMessage = false;
if (isset($_GET['success']) && $_GET['success'] == 1) {
    $showSuccessMessage = true;
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
        .product-image {
            max-width: 80px;
            height: auto;
            display: block;
            margin: auto;
        }
        .edit-mode td input {
            width: calc(100% - 20px);
            padding: 5px;
        }

        .product-and-form-container {
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
    <?php
        include "conn.php";
        $type = "";
        if (isset($_GET['type']))  $type = $_GET['type'];
        else $type = "employee";
    ?>
    <header>
        <nav>
            <h1>Product Detail List</h1>
            <ul class="nav-links">
                <li><a href="B_Personal Information.php?id=<?php echo $id; ?>&type=<?php echo $type?>">Me</a></li>
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
                        <?php if ($type === "employee") { ?>
                            <button><a href="viewStore_employee.php?id=<?php echo $id; ?>&type=<?php echo $type?>">View Store Inventory</a></button>
                            <button><a href="soldProduct.php?id=<?php echo $id; ?>&type=<?php echo $type?>">View Pickup Order</a></button>
                            <button><a href="productInformation.php?id=<?php echo $id; ?>&type=<?php echo $type?>">Product Information</a></button> 
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
                    <div class="product-and-form-container">
                        <!-- 商品列表 -->
                        <div class="product-price-list-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Product ID</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Total Storage</th>
                                    <th>Product Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td class="product-id"><?php echo htmlspecialchars($product['pid']); ?></td>
                                        <td class="product-name"><?php echo htmlspecialchars($product['p_name']); ?></td>
                                        <td class="price"><?php echo htmlspecialchars($product['price']); ?></td>
                                        <td class="total-storage"><?php echo htmlspecialchars($product['total_storage']); ?></td>
                                        <td>
                                            <?php if ($product['picture']): ?>
                                                <img src="show_image.php?pid=<?php echo $product['pid']; ?>" alt="<?php echo htmlspecialchars($product['p_name']); ?>" class="product-image">
                                            <?php else: ?>
                                                <p>No Image Available</p>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <button class="edit-button" data-id="<?php echo htmlspecialchars($product['pid']); ?>">Edit</button>
                                            <button class="delete-button" data-id="<?php echo htmlspecialchars($product['pid']); ?>">Delete</button>
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
                                    echo '<a href="?page=1&id='. $id.'&type='.$type.'">&laquo; First</a>';
                                    echo '<a href="?page=' . ($page - 1) . '&id='. $id.'&type='.$type.'">Previous</a>';
                                }

                                for ($i = $rangeStart; $i <= $rangeEnd; $i++) {
                                    echo '<a href="?page=' . $i . '&id='. $id.'&type='.$type.'" class="' . ($i == $page ? 'active' : '') . '">' . $i . '</a>';
                                }

                                if ($page < $totalPages) {
                                    echo '<a href="?page=' . ($page + 1) . '&id='. $id.'&type='.$type.'">Next</a>';
                                    echo '<a href="?page=' . $totalPages . '&id='. $id.'&type='.$type.'">Last &raquo;</a>';
                                }
                            ?>
                        </div>
                        </div>
                        <div class="modify">
                            <div class="addform">
                                <h3>Add New Product</h3>
                                <form id="add-product-form" action="add_product.php" method="POST" enctype="multipart/form-data">
                                    <label for="p_name">Product Name</label>
                                    <input type="text" id="p_name" name="p_name" required>

                                    <label for="price">Price</label>
                                    <input type="number" id="price" name="price" required>

                                    <label for="total_storage">Total Storage</label>
                                    <input type="number" id="total_storage" name="total_storage" required>

                                    <label for="picture">Product Image</label>
                                    <input type="file" id="picture" name="picture" accept="image/*">

                                    <button type="submit">Add Product</button>
                                </form>
                                <?php echo "<p>Execution time is:  $execution_time</p>"; ?>
                            </div>
                            <div id="edit-form-container" class="form-container" style="display: none;">
                            </div>
                            <div id="successMessage" style="display:none; color: green; font-weight: bold; margin-bottom: 20px;">
                                Product deleted successfully!
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
    document.querySelectorAll('.edit-button').forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.getAttribute('data-id');
            const productRow = this.closest('tr');
            const productName = productRow.querySelector('.product-name').innerText;
            const productPrice = productRow.querySelector('.price').innerText;
            const productStorage = productRow.querySelector('.total-storage').innerText;
            const currentPicture = productRow.querySelector('img') ? productRow.querySelector('img').src : '';

            document.getElementById('successMessage').style.display = 'none';

            const formHTML = `
                <h3>Edit Product</h3>
                <form id="edit-form" action="edit_product.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="pid" value="${productId}">
                    <label for="p_name">Product Name</label>
                    <input type="text" id="p_name" name="p_name" value="${productName}" required>
                    <label for="price">Price</label>
                    <input type="number" id="price" name="price" value="${productPrice}" required>
                    <label for="total_storage">Total Storage</label>
                    <input type="number" id="total_storage" name="total_storage" value="${productStorage}" required>
                    <label for="picture">Product Image</label>
                    <input type="file" id="picture" name="picture" accept="image/*">
                    <p>Current Image:</p>
                    ${currentPicture ? `<img src="${currentPicture}" alt="Current Product Image" style="max-width: 100px; height: auto;">` : '<p>No current image available.</p>'}
                    <button type="submit">Save Changes</button>
                </form>
            `;

            document.getElementById('edit-form-container').innerHTML = formHTML;
            document.getElementById('edit-form-container').style.display = 'block';
        });
    });


    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.getAttribute('data-id');

            window.location.href = `delete_product.php?pid=${productId}`;
        });
    });

    <?php if ($showSuccessMessage): ?>
        document.getElementById('successMessage').style.display = 'block';
    <?php endif; ?>
    </script>
</body>
</html>
