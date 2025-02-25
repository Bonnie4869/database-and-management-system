<?php
// Database connection 
include "conn.php";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
echo "search successfully"

$id = isset($_GET['id']) ? $_GET['id'] : '';
$name = isset($_GET['name']) ? $_GET['name'] : '';

// Query for searching customers
$sql = "SELECT * FROM customer JOIN person USING(id) WHERE id LIKE '%$id%' AND user_name LIKE '%$name%'";
$result = $conn->query($sql);

$customers = [];

if ($result->num_rows > 0) {
    // Output data for each row
    while($row = $result->fetch_assoc()) {
        $customers[] = $row;
    }
}

echo json_encode($customers);

$conn->close();
?>
