<?php
session_start();
include 'db.php';

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Menu - CozyBite</title>
<link rel="stylesheet" href="style.css">
</head>

<body class="restpage">

<header>
<div class="navbar">
<img src="images/logo.png">

<nav>
<a href="index.php">Home</a>
<a href="menu.php" style="text-decoration: underline;">Menu</a>
<a href="offers.php">Offers</a>
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
<img src="images/user.png">
</a>
<?php if (isset($_SESSION['user_id'])): ?>
<button onclick="location.href='logout.php'" class="login">Logout</button>
<?php else: ?>
<button onclick="location.href='login.php'" class="login">Login</button>
<?php endif; ?>
</div>
</div>
</header>


<section>

<p style="text-align:left;">
😋 Too Sweet to Resist!<br>
Pick your favorite treat and let’s make your day sweeter.
</p>


<?php
$categories = [
"cupcakes"=>"Cupcakes",
"cookies"=>"Cookies",
"waffles"=>"Waffles",
"brownies"=>"Brownies",
"cakes"=>"Cakes",
"chocolate"=>"Chocolate",
"croissant"=>"Croissant",
"cheesecake"=>"Cheesecake"
];

foreach($categories as $key=>$title){

$result = mysqli_query($conn,"SELECT * FROM products WHERE category='$key'");

if(mysqli_num_rows($result)>0){
?>

<h2 id="<?php echo $key; ?>" style="text-align:left;"><?php echo $title; ?></h2>

<div style="display:flex;flex-wrap:wrap;justify-content:space-around;gap:10px;">

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<div style="box-shadow:5px 5px 10px;width:300px;background-color:#FFF8F0;border-radius:30px;padding:10px;">

<img src="images/<?php echo $row['image']; ?>" style="width:50%;margin-left:70px; border-radius: 10px;">

<h3><?php echo $row['name']; ?></h3>

<p>₹<?php echo $row['price']; ?></p>

<form method="post">

<input type="hidden" name="direct_order" value="1">
<input type="hidden" name="product_name" value="<?php echo $row['name']; ?>">
<input type="hidden" name="price" value="<?php echo $row['price']; ?>">
<input type="hidden" name="image" value="images/<?php echo $row['image']; ?>">

<?php if($key=="cakes"){ ?>

<button type="button" onclick="location.href='custome.php'" style="margin-bottom:5px;">Custome Order</button>

<?php } ?>

<button type="submit" formaction="order.php">Order Now</button>

<button type="submit" formaction="add_to_cart.php">Add to cart</button>

</form>

</div>

<?php } ?>

</div>

<br><br>

<?php } } ?>

</section>


<footer class="footer">
<h1>Contact us</h1>
<p>Phone no: 9612430671 Email: cozybite@gmail.com</p>
<p>Facebook Instagram</p>
</footer>

<script src="main.js"></script>

</body>
</html>