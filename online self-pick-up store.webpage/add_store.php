<?php
include('conn.php');
// Assuming you have a valid database connection $conn
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $sName = $_POST['s_name'];
    $stHour = $_POST['st_hour'];
    $edHour = $_POST['ed_hour'];
    $sMoney = $_POST['s_money'];
    $address = $_POST['address'];
    $contactPhone = $_POST['contact_phone'];

    // Process image upload (if any)
    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = file_get_contents($_FILES['image']['tmp_name']);
    }

    // SQL Insert Query
    $sql = "INSERT INTO store (s_name, st_hour, ed_hour, s_money, address, contact_phone, image) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $sName, $stHour, $edHour, $sMoney, $address, $contactPhone, $image);

    if ($stmt->execute()) {
        $last_inserted_id = $conn->insert_id;

        // Redirect to the product list page with a success message
        header("Location: storeInformation.php?id=" . $last_inserted_id);
    } else {
        echo "Error adding store: " . $stmt->error;
    }

    $stmt->close();
}
?>
