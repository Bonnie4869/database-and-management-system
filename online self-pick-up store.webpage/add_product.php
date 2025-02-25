<?php
include('conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $p_name = $_POST['p_name'];
    $price = $_POST['price'];
    $total_storage = $_POST['total_storage'];

    // Handle image upload
    $pictureData = null;  
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
        $pictureData = file_get_contents($_FILES['picture']['tmp_name']);
    }

    // Insert the new product into the database
    $sql = "INSERT INTO product (p_name, price, total_storage, picture) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Bind the parameters
    $stmt->bind_param("sdss", $p_name, $price, $total_storage, $pictureData);

    // Execute the statement
    if ($stmt->execute()) {
        // Get the last inserted product ID
        $last_inserted_id = $conn->insert_id;

        // Redirect to the product list page with a success message
        header("Location: productInformation.php?success=1&id=" . $last_inserted_id);
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
