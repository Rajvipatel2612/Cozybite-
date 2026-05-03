<?php
session_start();
include '../db.php';

$delivery_id=$_SESSION['delivery_id'];

$sql="SELECT * FROM orders 
WHERE delivery_person_id='$delivery_id'
AND status='Delivered'";

$result=mysqli_query($conn,$sql);

$custom_sql="SELECT * FROM custom_orders 
WHERE delivery_person_id='$delivery_id'
AND status='Delivered'";

$custom_result=mysqli_query($conn,$custom_sql);
?>
<html>
<head> <link rel="stylesheet" href="../admin/style.css"> </head>
<body>
<div class="header">
<img src="../images/logo.png">

<nav>
<a href="dashboard.php">Dashboard</a>
<a href="history.php" style="text-decoration: underline;">History</a>

<button onclick="location.href='logout.php'" style="margin-left:50px;">Logout</button>
</nav>
<a href="profile.php" class="profileicon">
        <img src="../images/user.png" alt="Profile">
      </a>
</div>
<h2 style="text-align:center;">Delivery History</h2>

<table style="width:100%;border-collapse:collapse;margin-top:15px;">

<tr style="background:#f5f5f5;">
<th style="padding:10px;border:1px solid #ddd;">Order ID</th>
<th style="padding:10px;border:1px solid #ddd;">User ID</th>
<th style="padding:10px;border:1px solid #ddd;">Total</th>
<th style="padding:10px;border:1px solid #ddd;">Status</th>
</tr>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr style="background:#f5f5f5;">
<td style="padding:10px;border:1px solid #ddd;"><?php echo $row['id']; ?></td>
<td style="padding:10px;border:1px solid #ddd;"><?php echo $row['user_id']; ?></td>
<td style="padding:10px;border:1px solid #ddd;"><?php echo $row['total_amount']; ?></td>
<td style="padding:10px;border:1px solid #ddd;"><?php echo $row['status']; ?></td>
</tr>

<?php } ?>

</table>

<h2 style="text-align:center;margin-top:40px;">Custom Orders History</h2>

<table style="width:100%;border-collapse:collapse;margin-top:15px;">

<tr style="background:#f5f5f5;">
<th style="padding:10px;border:1px solid #ddd;">Order ID</th>
<th style="padding:10px;border:1px solid #ddd;">User ID</th>
<th style="padding:10px;border:1px solid #ddd;">Price</th>
<th style="padding:10px;border:1px solid #ddd;">Status</th>
</tr>

<?php while($row=mysqli_fetch_assoc($custom_result)){ ?>

<tr style="background:#f5f5f5;">
<td style="padding:10px;border:1px solid #ddd;"><?php echo $row['id']; ?></td>
<td style="padding:10px;border:1px solid #ddd;"><?php echo $row['user_id']; ?></td>
<td style="padding:10px;border:1px solid #ddd;"><?php echo $row['price']; ?></td>
<td style="padding:10px;border:1px solid #ddd;"><?php echo $row['status']; ?></td>
</tr>

<?php } ?>

</table>

</body>
</html>