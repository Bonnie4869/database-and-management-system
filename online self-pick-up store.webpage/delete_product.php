<?php
include('conn.php');

if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];

    $sql = "DELETE FROM product WHERE pid = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $pid);
        if ($stmt->execute()) {
            header("Location: productInformation.php?success=1"); 
            exit;
        } else {
            echo "Error deleting product: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing the statement: " . $conn->error;
    }
} else {
    echo "Product ID not provided.";
}

$conn->close();
?>
