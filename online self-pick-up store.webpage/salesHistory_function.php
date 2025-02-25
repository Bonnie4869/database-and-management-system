<?php

    include "conn.php";

    $sql = "SELECT oid, pickup_id, id, user_name, order_time, pickup_time 
    FROM `buy_from` JOIN `orders` USING (`oid`) JOIN `customer` USING (`id`)";
    $result = $conn -> query($sql);
    $response = [];

    if ($result && $result->num_rows > 0) {
        $customers = [];
        $uniqueKeys = [];
        while ($row = $result->fetch_assoc()) {
            $key = $row['oid']. '-' . $row['pickup_id']. '-' . $row['id'];
            if (!isset($uniqueKeys[$key])) {
                $uniqueKeys[$key] = true;
                $customers[] = $row;
            }
        }
        $response['status'] = 'success';
        $response['data'] = $customers;
    } else {
        $response['status'] = 'error';
        $response['message'] = 'No records found or query failed.';
    }

    header('Content-Type: application/json');
    echo json_encode($response);

    $conn->close();

?>