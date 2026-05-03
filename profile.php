<?php
session_start();
include '../db.php';

if(!isset($_SESSION['delivery_id'])){
    header("Location: login.php");
    exit();
}

$id = $_SESSION['delivery_id'];

$result = mysqli_query($conn,"SELECT * FROM delivery_persons WHERE id='$id'");
$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Delivery Profile - CozyBite</title>
  <link rel="stylesheet" href="../admin/style.css">
</head>

<body>
<div class="header">
<img src="../images/logo.png">

<nav>
<a href="dashboard.php">Dashboard</a>
<a href="history.php">History</a>

<button onclick="location.href='logout.php'" style="margin-left:50px;">Logout</button>

</nav>
<a href="profile.php" class="profileicon">
        <img src="../images/user.png" alt="Profile">
      </a>
</div>
<div style="text-align:center; margin:40px;">

  <h2>👤 Delivery Profile</h2>
  <?php 
if(!empty($data['photo'])){ 
?>

<img src="../uploads/<?php echo $data['photo']; ?>" 
style="width:110px;height:110px;border-radius:50%;object-fit:cover;margin:25px auto;display:block;">

<?php } else { ?>

<img src="../images/user.png" 
style="width:110px;height:110px;border-radius:50%;object-fit:cover;margin:25px auto;display:block;">

<?php } ?>

  <p><b>Name:</b> <?php echo $data['name']; ?></p>

  <p><b>Email:</b> <?php echo $data['email']; ?></p>

  <p><b>Phone:</b> <?php echo $data['phone']; ?></p>

  <div style="margin-top:25px;">
      <h3>Welcome, <?php echo $data['name']; ?> 👋</h3>
  </div>

</div>

</body>
</html>


