<?php
include 'db.php';

$id = $_GET['id'];

$order = mysqli_fetch_assoc(
mysqli_query($conn,"SELECT * FROM custom_orders WHERE id='$id'")
);

$payment = mysqli_fetch_assoc(
mysqli_query($conn,"SELECT * FROM payments 
WHERE order_id='$id' AND order_type='custom' 
ORDER BY id DESC LIMIT 1")
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Custom Order Receipt - Cozybite</title>
<link rel="stylesheet" href="style.css">
<style>

body{
font-family:Arial;
background:#f5f5f5;

}

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

</head>

<body>
<header>
  <div class="navbar">
    <img src="images/logo.png">
    <nav>
      <a href="index.php" style="color:#c77b30;">Home</a>
      <a href="menu.php" style="color:#c77b30;">Menu</a>
      <a href="offers.php" style="color:#c77b30;">Offers</a>
      <a href="cart.php" style="color:#c77b30;">Cart</a>
      <a href="orders.php" style="color:#c77b30;">My Orders</a>
    </nav>
  </div>
</header>
<div class="receipt">

<h2>Custom Cake Order Receipt</h2>

<p><b>Order ID:</b> <?= $order['id']; ?></p>
<p><b>Customer Name:</b> <?= $order['name']; ?></p>
<p><b>Cake Type:</b> <?= $order['cake_type']; ?></p>
<p><b>Flavour:</b> <?= $order['flavour']; ?></p>
<p><b>Size:</b> <?= $order['size']; ?></p>

<table>

<tr>
<th>Total Price</th>
<th>Advance Paid</th>
<th>Remaining Amount</th>
</tr>

<tr>
<td>₹<?= $order['price']; ?></td>
<td>₹<?= $order['advance_amount']; ?></td>
<td>₹<?= $order['remaining_amount']; ?></td>
</tr>

</table>

<div class="total">
<b>Payment Status: 
<?= isset($payment['payment_status']) ? $payment['payment_status'] : $order['payment_status']; ?>
</b>
</div>

<center>
<button class="print-btn" onclick="window.print()">Print Receipt</button>
</center>

<center>
<a href="custom_orders_history.php">
<button class="print-btn">View My Custome Orders</button>
</a>
</center>

</div>
<footer class="footer">
  <h1>Contact us</h1>
  <p>Phone no:9612430671 | Email: cozybite@gmail.com</p>
</footer>
</body>
</html>

