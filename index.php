<?php
session_start();
include 'db.php';

// ✅ Ensure $user_id is defined if user is logged in
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CozyBite - Home</title>
<link rel="stylesheet" href="style.css">
</head>
<body class="homepage">

<header>
  <div class="navbar">
    <img src="images/logo.png">
    <nav>
      <a href="index.php" style="text-decoration: underline;">Home</a>
      <a href="menu.php">Menu</a>
      <a href="offers.php">Offers</a>
      <a href="cart.php">Cart</a>
    </nav>

    <div class="right-side">
      <!-- ✅ Bell icon with notifications count -->
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

      <?php if ($user_id > 0): ?>
          <button onclick="location.href='logout.php'" class="login">Logout</button>
      <?php else: ?>
          <button onclick="location.href='login.php'" class="login">Login</button>
      <?php endif; ?>
    </div>
  </div>
</header>

<div class="hero">
  <h2>Freshly Baked Happiness, Just for You!</h2>
  <p>At CozyBite, every bite tells a story of warmth, sweetness and love.</p>
  <button onclick="location.href='menu.php'">Explore Now</button>
</div>

<footer>
  <h1>Contact us</h1>
  <p>Phone no:9612430671   Email:cozybite@gmail.com</p>
  <p>Facebook       Instagram</p>
</footer>

<script src="main.js"></script>
</body>
</html>