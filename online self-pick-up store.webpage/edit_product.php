<?php
include('conn.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pid = $_POST['pid'];
    $p_name = $_POST['p_name'];
    $price = $_POST['price'];
    $total_storage = $_POST['total_storage'];
    $picture = $_FILES['picture']; 

    $pictureData = null; 
    $isPictureUploaded = false; 

    if ($picture['error'] === UPLOAD_ERR_OK) {
        $pictureData = file_get_contents($picture['tmp_name']);
        $isPictureUploaded = true; 
    }

    $sql = "UPDATE product SET p_name = ?, price = ?, total_storage = ?";
    if ($isPictureUploaded) {
        $sql .= ", picture = ?";
    } else {
        $sql .= ", picture = NULL";
    }
    $sql .= " WHERE pid = ?";

    if ($stmt = $conn->prepare($sql)) {
        if ($isPictureUploaded) {
            $stmt->bind_param('sdssi', $p_name, $price, $total_storage, $pictureData, $pid);
        } else {
            $stmt->bind_param('sdsi', $p_name, $price, $total_storage, $pid);
        }

        if ($stmt->execute()) {
            echo "Product updated successfully!";
            header('Location: productInformation.php'); 
            exit;
        } else {
            echo "Error updating product: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}
?>
