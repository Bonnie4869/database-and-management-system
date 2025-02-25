<?php
include "conn.php";

// Get the POST data (JSON)
$data = json_decode(file_get_contents('php://input'), true);

// Extract user_id, sid, and pid from the data
$user_id = $conn->real_escape_string($data['user_id']);
$sid = $conn->real_escape_string($data['sid']);
$pid = $conn->real_escape_string($data['pid']);

// Prepare the SQL query to delete the cart item
$sql = "DELETE FROM store_cart WHERE id = '$user_id' AND sid = '$sid' AND pid = '$pid'";

// Execute the query
if ($conn->query($sql) === TRUE) {
    // Successfully deleted
    echo json_encode(['success' => true]);
} else {
    // Failed to delete
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

// Close the database connection
$conn->close();
?>
