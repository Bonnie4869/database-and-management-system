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
                include "conn.php";
                $start_time = microtime(true);
                // $sid = isset($_POST['store_id']);
                $sid = $_POST['sid'] ?? '';
                $id = $_POST['id'] ?? '';
                $pid = $_POST['pid'] ?? '';
                $p_name = $_POST['p_name'] ?? '';
                $s_name = $_POST['s_name'] ?? '';
                $sql = "SELECT s_name FROM store WHERE sid = $sid";
                $result = mysqli_query($conn, $sql);
                if ($row = mysqli_fetch_row($result)) {
                    $s_name = $row[0]; 
                    echo"<h1>" . $s_name . " purchase details page</h1>";
                } 
                // echo"in: *$sid*|*$id*|*$pid*|*$p_name*|*$s_name*|\n";
            ?>  
                <ul class="nav-links">
                <li><a href="shoppingCart.php?user_id=<?php echo $user_id; ?>">Shopping Cart</a></li>
                <li><a href="C_Pesonal Information.php?user_id=<?php echo $user_id; ?>">Me</a></li>
                <li><a href="Homepage.php?user_id=<?php echo $user_id; ?>">Back to Select Store</a></li>
                <li><a href="customer_login.php">Log Out</a></li>
                </ul>
            <?php
                echo "</nav></header>";
                echo "<main><div class=\"con\">";
                echo "<ul>";
                $sql = "INSERT INTO store_cart (id, pid, sid) VALUES ($id, $pid, $sid)";
                try {
                    if (mysqli_query($conn, $sql)) {
                        echo "<il><p>Thank you! You have successfully added <b>$p_name</b> from <b>$s_name</b> store to your shopping cart.</p></il>";
                    }
                } catch (mysqli_sql_exception $e) {
                    if ($e->getCode() == 1062) { // 1062 indicates a duplicate primary key error
                        echo "<p>Sorry! The product <b>$p_name</b> from store <b>$s_name</b> is already in your shopping cart.</p></il>";
                    } else {
                        echo "<p>Something went wrong: " . $e->getMessage() . "</p>";
                    }
                }
                $end_time = microtime(true);
                $execution_time = $end_time - $start_time;
                // mysqli_query($conn, $sql);
                
                $url = "pageProduct.php?store_id=$sid&user_id=$id";

                echo "<ul>";
                echo "<li>";
                echo "<a href='$url' style='display: block; text-align: center; margin-top: 10px;' >Back to the Product Page</a>";
                echo "</li>";
                echo "</ul>";
            ?>
        </div>

    <footer>
        <?php echo "<p>Execution time is:  $execution_time</p>"; ?>
        <p>&copy; Group 05 DBMS Project. All rights reserved.</p>
    </footer>
</body>
</html>
