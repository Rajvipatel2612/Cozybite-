<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user's custom orders + delivery person details
$sql = "SELECT custom_orders.*, 
delivery_persons.name AS dp_name,
delivery_persons.phone AS dp_phone,
delivery_persons.email AS dp_email,
delivery_persons.current_lat,
delivery_persons.current_lng
FROM custom_orders
LEFT JOIN delivery_persons 
ON custom_orders.delivery_person_id = delivery_persons.id
WHERE custom_orders.user_id=?
ORDER BY custom_orders.id DESC";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Custom Orders - CozyBite</title>

<style>
body { font-family: Arial,sans-serif; background:#fff8f4; margin:0; padding:0; }

.container { 
width:90%; 
max-width:950px; 
margin:60px auto; 
background:#fff; 
border-radius:10px; 
padding:20px; 
box-shadow:0 2px 10px rgba(0,0,0,0.1);
}

h2 { text-align:center; color:#4b2e05; margin-bottom:20px;}

table { width:100%; border-collapse:collapse;}

th, td { border:1px solid #ddd; padding:10px; text-align:center;}

th { background:#ffeedb; color:#4b2e05; }

tr:hover { background:#fff5eb; }

img.cake_img { width:60px; height:60px; object-fit:cover; border-radius:5px; }

.status { font-weight:600; text-transform:capitalize; }

.status.pending { color:#f39c12; }
.status.completed { color:#27ae60; }
.status.cancelled { color:#e74c3c; }
.status.out { color:#2980b9; }

.delivery_box{
background:#f4e3d3;
padding:8px;
border-radius:6px;
font-size:13px;
margin-top:5px;
}

.track_btn{
background:#28a745;
color:white;
border:none;
padding:5px 10px;
border-radius:4px;
cursor:pointer;
margin-top:4px;
}
</style>

</head>

<body>

<div class="container">

<h2>My Custom Orders</h2>

<?php if(mysqli_num_rows($result) > 0): ?>

<table>

<tr>
<th>#</th>
<th>Cake Type</th>
<th>Flavor</th>
<th>Size(kg)</th>
<th>Message</th>
<th>Reference Image</th>
<th>Status</th>
<th>Payment</th>
<th>Delivery</th>
<th>Request Date</th>
</tr>

<?php
$i=1;
while($order=mysqli_fetch_assoc($result)):
?>

<tr>

<td><?= $i++; ?></td>

<td><?= htmlspecialchars($order['cake_type']); ?></td>

<td><?= htmlspecialchars($order['flavour']); ?></td>

<td><?= htmlspecialchars($order['size']); ?></td>

<td><?= htmlspecialchars($order['message']); ?></td>

<td>

<?php if(!empty($order['image'])): ?>

<img src="uploads/custom_orders/<?= $order['image']; ?>" class="cake_img">

<?php else: ?>

N/A

<?php endif; ?>

</td>

<td class="status <?= strtolower($order['status']); ?>">
<?= htmlspecialchars($order['status']); ?>
</td>

<td>

<?php
if($order['status']=="confirmed" && $order['payment_status']!="advance_paid"){
?>

<form action="confirm_custom_payment.php" method="POST">

<input type="hidden" name="order_id" value="<?= $order['id']; ?>">

<input type="hidden" name="amount" value="<?= $order['advance_amount']; ?>">

<input type="hidden" name="method" value="Online">

<button style="background:#28a745;color:white;border:none;padding:5px 10px;border-radius:4px;">
Pay ₹<?= $order['advance_amount']; ?>
</button>

</form>

<?php
}
elseif($order['payment_status']=="advance_paid"){
echo "Advance Paid<br>";

?>

<a href="receipt_custom.php?id=<?= $order['id']; ?>" target="_blank">
<button style="background:#4b2e05;color:white;border:none;padding:5px 10px;border-radius:4px;margin-top:5px;">
View Receipt
</button>
</a>

<?php
}

elseif($order['payment_status']=="paid"){
echo "Fully Paid";
}
else{
echo "Pending";
}
?>

</td>

<td>

<?php if(!empty($order['dp_name']) && $order['status'] != 'Delivered'): ?>

<div class="delivery_box">

<b>Delivery Person:</b> <?= htmlspecialchars($order['dp_name']); ?><br>

<b>Phone:</b> <?= htmlspecialchars($order['dp_phone']); ?><br>

<b>Email:</b> <?= htmlspecialchars($order['dp_email']); ?><br>

<?php if(!empty($order['current_lat']) && !empty($order['current_lng'])): ?>

<a href="https://www.google.com/maps?q=<?= $order['current_lat']; ?>,<?= $order['current_lng']; ?>" target="_blank">

<button class="track_btn">Track</button>

</a>

<?php else: ?>

Location not available

<?php endif; ?>

</div>

<?php else: ?>

Not Assigned

<?php endif; ?>

</td>

<td><?= htmlspecialchars($order['request_date']); ?></td>

</tr>

<?php endwhile; ?>

</table>

<?php else: ?>

<p style="text-align:center;">You have not placed any custom orders yet.</p>

<?php endif; ?>

</div>

</body>
</html>

<?php mysqli_stmt_close($stmt); ?>
