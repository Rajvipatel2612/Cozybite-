<?php
session_start();
include '../db.php';

$id = $_GET['id'];

mysqli_query($conn,"UPDATE custom_orders 
SET status='Delivered',
payment_status='paid',
remaining_amount=0
WHERE id='$id'");

header("Location: dashboard.php");
exit();
?>