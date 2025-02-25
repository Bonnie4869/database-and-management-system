<?php
// header('Content-Type: application/json');

include "conn.php"; 
$start_time = microtime(true);

$sid = $_POST['sid'] ?? '';

$sql = "SELECT * FROM buy_from 
        JOIN orders USING (oid) 
        JOIN person USING (id) 
        JOIN store USING (sid) 
        WHERE sid = '$sid'";

$result = mysqli_query($conn, $sql);

if (!$result) {
    echo json_encode(["success" => false, "message" => "数据库查询失败。"]);
    exit;
}

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = [
        'store_name' => $row['s_name'],
        'pickup_id' => $row['pickup_id'],
        'oid' => $row['oid'],
        'buyer_name' => $row['first_name'] . " " . $row['last_name'],
        'bid' => $row['id'],
        'order_time' => $row['order_time'],
        'pickup_time' => $row['pickup_time'],
    ];
}
$end_time = microtime(true);
$execution_time = $end_time - $start_time;
echo json_encode(["success" => true, "data" => $data, "execution_time" => $execution_time]);

mysqli_close($conn);

?>
