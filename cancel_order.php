<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
  echo "<script>window.location.href='login.php';</script>";
  exit();
}

$user_id = $_SESSION['user_id'];
$order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;

// Allow cancel if status is pending (cover variants like 'Pending', 'Pending (COD)', 'pending')
$check_sql = "SELECT * FROM orders WHERE id=? AND user_id=? AND (LOWER(status) = 'pending' OR status LIKE 'Pending%')";
$stmt = mysqli_prepare($conn, $check_sql);
mysqli_stmt_bind_param($stmt, 'ii', $order_id, $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
  // Update to 'Cancelled'
  $upd = mysqli_prepare($conn, "UPDATE orders SET status='Cancelled' WHERE id=? AND user_id=?");
  mysqli_stmt_bind_param($upd, 'ii', $order_id, $user_id);
  mysqli_stmt_execute($upd);
  mysqli_stmt_close($upd);

  echo "<script>alert('Order cancelled successfully!'); window.location.href='orders.php';</script>";
} else {
  echo "<script>alert('Order cannot be cancelled now.'); window.location.href='orders.php';</script>";
}
mysqli_stmt_close($stmt);
?>