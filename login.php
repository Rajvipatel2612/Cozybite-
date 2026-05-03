<?php
session_start();
include '../db.php';

if(isset($_POST['login'])){

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM delivery_persons 
WHERE email='$email' 
AND password='$password' 
AND is_active=1";

$res = mysqli_query($conn,$sql);

if(!$res){
die("Query Error: ".mysqli_error($conn));
}

if(mysqli_num_rows($res)>0){

$row = mysqli_fetch_assoc($res);
$_SESSION['delivery_id'] = $row['id'];

header("Location: dashboard.php");

}else{

$error="Invalid Email or Password";

}

}
?>

<html>

<head>
<title>Delivery Login</title>
<link rel="stylesheet" href="../admin/style.css">
</head>

<body>
<div style="box-shadow:5px 5px 10px;text-align:center;width:300px;margin:50px auto;padding:20px;background-color:#FFF8F0;border-radius:30px;">
<img src="../images/logo.png" style="margin-left: 90px;width: 100PX; height:100px;">

<h2 style="text-align:center;">Delivery Login</h2>

<form method="POST" style="width:300px;margin:auto;">

<input type="email" name="email" placeholder="Email" required><br><br>

<input type="password" name="password" placeholder="Password" required><br><br>

<a href="forgot.php">Forgot Password?</a>

<button type="submit" name="login">Login</button>
</div>
<?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>

</form>

</body>

</html>
