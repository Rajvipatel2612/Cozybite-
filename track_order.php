<?php
session_start();
include 'db.php';

// ✅ Check login
if (!isset($_SESSION['user_id'])) {
  echo "<script>alert('Please login to track your order!'); window.location.href='login.php';</script>";
  exit();
}

$user_id = $_SESSION['user_id'];

// ✅ Get order ID from URL (example: track_order.php?order_id=12)
if (!isset($_GET['order_id'])) {
  echo "<script>alert('Invalid Order!'); window.location.href='orders.php';</script>";
  exit();
}

$order_id = intval($_GET['order_id']);

// ✅ Fetch the order safely
$stmt = mysqli_prepare($conn, "SELECT * FROM orders WHERE id = ? AND user_id = ?");
mysqli_stmt_bind_param($stmt, 'ii', $order_id, $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
  echo "<script>alert('Order not found!'); window.location.href='orders.php';</script>";
  exit();
}

$order_data = mysqli_fetch_assoc($result);
$status = $order_data['status'];

// Define progress steps (you can edit these)
$steps = ["Pending", "Preparing", "Out for Delivery", "Delivered"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Track Order - CozyBite</title>
<link rel="stylesheet" href="style.css">
<style>
.track-container {
  width: 80%;
  margin: 50px auto;
  text-align: center;
}
.step {
  display: inline-block;
  width: 20%;
  position: relative;
}
.circle {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  display: inline-block;
  line-height: 40px;
  color: white;
  font-weight: bold;
}
.line {
  height: 4px;
  width: 80px;
  background: #ccc;
  position: absolute;
  top: 18px;
  left: 100%;
  z-index: -1;
}
.active { background: #4CAF50; }
.pending { background: #bbb; }
.completed-line { background: #4CAF50; }
</style>
</head>
<body class="restpage">

<header>
  <div class="navbar">
    <img src="images/logo.png">
    <nav>
      <a href="index.php">Home</a>
      <a href="menu.php">Menu</a>
      <a href="offers.php">Offers</a>
      <a href="orders.php">My Orders</a>
      <button onclick="location.href='logout.php'" class="login">Logout</button>
    </nav>
  </div>
</header>

<section class="track-container">
  <h2>📦 Tracking Order #<?= $order_id; ?></h2>
  <p><b>Current Status:</b> <?= htmlspecialchars($status); ?></p>

  <div style="display:flex; justify-content:space-between; align-items:center; margin-top:40px;">
    <?php
    $active_index = array_search($status, $steps);
    foreach ($steps as $index => $step):
    ?>
      <div class="step">
        <div class="circle <?= ($index <= $active_index) ? 'active' : 'pending'; ?>">
          <?= $index + 1; ?>
        </div>
        <p><?= $step; ?></p>
        <?php if ($index < count($steps)-1): ?>
          <div class="line <?= ($index < $active_index) ? 'completed-line' : ''; ?>"></div>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>

  <br><br>
  <button onclick="window.location.href='orders.php'" style="padding:10px 20px; border:none; background:#c77b30; color:white; border-radius:10px;">Back to Orders</button>
</section>

<footer class="footer">
  <h1>Contact us</h1>
  <p>Phone no:9612430671 | Email: cozybite@gmail.com</p>
</footer>
</body>
</html>