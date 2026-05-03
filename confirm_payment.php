<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit();
}

$order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
$payment_mode = isset($_POST['payment_mode']) ? $_POST['payment_mode'] : '';

// Fetch order amount
$result = mysqli_query($conn,"SELECT total_amount FROM orders WHERE id='$order_id'");
$row = mysqli_fetch_assoc($result);
$amount = $row['total_amount'];

// Standardize status values
if ($payment_mode === 'COD') {

$status = 'Pending';
$message = 'Order placed successfully! Please pay on delivery.';

mysqli_query($conn,"INSERT INTO payments 
(order_id,order_type,payment_method,payment_status,amount,payment_date) 
VALUES 
('$order_id','normal','COD','Pending','$amount',NOW())");

}
else{

$status = 'Paid';
$message = 'Payment successful! Your order is confirmed.';

mysqli_query($conn,"INSERT INTO payments 
(order_id,order_type,payment_method,payment_status,amount,payment_date) 
VALUES 
('$order_id','normal','$payment_mode','Paid','$amount',NOW())");

}

// Update order status safely using prepared statement
if ($order_id > 0) {
    $stmt = mysqli_prepare($conn, "UPDATE orders SET status=? WHERE id=?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'si', $status, $order_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

// Redirect to success page with message
echo "<script>alert('" . addslashes($message) . "'); window.location.href='success.php?order_id=" . urlencode($order_id) . "';</script>";
exit();
?>