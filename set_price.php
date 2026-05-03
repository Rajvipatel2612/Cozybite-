<?php
include '../db.php';

$order_id = $_POST['order_id'];
$price = $_POST['price'];

$advance = $price / 2;
$remaining = $price / 2;

mysqli_query($conn,"UPDATE custom_orders SET
price='$price',
advance_amount='$advance',
remaining_amount='$remaining',
status='confirmed',
payment_status='pending'
WHERE id='$order_id'");

header("Location: custome.php");
?>