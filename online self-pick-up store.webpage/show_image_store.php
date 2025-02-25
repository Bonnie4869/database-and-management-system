<?php
include('conn.php');

$pid = isset($_GET['sid']) ? (int) $_GET['sid'] : 0;

if ($pid > 0) {
    $sql = "SELECT image FROM store WHERE sid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $pid);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($image);
    $stmt->fetch();

    if ($image) {
        header("Content-Type: image/png");//default png type
        echo $image;  
    } else {
        header("HTTP/1.1 404 Not Found");
        echo "No image found";
    }

    $stmt->close();
} else {
    echo "Invalid product ID";
}
?>
