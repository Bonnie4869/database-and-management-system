<?php
include "conn.php";
session_start();
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $_SESSION['user_id'] = $user_id;
    //echo "User ID: " . $user_id;  // Display the user ID for validation
} else {
    // echo "No user ID provided.";
    $user_id = null; // If no user_id is passed, set it to null.
}
//test

echo "<script>const userId = " . json_encode($user_id) . ";</script>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Store</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .container {
            display: flex;
            width: 100%;
        }
        
        .sidebar {
            width: 200px;
            padding: 10px;
        }
        
        .sidebar ul {
            list-style-type: none;
        }
        
        .sidebar ul li {
            margin: 10px 0;
        }
        
        .sidebar ul li a {
            color: black;
            text-decoration: none;
            font-size: 18px;
        }
        
        .main-content {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding: 20px;
            background-color: white;
            border: 1px solid #000;
            margin-left: 20px;
            justify-content: flex-start;
        }
        .store{
            width:200px;
            height:200px;
            border: 1px solid #000;
            text-align: center;
            margin:20px;
            cursor: pointer;
        }
        .upper-part {
            background-color: black;
            color: white;
            text-align: center;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .lower-part {
            background-color: white;
            flex: 1.5;
            text-align: center;
        }
        .store-box {
            width: 200px;
            height: 150px;
            border: 1px solid #000;
            display: flex;
            flex-direction: column;
        }
        .id_box{
            width: 200px;
            height: 100px;
            border: 1px solid #000;
        }
        .name_box{
            width: 200px;
            height: 100px;
            border: 1px solid #000;
        }
        .store-image {
    width: 150px;
    height: 150px;
    object-fit: cover;
}
    </style>
</head>
<body>
    <?php 
    include "conn.php";

    function getStoreImage($sid) {
        global $conn;
        $sql = "SELECT image FROM store WHERE sid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $sid);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($picture);
        $stmt->fetch();

        if ($picture) {
            return $picture;
        } else {
            return null;
        }
    }
    ?>
<header>
        <nav>
            <h1>Select Store</h1>
            <ul class="nav-links">
            <li><a href="shoppingCart.php?user_id=<?php echo $user_id; ?>">Shopping Cart</a></li>
            <li><a href="C_Personal Information.php?user_id=<?php echo $user_id; ?>">Me</a></li>
            <li><a href="Homepage.php?user_id=<?php echo $user_id; ?>">Back to Select Store</a></li>
            <li><a href="customer_login.php">Log Out</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="container">
            <div class="sidebar">
                <ul>
                    <li>
                        <div class="store-box">
                            <div class="upper-part">current store</div>
                            <div class="lower-part" id="current-store">001<br>store1</div>
                        </div>
                    </li>
                    <li>
                        <button id="enter-store-btn" onclick="enterStore()">click to get into the store</button>
                    </li>
                    <li>
                        <div class="id_box">
                            <label for="id">Store ID:</label><br>
                            <input type="text" id="id" name="id"><br>
                            <button onclick="searchById()">Search</button>
                        </div>
                    </li>
                    <li>
                        <div class="name_box">
                            <label for="name">Store name:</label><br>
                            <input type="text" id="name" name="name"><br>
                            <button onclick="searchByName()">Search</button>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="main-content">
                <?php
                $start_time = microtime(true);

                $sql = "SELECT sid, s_name FROM store LIMIT 10"; // Limit to 10 stores
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $storeImage = getStoreImage($row['sid']);
                        echo "<div class='store' data-id='{$row['sid']}' onclick='selectStore(this)'>
                                {$row['sid']}<br>{$row['s_name']}<br>";
                        if ($storeImage) {
                            echo "<img src='data:image/png;base64," . base64_encode($storeImage) . "' alt='" . htmlspecialchars($row['s_name']) . "' class='store-image'>";
                        } else {
                            echo "<p>No Image Available</p>";
                        }
                        echo "</div>";
                    }
                }
                $end_time = microtime(true);
                $execution_time = $end_time - $start_time;
                echo "<p>Execution time is:  $execution_time</p>";
                ?>
            </div>
        </div>
    </main>
    <footer>
        <p>&copy; Group 05 DBMS Project. All rights reserved.</p>
    </footer>

    <script>
        let selectedStoreId = null;

        function selectStore(store) {
            // Remove blue border from all stores
            const stores = document.querySelectorAll('.store');
            stores.forEach(s => s.style.borderColor = '#000');

            // Add blue border to the selected store
            store.style.borderColor = 'blue';

            // Extract store ID and name
            selectedStoreId = store.getAttribute('data-id');
            const storeText = store.innerText.split('\n');
            const storeName = storeText[1].trim();

            // Update current store display
            document.getElementById('current-store').innerText = `${selectedStoreId}\n${storeName}`;
        }

        function searchById() {
            const storeId = document.getElementById('id').value;
            selectedStoreId = storeId;
            // Update current store display with the entered ID
            document.getElementById('current-store').innerText = `${storeId}\n`;
        }

        function searchByName() {
            const storeName = document.getElementById('name').value;
            // Update current store display with the entered name
            const currentStore = document.getElementById('current-store');
            const currentText = currentStore.innerText;
            const storeId = currentText.split('\n')[0]; // Extract existing ID
            document.getElementById('current-store').innerText = `${storeId}\n${storeName}`;
        }

        function enterStore() {
            if (selectedStoreId) {
                // Redirect to pageProduct.php with the selected store ID
                window.location.href = `pageProduct.php?store_id=${selectedStoreId}&user_id=`+ userId;
            } else {
                alert("Please select a store first.");
            }
        }
    </script>
</body>
</html>
