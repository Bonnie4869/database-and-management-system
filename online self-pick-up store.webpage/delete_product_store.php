<?php
include('conn.php');

if (isset($_GET['sid'])) {
    $sid = $_GET['sid'];

    $sql = "DELETE FROM store WHERE sid = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $sid);
        if ($stmt->execute()) {
            header("Location: storeInformation.php?success=1"); 
            exit;
        } else {
            echo "Error deleting store: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing the statement: " . $conn->error;
    }
} else {
    echo "Store ID not provided.";
}

$conn->close();
?>
