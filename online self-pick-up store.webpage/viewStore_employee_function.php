<?php

    include "conn.php";

    $id = isset($_POST['id']) ? $_POST['id'] : '';
    // $id = isset($_GET['id']) ? $_GET['id'] : '';
    $product = isset($_POST['product']) ? $_POST['product'] : '';
    $productType = isset($_POST['productType']) ? $_POST['productType'] : '';

    if (empty($id)) {
        echo json_encode(['status' => 'error', 'message' => 'ID is required']);
        exit;
    }

    $sql = "SELECT sid, s_name FROM store JOIN employee USING (sid) WHERE id = $id";
    $result = $conn -> query($sql);
    $sid = "";
    $s_name = "";
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $sid = $row['sid'];
            $s_name = $row['s_name'];
        }
    }

    $sql = "SELECT pid, p_name, s_quantity, price, picture FROM store_product JOIN product USING (pid)";
    $condition = " WHERE sid = $sid";
    if (!empty($product)) {
        if ($productType === "id") $condition .= " AND pid = $product";
        else $condition .= " AND p_name = '$product'";
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

    $response['sid'] = $sid;
    $response['s_name'] = $s_name;

    header('Content-Type: application/json');
    echo json_encode($response);

    $conn->close();

?>