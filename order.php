<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
  echo "<script>alert('Please login to place an order!'); window.location.href='login.php';</script>";
  exit();
}

$user_id = $_SESSION['user_id'];

// ✅ Check if user clicked “Order Now”
if (isset($_POST['direct_order'])) {
  $_SESSION['direct_order'] = [
    'product_name' => $_POST['product_name'],
    'price' => $_POST['price'],
    'image' => $_POST['image']
  ];
  $direct_mode = true;
} else {
  $direct_mode = false;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Order Now - CozyBite</title>
<link rel="stylesheet" href="style.css">
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
      <?php if (isset($_SESSION['user_id'])): ?>
        <button onclick="location.href='logout.php'" class="login">Logout</button>
      <?php else: ?>
        <button onclick="location.href='login.php'" class="login">Login</button>
      <?php endif; ?>
    </nav>
  </div>
</header>

<section style="display:flex; justify-content:space-between; align-items:flex-start; gap:40px; padding:20px 40px;">
  <div>
    <p>😋 Don’t Wait — Let’s Bake It Up!<br>
    🎉 Order Now and get ready for a bite full of love and coziness!</p><br>

    <?php if ($direct_mode): ?>
      <img src="<?= $_SESSION['direct_order']['image']; ?>" style="height:250px; width:350px; padding-left:60px;">
      <h3><?= $_SESSION['direct_order']['product_name']; ?> — ₹<?= $_SESSION['direct_order']['price']; ?></h3>
    <?php else: ?>
      <img src="images/order_image.jpeg" style="height:250px; width:350px; padding-left:60px;">
    <?php endif; ?>
  </div>

  <div style="box-shadow:5px 5px 10px; text-align:center; width:300px; padding:20px; background-color:#FFF8F0; border-radius:30px;">
    <form method="post" action="pyment.php">
      <h2>Order Now</h2>
      <label>Name:</label>
      <input type="text" name="name" required><br><br>
      <label>Email:</label>
      <input type="email" name="email" required><br><br>
      <label>Phone:</label>
      <input type="text" name="phone_no" required><br><br>
      <label>Address:</label>
      <textarea name="address" required></textarea><br><br>
      
      <?php if ($direct_mode): ?>
        <input type="hidden" name="direct_order" value="1">
      <?php endif; ?>

      <button type="submit">Confirm Order</button>
      
    </form>
  </div>
</section>

<footer class="footer">
  <h1>Contact us</h1>
  <p>Phone no:9612430671 Email:cozybite@gmail.com</p>
</footer>
</body>
</html>