<?php
include "conn.php";
session_start();

$login_success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = isset($_POST["userid"]) ? $_POST["userid"] : '';
    $input_password = isset($_POST["psw"]) ? $_POST["psw"] : '';

    $type = "";

    $sql = "SELECT * FROM person WHERE id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $user_id);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $employee_id = $row['id']; 
        $db_password = $row['password']; 
        if ($input_password === $db_password) {
            $login_success = true;
            $_SESSION['person_id'] = $employee_id; 
        } else {
            echo "Password does not match. Please try again.";
        }
    } else {
        echo "User ID does not exist. Please try again.";
    }

    $stmt->close();

    if (empty($type)) {
        $result = $conn->query("SELECT id FROM senior_manager WHERE id = $user_id");
        if ($result && $result->num_rows > 0) $type = "senior_manager";
    }
    if (empty($type)) {
        $result = $conn->query("SELECT id FROM manager WHERE id = $user_id");
        if ($result && $result->num_rows > 0) $type = "manager";
    }
    if (empty($type)) {
        $result = $conn->query("SELECT id FROM employee WHERE id = $user_id");
        if ($result && $result->num_rows > 0) $type = "employee";
    }

    if (empty($type)) {
        echo "This is not a staff account";
        $login_success = false;
    }
    else $_SESSION["type"] = $type;
    echo $type;
    //$_SESSION['id'] = $user_id;
}
$conn->close();
session_write_close();
if ($login_success) {
    header("Location: B_Personal Information.php?id=" . $_SESSION['person_id']);
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
            <h1>User Login</h1>
        </nav>
    </header>
    <main>
        <section id="Login">
            <h2>Login</h2>
            <form action="seller_login.php" method="POST" onsubmit="return validatePassword()">
                <ul>
                    <li>
                        <label for="userid">Enter id:</label><br>
                        <input type="text" id="userid" name="userid" required><br>
                    </li>
                    <li>
                        <label for="password">Enter password:</label><br>
                        <input type="password" id="password" name="psw" required><br>
                    </li>
                    <li>
                        <label for="confirm_password">Confirm password:</label><br>
                        <input type="password" id="confirm_password" name="Confirm" required><br>
                    </li>
                    <!-- <li>
                        <label for="select">Position:</label><br>
                        <select name="select" id="select">
                            <option value="manager">Manager</option>
                            <option value="employee">Employee</option>
                            <option value="senior_manager">Senior Manager</option>
                        </select>
                    </li> -->
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