<?php
session_start();
include '../db.php';

if(!isset($_SESSION['delivery_id'])){
header("Location: login.php");
exit();
}

$delivery_id = $_SESSION['delivery_id'];

/* Orders for delivery */
$sql="SELECT * FROM orders 
WHERE delivery_person_id='$delivery_id'
AND status='Out for Delivery'";

$result=mysqli_query($conn,$sql);

/* Custom Orders for delivery */
$custom_sql="SELECT * FROM custom_orders 
WHERE delivery_person_id='$delivery_id'
AND status='Out for Delivery'";

$custom_result=mysqli_query($conn,$custom_sql);

/* Dashboard stats */
$total=mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM orders WHERE delivery_person_id='$delivery_id'"));

$pending=mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM orders WHERE delivery_person_id='$delivery_id' AND status='Out for Delivery'"));

$out=mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM orders WHERE delivery_person_id='$delivery_id' AND status='Out for Delivery'"));
?>

<html>
<head>
<title>Delivery Dashboard</title>
<link rel="stylesheet" href="../admin/style.css">
</head>

<body>

<div class="header">
<img src="../images/logo.png">

<nav>
<a href="dashboard.php" style="text-decoration: underline;">Dashboard</a>
<a href="history.php">History</a>

<button onclick="location.href='logout.php'" style="margin-left:50px;">Logout</button>
</nav>
<a href="profile.php" class="profileicon">
        <img src="../images/user.png" alt="Profile">
      </a>
</div>

<h2 style="text-align:center;">Delivery Dashboard</h2>

<!-- Dashboard Stats -->
<div style="display:flex;justify-content:center;gap:30px;margin:20px;">

<div style="padding:20px;background:#FFF8F0;border-radius:10px;">
<h3>Total Deliveries</h3>
<p><?php echo $total['total']; ?></p>
</div>

<div style="padding:20px;background:#FFF8F0;border-radius:10px;">
<h3>Pending</h3>
<p><?php echo $pending['total']; ?></p>
</div>

<div style="padding:20px;background:#FFF8F0;border-radius:10px;">
<h3>Out for Delivery</h3>
<p><?php echo $out['total']; ?></p>
</div>

</div>


<h2 style="text-align:center;">Assigned Orders</h2>

<table style="width:100%;border-collapse:collapse;margin-top:15px;">

<tr style="background:#f5f5f5;">
<th style="padding:10px;border:1px solid #ddd;">Order ID</th>
<th style="padding:10px;border:1px solid #ddd;">User Name</th>
<th style="padding:10px;border:1px solid #ddd;">Phone</th>
<th style="padding:10px;border:1px solid #ddd;">Address</th>
<th style="padding:10px;border:1px solid #ddd;">Payment</th>
<th style="padding:10px;border:1px solid #ddd;">Total</th>
<th style="padding:10px;border:1px solid #ddd;">Status</th>
<th style="padding:10px;border:1px solid #ddd;">Action</th>
</tr>

<?php 
while($row=mysqli_fetch_assoc($result)){ 

$user_id=$row['user_id'];

/* get user details */
$user=mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM users WHERE id='$user_id'"));

/* payment type */
$pay=mysqli_fetch_assoc(mysqli_query($conn,
"SELECT payment_method FROM payments WHERE order_id='".$row['id']."'"));
?>

<tr style="background:#f5f5f5;">

<td style="padding:10px;border:1px solid #ddd;"><?php echo $row['id']; ?></td>

<td style="padding:10px;border:1px solid #ddd;"><?php echo $user['full_name']; ?></td>

<td style="padding:10px;border:1px solid #ddd;"><?php echo $user['phone']; ?></td>

<td style="padding:10px;border:1px solid #ddd;">

<?php echo $row['address'] ?? 'Not Available'; ?>

<br><br>

<a href="https://www.google.com/maps?q=<?php echo urlencode($row['address']); ?>" target="_blank">
<button>View Map</button>
</a>

</td>

<td style="padding:10px;border:1px solid #ddd;"><?php echo $pay['payment_method'] ?? 'N/A'; ?></td>

<td style="padding:10px;border:1px solid #ddd;"><?php echo $row['total_amount']; ?></td>

<td style="padding:10px;border:1px solid #ddd;"><?php echo $row['status']; ?></td>

<td style="padding:10px;border:1px solid #ddd;">

<a href="deliver.php?id=<?php echo $row['id']; ?>">
<button>Mark Delivered</button>
</a>

</td>

</tr>

<?php } ?>

</table>

<h2 style="text-align:center;">Assigned Custom Orders</h2>

<table style="width:100%;border-collapse:collapse;margin-top:15px;">

<tr style="background:#f5f5f5;">
<th style="padding:10px;border:1px solid #ddd;">Order ID</th>
<th style="padding:10px;border:1px solid #ddd;">Name</th>
<th style="padding:10px;border:1px solid #ddd;">Phone</th>
<th style="padding:10px;border:1px solid #ddd;">Address</th>
<th style="padding:10px;border:1px solid #ddd;">Cake</th>
<th style="padding:10px;border:1px solid #ddd;">Size</th>
<th style="padding:10px;border:1px solid #ddd;">Status</th>
<th style="padding:10px;border:1px solid #ddd;">R_amount</th>
<th style="padding:10px;border:1px solid #ddd;">Action</th>
</tr>

<?php 
while($row=mysqli_fetch_assoc($custom_result)){ 
?>

<tr style="background:#f5f5f5;">

<td style="padding:10px;border:1px solid #ddd;"><?php echo $row['id']; ?></td>

<td style="padding:10px;border:1px solid #ddd;"><?php echo $row['name']; ?></td>

<td style="padding:10px;border:1px solid #ddd;"><?php echo $row['phone']; ?></td>

<td style="padding:10px;border:1px solid #ddd;">

<?php echo $row['address']; ?>

<br><br>

<a href="https://www.google.com/maps?q=<?php echo urlencode($row['address']); ?>" target="_blank">
<button>View Map</button>
</a>

</td>

<td style="padding:10px;border:1px solid #ddd;"><?php echo $row['cake_type']; ?></td>

<td style="padding:10px;border:1px solid #ddd;"><?php echo $row['size']; ?></td>

<td style="padding:10px;border:1px solid #ddd;"><?php echo $row['status']; ?></td>
<td style="padding:10px;border:1px solid #ddd;">₹<?php echo $row['remaining_amount']; ?></td>
<td style="padding:10px;border:1px solid #ddd;">
<a href="deliver_custom.php?id=<?php echo $row['id']; ?>" 
onclick="return confirm('Mark delivered and payment received?')">

<button>Mark Delivered</button>

</a>

</a>

</a>

</td>

</tr>

<?php } ?>

</table>

<script src="location.js"></script>

</body>
</html>