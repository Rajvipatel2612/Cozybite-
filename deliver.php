<?php
session_start();
include '../db.php';

if(!isset($_SESSION['delivery_id'])){
header("Location: login.php");
exit();
}

$order_id=$_GET['id'];

mysqli_query($conn,"UPDATE orders 
SET status='Delivered'
WHERE id='$order_id'");

header("Location: dashboard.php");
?>
