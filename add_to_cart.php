<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
  echo "<script>alert('Please login to add items!'); window.location.href='login.php';</script>";
  exit();
}

$user_id = $_SESSION['user_id'];
$product_name = $_POST['product_name'];
$price = $_POST['price'];
$image = $_POST['image'];

// ✅ Store image path temporarily in session
$_SESSION['cart_images'][strtolower(trim($product_name))] = $image;

// ✅ Check if item already exists
$check = mysqli_query($conn, "SELECT * FROM cart WHERE user_id='$user_id' AND product_name='$product_name'");
if (mysqli_num_rows($check) > 0) {
  mysqli_query($conn, "UPDATE cart SET quantity = quantity + 1 WHERE user_id='$user_id' AND product_name='$product_name'");
} else {
  mysqli_query($conn, "INSERT INTO cart (user_id, product_name, price, quantity, added_on)
                       VALUES ('$user_id', '$product_name', '$price', 1, NOW())");
}

echo "<script>alert('Item added to cart successfully!'); window.location.href='menu.php';</script>";
?>