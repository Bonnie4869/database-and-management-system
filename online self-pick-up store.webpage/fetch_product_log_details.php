<?php
// header('Content-Type: application/json');

include "conn.php";

$index = $_POST['productSearch'] ?? '';
$sType = $_POST['searchType'] ?? '';
$start_time = microtime(true);
if($sType == 1)
{ 
    $sql = "SELECT * FROM buy_from 
        JOIN orders USING (oid) 
        JOIN store USING (sid) 
        JOIN product USING (pid)
        WHERE pid = '$index'";
}else 
{
    $sql = "SELECT * FROM buy_from 
        JOIN orders USING (oid) 
        JOIN store USING (sid) 
        JOIN product USING (pid)
        WHERE sid = '$index'";
}
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo json_encode(["success" => false, "message" => "数据库查询失败。"]);
    exit;
}
// pid, p_name, b_quantity, s_name, order_time
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = [
        'pid' => $row['pid'],
        'p_name' => $row['p_name'],
        'quantity' => $row['b_quantity'],
        'store_name' => $row['s_name'],
        'order_time' => $row['order_time'],
    ];
}

$end_time = microtime(true);
$execution_time = $end_time - $start_time;
// echo json_encode($data, JSON_PRETTY_PRINT);

// header('Content-Type: application/json');
echo json_encode(["success" => true, "data" => $data, "execution_time" => $execution_time]);

mysqli_close($conn);

?>
