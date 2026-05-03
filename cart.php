<?php
session_start();
include 'db.php'; // ✅ tumhara database connection file (db.php bhi ho sakta hai)

if (!isset($_SESSION['user_id'])) {
  echo "<script>alert('Please login to view your cart!'); window.location.href='login.php';</script>";
  exit();
}

$user_id = $_SESSION['user_id'];

// 🧺 Remove item from cart
if (isset($_POST['remove_item'])) {
    $item_name = $_POST['item_name'];
    $delete = "DELETE FROM cart WHERE user_id='$user_id' AND product_name='$item_name'";
    mysqli_query($conn, $delete);
}

// 🧁 Add item from menu
if (isset($_POST['add_to_cart'])) {
    $item_name = $_POST['item_name'];
    $price = $_POST['price'];

    // Check if item already in cart
    $check = mysqli_query($conn, "SELECT * FROM cart WHERE user_id='$user_id' AND product_name='$item_name'");
    if (mysqli_num_rows($check) > 0) {
        mysqli_query($conn, "UPDATE cart SET quantity = quantity + 1 WHERE user_id='$user_id' AND product_name='$item_name'");
    } else {
        mysqli_query($conn, "INSERT INTO cart (user_id, product_name, price, quantity, added_on) 
                             VALUES ('$user_id', '$product_name', '$price', 1, NOW())");
    }
}

// 🧮 Fetch all cart items
$result = mysqli_query($conn, "SELECT * FROM cart WHERE user_id='$user_id'");
$total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CozyBite - Cart</title>
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
      <a href="cart.php" style="text-decoration: underline;">Cart</a>
      
    </nav>
    <div class="right-side">
      <a href="notifications.php" class="notification-bell">
        <img src="images/bell.png" alt="Notifications" style="width:24px; height:24px;">
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
        <button onclick="location.href='logout.php'" class="login">Logout</button>
      <?php else: ?>
        <button onclick="location.href='login.php'" class="login">Login</button>
      <?php endif; ?>
    </div>
  </div>
</header>

<section class="cart-section">
  <h2>YOUR CART</h2>

  <?php if (mysqli_num_rows($result) > 0): ?>
    <?php while ($item = mysqli_fetch_assoc($result)): ?>
      
      <?php $key = strtolower(trim($item['product_name']));
$img = $_SESSION['cart_images'][$key] ?? 'images/default.jpeg'; ?>
      <div style="box-shadow: 5px 5px 10px; text-align: center; width: 500px; margin: 30px auto; padding: 20px; background-color: #FFF8F0; border-radius: 30px; display: flex; justify-content: space-between;">
        <img src="<?= htmlspecialchars($img); ?>" alt="Item" style="width: 150px; height: 150px; border-radius: 15px;">
        <div class="item-details">
          <h3><?= htmlspecialchars($item['product_name']); ?></h3>
          <p>Price: ₹<?= htmlspecialchars($item['price']); ?></p>
          <p>Qty: <?= htmlspecialchars($item['quantity']); ?></p>
          <p><b>Subtotal: ₹<?= $item['price'] * $item['quantity']; ?></b></p>
          <form method="post">
            <input type="hidden" name="item_name" value="<?= htmlspecialchars($item['product_name']); ?>">
            <button class="remove-btn" name="remove_item">Remove</button>
          </form>
        </div>
      </div>
      <?php $total += $item['price'] * $item['quantity']; ?>
    <?php endwhile; ?>

    <div class="cart-summary" style="text-align:center; margin:20px;">
      <h3>Total: ₹<?= $total; ?></h3>
      <button class="checkout-btn" onclick="location.href='order.php'">Proceed to Checkout</button>
    </div>

  <?php else: ?>
    <p style="text-align:center;">Your cart is empty 🍰</p>
  <?php endif; ?>
</section>

<footer class="footer">
  <h1>Contact us</h1>
  <p>Phone no:9612430671 Email:cozybite@gmail.com</p>
</footer>

</body>
</html>