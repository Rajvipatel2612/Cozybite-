<?php
session_start();
include 'db.php';

$order_id = isset($_POST['order_id']) ? $_POST['order_id'] : 0;
$amount = isset($_POST['amount']) ? $_POST['amount'] : 0;
$method = isset($_POST['method']) ? $_POST['method'] : 'Online';

mysqli_query($conn,"UPDATE custom_orders 
SET payment_status='advance_paid',
advance_amount='$amount'
WHERE id='$order_id'");

mysqli_query($conn,"INSERT INTO payments
(order_id,order_type,payment_method,payment_status,amount,payment_date)
VALUES
('$order_id','custom','$method','Advance Paid','$amount',NOW())");

header("Location: receipt_custom.php?id=".$order_id);
exit();
?>