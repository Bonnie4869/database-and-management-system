<?php
include "conn.php";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_name = $_POST["username"];
    $c_money = 500000.00;
    $pwd = $_POST["psw"]; 
    $confirm_pwd = $_POST["confirm"];

    if ($pwd !== $confirm_pwd) {
        echo "Warning: Passwords do not match. Please try again.";
    } else {
        $check_sql = "SELECT * FROM customer WHERE user_name = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $user_name);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            echo "Warning: Username already exists. Please choose a different username.";
        } else {
            $sql = "INSERT INTO customer (c_money, user_name, pwd) VALUES (?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("dss", $c_money, $user_name, $pwd);

            if ($stmt->execute()) {
                $last_inserted_id = $conn->insert_id;
                header("Location: customer_login.php?id=" . $last_inserted_id);
                exit;
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        }

        $check_stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login/Registration</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function validatePassword(){
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm_password").value;
            if (password != confirmPassword) {
                alert("Passwords do not match. Please try again.");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <header>
        <nav>
            <h1>User Login/Registration</h1>
        </nav>
    </header>
    <main>
        <section id="Registration">
            <h2>Registration</h2>
            <form action="customer_registration.php" method="post" onsubmit="return validatePassword()">
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
                        <label for="confirm_password">Confirm password:</label><br>
                        <input type="password" id="confirm_password" name="confirm" required><br>
                    </li>
                    <li>
                        <input type="submit" value="Submit"><br>
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