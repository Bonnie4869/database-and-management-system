<!DOCTYPE html>
<html lang="en">
<style>
    body{
        background-attachment: fixed;
        background-color: rgba(0,0,0,.5);
    }
    button.no {
    display: inline-block;
    padding: 15px 25px;
    font-size: 24px;
    cursor: pointer;
    text-align: center;
    text-decoration: none;
    outline: none;
    color: #3e3a3a;
    background-color: rgb(166, 189, 185);
    border: none;
    border-radius: 15px;
    box-shadow: 0 5px #999;
}

button.yes {
    display: inline-block;
    padding: 15px 25px;
    font-size: 24px;
    cursor: pointer;
    text-align: center;
    text-decoration: none;
    outline: none;
    color: #fff;
    background-color: rgb(16, 185, 214);
    border: none;
    border-radius: 15px;
    box-shadow: 0 9px #999;
}

.yes:hover {
    background-color: #1795bb;
}
.con {
            display: flex;
            flex-wrap:wrap;
            flex-flow: row wrap;
            justify-content: center;
            align-items: center; 
}
.con > div {
    max-width: 600px;
    max-height: 600px;
    padding: 5%;
    background: hwb(203 82% 2%);
    border: 1px solid black;
    margin: 10px;
    text-align: center;
    line-height: 30px; 
    display: flex;
    justify-content: center;
    border-radius: 10px;
    background-color: rgba(176, 226, 255, 0.466);
}
        .product-image {
            max-width: 60%;
            height: auto;
            border-radius: 8px; 
        }
        .purchase-button:disabled, .cart-button:disabled {
            background-color: #aaa;
            cursor: not-allowed;
        }

.purchase-button, .cart-button {
    background-color: #007BFF;
    color: white;
    border: none;
    padding: 10px 20px;
    margin: 10px 5px;
    cursor: pointer;
    font-size: 16px;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.purchase-button:hover, .cart-button:hover {
    background-color: #0056b3;
}

.cart-button {
    background-color: #28a745;
}

.cart-button:hover {
    background-color: #218838;
}

</style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
            <?php   
                echo "<header><nav>";
                $start_time = microtime(true);
                include "conn.php";
                //$sid = isset($_POST['store_id']);
                $sid = $_GET['store_id'] ?? '1';
                $id = $_GET['user_id'] ?? '1';
                // echo"in: *$sid*|*$id*\n";
                $sql = "SELECT s_name FROM store WHERE sid = $sid";
                $result = mysqli_query($conn, $sql);
                if ($row = mysqli_fetch_row($result)) {
                    $s_name =$row[0]; 
                    echo"<h1>" . $s_name . " purchase details page</h1>";
                } 
                $user_id = $id;
            ?>       
                <ul class="nav-links">
                <li><a href="shoppingCart.php?user_id=<?php echo $user_id; ?>">Shopping Cart</a></li>
                <li><a href="C_Personal Information.php?user_id=<?php echo $user_id; ?>">Me</a></li>
                <li><a href="Homepage.php?user_id=<?php echo $user_id; ?>">Back to Select Store</a></li>
                <li><a href="customer_login.php">Log Out</a></li>
                </ul>
            <?php
                echo "</nav></header>";
                echo "<main><div class=\"con\">";
                $start_time = microtime(true);
            $sql = "SELECT * FROM store_product JOIN product USING (pid) WHERE sid = $sid";
            $result = mysqli_query($conn, $sql);

            $end_time = microtime(true);
            $execution_time = $end_time - $start_time;
            //echo "<p>Execution time is:  $execution_time</p>";

            while ($row = mysqli_fetch_array($result)) {
                $num = $row["s_quantity"];
                $tot_num = $row["total_storage"];
                $price = $row["price"];
                $name = $row["p_name"];
                $pid = $row["pid"];
                $pic = $row['picture'];

                if($num > 0) echo '<div style="order: 1">';
                else echo '<div style="order: 2">';
                if ($row['picture'])
                    echo "<ul><img src='show_image.php?pid=$pid' alt='".htmlspecialchars($name)."' class='product-image'><ul>";
                else echo "<ul><ul>";
                echo '<h2>' . $name .'</h2>';
                echo '<p> <b>Price:</b> $' . $price . ' </p>';
                echo '<p> <b>Number:</b> ' . $num . ' </p>';
                echo '<p> <b>Remaining quantity:</b> ' . $tot_num + $num  . '</p>';
                if($num > 0)
                {
                    // echo '<form action="orderCheckoutPage.php" method="POST" style="display: inline;">
                    // <input type="hidden" name="action" value="buy">
                    // <button class="purchase-button" id="purchaseButton" type="submit">Buy Now</button>
                    // </form>';
                    echo '<form action="add_to_Cart.php" method="POST" style="display: inline;">';
                    echo "<input type='hidden' name='sid' value='$sid'>
                        <input type='hidden' name='id' value='$id'>
                        <input type='hidden' name='pid' value='$pid'>
                        <input type='hidden' name='s_name' value='$s_name'>
                        <input type='hidden' name='p_name' value='$name'>";
                    echo '<button class="cart-button" id="cartButton" type="submit">Add to Cart</button>
                    </form>';
                }else
                {
                    // echo '<button class="purchase-button" disabled>Out of Stock</button>';
                    echo '<button class="cart-button" id="cartButton" disabled>Add to Cart</button>';
                }
                echo "</div>";
            }
            $end_time = microtime(true);
            $execution_time = $end_time - $start_time;
            // echo "<p>execution_time is:  $execution_time</p>"
                echo "</div></main>";
                echo "</div>
                <footer>
                    <p>Execution time is:  $execution_time</p>
                    <p>&copy; Group 05 DBMS Project. All rights reserved.</p>
                </footer>"
            ?>
</body>
</html>
