<?php
session_start();
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  $email = $_POST['email'];
  $new_pass = $_POST['new_password'];
  $hashed_pass = password_hash($new_pass, PASSWORD_DEFAULT);

  $sql = "UPDATE delivery_persons SET password='$hashed_pass' WHERE email='$email'";

  if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Password reset successful!');window.location='login.php';</script>";
  } else {
    echo "<script>alert('Error updating password.');</script>";
  }

}
?>

<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="UTF-8">
<title>Forgot Password - Delivery</title>
<link rel="stylesheet" href="../admin/style.css">
</head>

<body>

<div style="box-shadow:5px 5px 10px;text-align:center;width:300px;margin:80px auto;padding:20px;background-color:#FFF8F0;border-radius:30px;">

<h2>Forgot Password</h2>

<p>Enter your registered email and new password.</p>

<form method="POST">

<label>Email:</label> <input type="email" name="email" required><br><br>

<label>New Password:</label> <input type="password" name="new_password" required><br><br>

<button type="submit">Reset Password</button>

<p><a href="login.php">← Back to Login</a></p>

</form>

</div>

</body>
</html>
