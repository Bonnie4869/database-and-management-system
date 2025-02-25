<?php

    include "conn.php";

    $store = isset($_POST['store']) ? $_POST['store'] : '';
    $storeType = isset($_POST['storeType']) ? $_POST['storeType'] : '';
    $product = isset($_POST['product']) ? $_POST['product'] : '';
    $productType = isset($_POST['productType']) ? $_POST['productType'] : '';

    $sql = "SELECT pid, p_name, s_quantity, price, image FROM store_product JOIN product USING (pid) JOIN store USING (sid)";
    $condition = "";
    if ($store != "") {
        if ($storeType === "id") $condition = " WHERE sid = " . $store;
        else $condition = " WHERE s_name = '" . $store . "'";
    }
    if ($product !== "") {
        if ($productType === "id") $condition .= " AND pid = " . $product;
        else $condition .= " AND p_name = '" . $product . "'";
    }
    $sql .= $condition;
    $result = $conn -> query($sql);

    $response = [];

    if ($result && $result->num_rows > 0) {
        $customers = [];
        $uniqueKeys = [];
        while ($row = $result->fetch_assoc()) {
            $key = $row['pid'];
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
    if ($storeType === "id") {
        $sql = "SELECT s_name FROM store WHERE sid = " . $store;
        $result = $conn -> query($sql);
        $customers = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $customers[] = $row;
            }
            $response['name'] = $customers;
        }
    }

    header('Content-Type: application/json');
    echo json_encode($response);

    $conn->close();

?>