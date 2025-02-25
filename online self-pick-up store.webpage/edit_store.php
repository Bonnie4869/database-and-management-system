<?php
include('conn.php');

// Check if the form is being submitted and the 'id' is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $storeId = $_POST['store_id'];
    $sName = $_POST['s_name'];
    $stHour = $_POST['st_hour'];
    $edHour = $_POST['ed_hour'];
    $sMoney = $_POST['s_money'];
    $address = $_POST['address'];
    $contactPhone = $_POST['contact_phone'];

    // Process image upload (if any)
    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        // If new image is uploaded, store it in the database
        $image = file_get_contents($_FILES['image']['tmp_name']);
    }

    // SQL Update Query
    $sql = "UPDATE store SET s_name = ?, st_hour = ?, ed_hour = ?, s_money = ?, address = ?, contact_phone = ?, image = ? WHERE sid = ?";
    
    // Prepare statement and bind parameters
    $stmt = $conn->prepare($sql);
    if ($image) {
        // If a new image is uploaded, bind the image
        $stmt->bind_param("sssssssi", $sName, $stHour, $edHour, $sMoney, $address, $contactPhone, $image, $storeId);
    } else {
        // If no new image, keep the current image in the database
        $stmt->bind_param("sssssssi", $sName, $stHour, $edHour, $sMoney, $address, $contactPhone, NULL, $storeId);
    }

    // Execute the query
    if ($stmt->execute()) {
        // Redirect to the store information page after successful update
        header("Location: storeInformation.php?");
        exit;
    } else {
        echo "Error updating store: " . $stmt->error;
    }

    $stmt->close();
} else if (isset($_GET['id'])) {
    // If it's a GET request, load the existing store data for editing
    $storeId = $_GET['id'];
    
    // SQL Query to fetch store data
    $sql = "SELECT * FROM store WHERE sid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $storeId);
    $stmt->execute();
    $result = $stmt->get_result();
    $store = $result->fetch_assoc();

    $stmt->close();
}

?>