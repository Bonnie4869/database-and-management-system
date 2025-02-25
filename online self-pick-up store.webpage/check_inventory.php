<?php
header('Content-Type: application/json');
include "conn.php"; 

date_default_timezone_set('Asia/Shanghai'); 

$data = json_decode(file_get_contents('php://input'), true);

$user_id = $data['user_id'];
$cartItems = $data['cartItems'];

$response = array(
    "success" => true,
    "messages" => [],
    "errors" => [],
    "redirect_url" => "" 
);

$conn->begin_transaction();

try {
    $order_time = date("Y-m-d H:i:s"); 
    $pickup_time = null;  

    $result = $conn->query("SELECT MAX(oid) FROM orders");
    $row = $result->fetch_assoc();
    $oid = $row['MAX(oid)'] + 1;  

    $pickup_id = strtotime($order_time);  

    $query = "SELECT c_money FROM customer WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($c_money); 
    $stmt->fetch();
    $stmt->close();

    if ($c_money === null) {
        $response['success'] = false;
        $response['errors'][] = ["message" => "User not found."];
        echo json_encode($response);
        exit;
    }

    $total_amount = 0;
    foreach ($cartItems as $item) {
        $total_amount += $item['price'] * $item['quantity'];
    }

    if ($total_amount > $c_money) {
        $response['success'] = false;
        $response['errors'][] = [
            "message" => "Insufficient funds. You need $" . number_format($total_amount - $c_money, 2) . " more."
        ];
        echo json_encode($response);
        exit;  
    }

    foreach ($cartItems as $item) {
        $product_id = $item['pid'];
        $store_id = $item['sid'];
        $quantity = $item['quantity'];
        $pname = $item['p_name'];
        $sname = $item['s_name'];

        $query = "SELECT * FROM store_product JOIN store USING(sid) JOIN product USING(pid) WHERE pid = ? AND sid = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $product_id, $store_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            $response['success'] = false;
            $response['errors'][] = [
                "product_id" => $product_id,
                "store_id" => $store_id,
                "message" => "Product: $pname not available in store: $sname."
            ];
        } else {
            $product = $result->fetch_assoc();
            $stock_quantity = $product['s_quantity'];  

            if ($stock_quantity < $quantity) {
                $response['success'] = false;
                $response['errors'][] = [
                    "product_id" => $product_id,
                    "store_id" => $store_id,
                    "message" => "{$pname} is out of stock in {$sname}."
                ];
            }
        }
    }

    if ($response['success']) {
        $new_balance = $c_money - $total_amount; 
        $updateBalance = $conn->prepare("UPDATE customer SET c_money = ? WHERE id = ?");
        $updateBalance->bind_param("di", $new_balance, $user_id);
        $updateBalance->execute();

        $insertOrder = $conn->prepare("INSERT INTO orders (oid, pickup_id, pickup_time, order_time, id) VALUES (?, ?, ?, ?, ?)");
        $insertOrder->bind_param("iisss", $oid, $pickup_id, $pickup_time, $order_time, $user_id);
        $insertOrder->execute();

        foreach ($cartItems as $item) {
            $product_id = $item['pid'];
            $store_id = $item['sid'];
            $quantity = $item['quantity'];
            $money = $item['price'] * $item['quantity'];

            //delete from cart
            $updateCart = $conn->prepare("DELETE FROM store_cart WHERE id = ? AND pid = ? AND sid = ?");
            $updateCart ->bind_param("iii", $user_id, $product_id, $store_id);
            $updateCart ->execute();

            $updateStock = $conn->prepare("UPDATE store_product SET s_quantity = s_quantity - ? WHERE pid = ? AND sid = ?");
            $updateStock->bind_param("iii", $quantity, $product_id, $store_id);
            $updateStock->execute();

            $insertBuyFrom = $conn->prepare("INSERT INTO buy_from (oid, pid, sid, b_quantity) VALUES (?, ?, ?, ?)");
            $insertBuyFrom->bind_param("iiis", $oid, $product_id, $store_id, $quantity);
            $insertBuyFrom->execute();

            //update store money
            $updateMoney = $conn->prepare("UPDATE store SET s_money = s_money + ? WHERE sid = ?");
            $updateMoney->bind_param("ii", $money, $store_id);
            $updateMoney->execute();
        }

        $conn->commit();

        $response['messages'][] = "Order successfully placed!";
        // Set the redirect URL with both user_id and oid
        $response['redirect_url'] = "paymentCompletedPage.php?user_id=" . urlencode($user_id) . "&oid=" . urlencode($oid); // Correctly pass user_id and oid

    } else {
        $conn->rollback();
    }

} catch (Exception $e) {
    $conn->rollback();
    $response['success'] = false;
    $response['messages'][] = "Error occurred: " . $e->getMessage();
}


echo json_encode($response);
?>
