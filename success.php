<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
  echo "<script>window.location.href='login.php';</script>";
  exit();
}

$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

if ($order_id == 0) {
  echo "<script>alert('Invalid order!'); window.location.href='menu.php';</script>";
  exit();
}

/* Order Details */
$order_query = mysqli_query($conn,"SELECT * FROM orders WHERE id='$order_id'");
$order = mysqli_fetch_assoc($order_query);

/* Payment Details */
$payment_query = mysqli_query($conn,"SELECT * FROM payments WHERE order_id='$order_id'");
$payment = mysqli_fetch_assoc($payment_query);

/* Order Items */
$items = mysqli_query($conn,"SELECT * FROM order_items WHERE order_id='$order_id'");

/* User Details */
$user_id = $_SESSION['user_id'];
$user_query = mysqli_query($conn,"SELECT * FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($user_query);
?>

<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Order Successful - CozyBite</title>
<link rel="stylesheet" href="style.css">

<style>

.receipt{
width:700px;
margin:40px auto;
background:white;
padding:30px;
border-radius:10px;
box-shadow:0 0 10px rgba(0,0,0,0.1);
}

.receipt h2{
text-align:center;
color:#c77b30;
}

table{
width:100%;
border-collapse:collapse;
margin-top:20px;
}

th{
background:#c77b30;
color:white;
padding:10px;
}

td{
border:1px solid #ddd;
padding:8px;
text-align:center;
}

.total{
text-align:right;
font-size:18px;
margin-top:15px;
}

.print-btn{
background:#c77b30;
color:white;
padding:10px 20px;
border:none;
border-radius:8px;
cursor:pointer;
margin-top:20px;
}

</style>

<script>
function downloadReceipt(){
window.print();
}
</script>

</head>

<body class="restpage">

<header>
  <div class="navbar">
    <img src="images/logo.png">
    <nav>
      <a href="index.php">Home</a>
      <a href="menu.php">Menu</a>
      <a href="offers.php">Offers</a>
      <a href="cart.php">Cart</a>
      <a href="orders.php">My Orders</a>
    </nav>
  </div>
</header>

<div class="receipt">

<h2>🎉 Order Placed Successfully!</h2>
<p style="text-align:center;">Thank you for shopping with <b>CozyBite</b> 🍰</p>

<p><b>Order ID:</b> <?= $order['id'] ?></p>
<p><b>Order Date:</b> <?= $order['order_date'] ?></p>

<p><b>Customer Name:</b> <?= $user['full_name'] ?></p>
<p><b>Delivery Address:</b> <?= $order['address'] ?></p>

<p><b>Payment Method:</b> <?= $payment['payment_method'] ?></p>
<p><b>Payment Status:</b> <?= $payment['payment_status'] ?></p>

<table>

<tr>
<th>Product</th>
<th>Price</th>
<th>Quantity</th>
<th>Total</th>
</tr>

<?php
while($row=mysqli_fetch_assoc($items)){

$total = $row['price'] * $row['quantity'];
?>

<tr>
<td><?= $row['product_name'] ?></td>
<td>₹<?= $row['price'] ?></td>
<td><?= $row['quantity'] ?></td>
<td>₹<?= $total ?></td>
</tr>

<?php } ?>

</table>

<div class="total">
<b>Total Amount: ₹<?= $order['total_amount'] ?></b>
</div>

<center>
<button class="print-btn" onclick="window.print()">Print Receipt</button>
</center>

<br>

<center>
<button class="print-btn" onclick="downloadReceipt()">Download Receipt</button>
</center>

<br>

<center>
<a href="orders.php">
<button class="print-btn">View My Orders</button>
</a>
</center>

</div>

<footer class="footer">
  <h1>Contact us</h1>
  <p>Phone no:9612430671 | Email: cozybite@gmail.com</p>
</footer>

</body>
</html>
