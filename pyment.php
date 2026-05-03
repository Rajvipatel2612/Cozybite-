<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
  echo "<script>window.location.href='login.php';</script>";
  exit();
}

$user_id = $_SESSION['user_id'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone_no'];
$address = $_POST['address'];
$date = date('Y-m-d H:i:s');
$total = 0;
$order_id = 0;

// ✅ Direct order
if (isset($_POST['direct_order']) && isset($_SESSION['direct_order'])) {
  $item = $_SESSION['direct_order'];
  $product_name = $item['product_name'];
  $price = $item['price'];
  $total = $price;

  // Insert order (Pending until payment)
 mysqli_query($conn, "INSERT INTO orders (user_id, total_amount, address, order_date, status)
VALUES ('$user_id', '$total', '$address', '$date', 'Pending')");
  $order_id = mysqli_insert_id($conn);

  // Insert item
  mysqli_query($conn, "INSERT INTO order_items (order_id, product_name, price, quantity)
                       VALUES ('$order_id', '$product_name', '$price', 1)");

  unset($_SESSION['direct_order']); // clear session

} else {
  // 🛒 Normal cart order
  $cart = mysqli_query($conn, "SELECT * FROM cart WHERE user_id='$user_id'");
  if (mysqli_num_rows($cart) == 0) {
    echo "<script>alert('Your cart is empty!'); window.location.href='menu.php';</script>";
    exit();
  }

  while ($row = mysqli_fetch_assoc($cart)) {
    $total += $row['price'] * $row['quantity'];
  }

  // ✅ ADDRESS ADDED HERE
  mysqli_query($conn, "INSERT INTO orders (user_id, total_amount, address, order_date, status)
                       VALUES ('$user_id', '$total', '$address', '$date', 'Pending')");
  $order_id = mysqli_insert_id($conn);

  mysqli_data_seek($cart, 0);
  while ($row = mysqli_fetch_assoc($cart)) {
    mysqli_query($conn, "INSERT INTO order_items (order_id, product_name, price, quantity)
                         VALUES ('$order_id', '{$row['product_name']}', '{$row['price']}', '{$row['quantity']}')");
  }

  // Clear cart after order
  mysqli_query($conn, "DELETE FROM cart WHERE user_id='$user_id'");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Payment - CozyBite</title>
<link rel="stylesheet" href="style.css">
<style>
.payment-box {
  box-shadow: 5px 5px 15px #d1c7b7;
  background-color: #FFF8F0;
  border-radius: 30px;
  text-align: center;
  width: 400px;
  margin: 80px auto;
  padding: 30px;
}
.payment-option { margin: 10px 0; }
button {
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 10px;
  padding: 10px 20px;
  cursor: pointer;
}
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
      <a href="cart.php">Cart</a>
      <button onclick="location.href='logout.php'" class="login">Logout</button>
    </nav>
  </div>
</header>

<div class="payment-box">
  <h2>🧾 Select Payment Method</h2>
  <form method="post" action="confirm_payment.php">
    <input type="hidden" name="order_id" value="<?= $order_id; ?>">
    <div class="payment-option">
<input type="radio" name="payment_mode" value="COD" required>
Cash on Delivery
</div>

<div class="payment-option">
<input type="radio" name="payment_mode" value="UPI">
UPI
</div>

<div class="payment-option">
<input type="radio" name="payment_mode" value="Credit Card">
Credit Card
</div>

<div class="payment-option">
<input type="radio" name="payment_mode" value="Debit Card">
Debit Card
</div>

<div class="payment-option">
<input type="radio" name="payment_mode" value="Net Banking">
Net Banking
</div>
    <button type="submit">Confirm Payment</button>
  </form>
</div>

<footer class="footer">
  <h1>Contact us</h1>
  <p>Phone no: 9612430671 | Email: cozybite@gmail.com</p>
</footer>

</body>
</html>