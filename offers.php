<?php
session_start();
include 'db.php';

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Offers - CozyBite</title>
<link rel="stylesheet" href="style.css">
</head>
<body class="restpage">

<header>
  <div class="navbar">
  <img src="images/logo.png">
  <nav>
    <a href="index.php">Home</a>
    <a href="menu.php">Menu</a>
    <a href="offers.php" style="text-decoration: underline;">Offers</a>
    <a href="cart.php">Cart</a>
    
  </nav>
   <div class="right-side">
      <a href="notifications.php" class="notification-bell">
        <img src="images/bell.png" alt="Notifications" style="width:24px; height:24px;">
        <?php 
            $count = 0;
            if($user_id > 0){
                $result = mysqli_query($conn, "SELECT COUNT(*) as c FROM notifications WHERE user_id=$user_id AND is_read=0");
                if($result){
                    $count = $result->fetch_assoc()['c'];
                }
            }
            echo ($count > 0) ? "($count)" : "";
        ?>
</a>
      <div class="searchbox">
        <form action="menu.php" method="GET">
    <input type="text" name="search" placeholder="Search |🔍">
</form>
      </div>
      <a href="profile.php" class="profileicon">
        <img src="images/user.png" alt="Profile">
      </a>
      <?php if (isset($_SESSION['user_id'])): ?>
        <!-- ✅ User logged in -->
        <button onclick="location.href='logout.php'" class="login">Logout</button>
      <?php else: ?>
        <!-- ❌ Not logged in -->
        <button onclick="location.href='login.php'" class="login">Login</button>
      <?php endif; ?>
    </div>
  </div>
</header>

<section>
  <h1>OFFERS</h1>
  <p>Sweet Deals Are Here! Enjoy your favorite CozyBite treats at special prices. 🍰💝</p><br>
  <div style= "display: flex; justify-content: center;">
    <div style="display:flex; align-items: center; justify-content:center; gap: 20px; box-shadow: 5px 5px 10px; padding: 15px; width:600px; background-color: #FFF8F0; border-radius: 30px;">
      <img src="images/20-percent.png" style="width:130px; height:130px;  transform: rotate(-30deg);">
      <div style="text-aline:center;">
        <h2 style="color: #e6950a;">WEEKEND SPECIAL </h2>
        <p style="font-size: 15px; font-weight: bold;">20% OFF on all cupcakes!<p>
        <form method="POST" action="order.php">
          <input type="hidden" name="product_name" value="Weekend Offer Cupcake">
          <input type="hidden" name="price" value="199">
          <input type="hidden" name="image" value="images/20-percent.png">
  
          <input type="hidden" name="direct_order" value="1">

          <button type="submit">Grab Offer</button>
        </form>
      </div>
      <img src="images/allcupcake.jpeg" style="border-radius:0px; width:120px; height:120px; border-radius:20px;">
    </div>
  </div>
</section>

<footer class="footer">
  <h1>Contact us</h1>
  <p>Phone no:9612430671   Email:cozybite@gmail.com</p>
  <p>Facebook       Instagram</p>
</footer>

<script src="main.js"></script>
</body>
</html>