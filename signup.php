<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    if ($password !== $confirm) {
        echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
        exit;
    }

    // Password hash (secure)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (full_name, email, phone, password) 
            VALUES ('$name', '$email', '$phone', '$hashedPassword')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Signup Successful! Please login now.'); window.location='login.php';</script>";
    } else {
        echo "<script>alert('Email already exists or error occurred!'); window.history.back();</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign Up - CozyBite</title>
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
        <!-- ✅ User logged in -->
        <button onclick="location.href='logout.php'" class="login">Logout</button>
      <?php else: ?>
        <!-- ❌ Not logged in -->
        <button onclick="location.href='login.php'" class="login">Login</button>
      <?php endif; ?>
    </nav>
  </div>
</header>

<div style="box-shadow:5px 5px 10px;text-align:center;width:400px;margin:50px auto;padding:20px;background-color:#FFF8F0;border-radius:30px;">
  <h2>Create Account</h2>
  <form action="signup.php" method="POST">
    <label>Full Name:</label>
    <input type="text" name="fullname" required><br><br>
    <label>Email:</label>
    <input type="email" name="email" required><br><br>
    <label>Phone:</label>
    <input type="text" name="phone" required><br><br>
    <label>Password:</label>
    <input type="password" name="password" required><br><br>
    <label>Confirm Password:</label>
    <input type="password" name="confirm_password" required><br><br>
    <button type="submit">Sign Up</button>
    
    <p>Already have an account? <a href="login.php">Login</a></p>
  </form>
</div>
</body>
</html>