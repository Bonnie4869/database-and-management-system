<?php
include "conn.php";

$login_success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = isset($_POST["username"]) ? $_POST["username"] : '';
    $input_password = isset($_POST["psw"]) ? $_POST["psw"] : '';

    $sql = "SELECT * FROM customer WHERE user_name = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("s", $user_name);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $customer_id = $row['id']; 
        $db_password = $row['pwd']; 
        //test
        //$login_success = true;
        if ($input_password == $db_password) {
            $login_success = true;
        } else {
            echo "Password does not match. Please try again.";
        }
    } else {
        echo "Wrong!";
    }

    $stmt->close();
}
$conn->close();

if ($login_success) {
    $user_id = $customer_id; 
    header("Location: Homepage.php?id=" . $user_id);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login/Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <h1>User Login/Registration</h1>
        </nav>
    </header>
    <main>
        <section id="Login">
            <h2>Login</h2>
            <form action="customer_login.php" method="POST" >
                <ul>
                    <li>
                        <label for="username">Enter username:</label><br>
                        <input type="text" id="username" name="username" required><br>
                    </li>
                    <li>
                        <label for="password">Enter password:</label><br>
                        <input type="password" id="password" name="psw" required><br>
                    </li>
                    <li>
                        <input type="submit" value="Login"><br>
                    </li>
                </ul>
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; Group 05 DBMS Project. All rights reserved.</p>
    </footer>
</body>
</html>