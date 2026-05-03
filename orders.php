<?php
session_start();
include '../db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

/* STATUS UPDATE */

if(isset($_GET['prepare'])){
$order_id = $_GET['prepare'];
mysqli_query($conn,"UPDATE orders SET status='Preparing' WHERE id=$order_id");
header("Location: orders.php");
}

/* DELETE ORDER */

if(isset($_GET['delete'])){
$order_id = $_GET['delete'];

mysqli_query($conn,"DELETE FROM orders WHERE id=$order_id");
mysqli_query($conn,"DELETE FROM order_items WHERE order_id=$order_id");

header("Location: orders.php");
}

?>

<html>
<head>
	<title>Cozybite</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="header">
		<img src="..\images\logo.png">
		<nav>
			<a href ="dashboard.php">Dashboard</a>
			<a href ="products.php">Products</a>
			<a href ="orders.php" style="text-decoration: underline;" >Orders</a>
			<a href ="custome.php">Custome Orders</a>
			<a href ="delivery.php">Delivery</a>

		</nav>

        <button onclick="location.href='logout.php'" style="margin-left:50px;">Logout</button>

		<a href="profile.php" class="profileicon">
			<img src="..\images\user.png" alt="Profile">
		</a>
	</div>

<h2 style="text-align:center; margin-top:30px;">Orders</h2>

<table style="width:100%;border-collapse:collapse;margin-top:15px;">

<tr style="background:#f5f5f5;">
<th style="padding:10px;border:1px solid #ddd;">Order ID</th>
<th style="padding:10px;border:1px solid #ddd;">User ID</th>
<th style="padding:10px;border:1px solid #ddd;">Product</th>
<th style="padding:10px;border:1px solid #ddd;">Price</th>
<th style="padding:10px;border:1px solid #ddd;">Quantity</th>
<th style="padding:10px;border:1px solid #ddd;">Total Amount</th>
<th style="padding:10px;border:1px solid #ddd;">Order Date</th>
<th style="padding:10px;border:1px solid #ddd;">Status</th>
<th style="padding:10px;border:1px solid #ddd;">Action</th>
</tr>

<?php

$sql = "SELECT orders.id, orders.user_id, orders.total_amount, orders.order_date, orders.status,
        order_items.product_name, order_items.price, order_items.quantity
        FROM orders
        JOIN order_items ON orders.id = order_items.order_id
        ORDER BY orders.id DESC";

$result = mysqli_query($conn,$sql);

while($row = mysqli_fetch_assoc($result)){

?>

<tr style="background:#f5f5f5;">

<td style="padding:10px;border:1px solid #ddd;"><?php echo $row['id']; ?></td>
<td style="padding:10px;border:1px solid #ddd;"><?php echo $row['user_id']; ?></td>
<td style="padding:10px;border:1px solid #ddd;"><?php echo $row['product_name']; ?></td>
<td style="padding:10px;border:1px solid #ddd;">₹<?php echo $row['price']; ?></td>
<td style="padding:10px;border:1px solid #ddd;"><?php echo $row['quantity']; ?></td>
<td style="padding:10px;border:1px solid #ddd;">₹<?php echo $row['total_amount']; ?></td>
<td style="padding:10px;border:1px solid #ddd;"><?php echo $row['order_date']; ?></td>

<td style="padding:10px;border:1px solid #ddd;"><?php echo $row['status']; ?></td>

<td style="padding:10px;border:1px solid #ddd;">

<?php if($row['status']=="Pending"){ ?>

<a href="?prepare=<?php echo $row['id']; ?>">Prepare</a>

<?php } ?>

|

<a href="?delete=<?php echo $row['id']; ?>" 
onclick="return confirm('Delete this order?')">
Delete </a>

</td>

</tr>

<?php } ?>

</table>

</body>
</html>
