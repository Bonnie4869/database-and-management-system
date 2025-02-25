<?php
include('conn.php');

$pid = isset($_GET['pid']) ? (int) $_GET['pid'] : 0;

if ($pid > 0) {
    $sql = "SELECT picture FROM product WHERE pid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $pid);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($picture);
    $stmt->fetch();

    if ($picture) {
        header("Content-Type: image/png");
        echo $picture; 
    } else {
        header("HTTP/1.1 404 Not Found");
        echo "No image found";
    }

    $stmt->close();
} else {
    echo "Invalid product ID";
}
?>
