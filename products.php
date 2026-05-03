<?php
session_start();
include '../db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

/* ADD PRODUCT */

if(isset($_POST['add_product'])){

$name = $_POST['name'];
$price = $_POST['price'];
$category = $_POST['category'];

$image = $_FILES['image']['name'];
$tmp = $_FILES['image']['tmp_name'];

move_uploaded_file($tmp,"../images/".$image);

$sql = "INSERT INTO products (name,price,image,category)
VALUES ('$name','$price','$image','$category')";

mysqli_query($conn,$sql);

header("Location: products.php");
}

/* DELETE PRODUCT */

if(isset($_GET['delete'])){

$id = $_GET['delete'];

mysqli_query($conn,"DELETE FROM products WHERE id=$id");

header("Location: products.php");
}

/* UPDATE PRODUCT */

if(isset($_POST['update_product'])){

$id = $_POST['id'];
$name = $_POST['name'];
$price = $_POST['price'];
$category = $_POST['category'];

mysqli_query($conn,"UPDATE products 
SET name='$name',price='$price',category='$category'
WHERE id=$id");

header("Location: products.php");
}

?>

<html>
<head>
<title>Products - Cozybite</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="header">
		<img src="..\images\logo.png">
		<nav>
			<a href ="dashboard.php">Dashboard</a>
			<a href ="products.php" style="text-decoration: underline;" >Products</a>
			<a href ="orders.php">Orders</a>
			<a href ="custome.php">Custome Orders</a>
			<a href ="delivery.php">Delivery</a>

		</nav>

        <button onclick="location.href='logout.php'" style="margin-left:50px;">Logout</button>

		<a href="profile.php" class="profileicon">
			<img src="..\images\user.png" alt="Profile">
		</a>
	</div>

<div style="box-shadow:5px 5px 10px;text-align:center;width:300px;margin:50px auto;padding:20px;background-color:#FFF8F0;border-radius:30px;">
<h2 style="text-align:center; padding-bottom:5px;">Add Product</h2>

<form method="POST" enctype="multipart/form-data" style="text-align:center;">

<input type="text" name="name" placeholder="Product name" required><br><br>

<input type="number" name="price" placeholder="Price" required><br><br>

<select name="category" required>
<option value="">Select Category</option>
<option value="cupcakes">Cupcakes</option>
<option value="cookies">Cookies</option>
<option value="waffles">Waffles</option>
<option value="brownies">Brownies</option>
<option value="cakes">Cakes</option>
<option value="chocolate">Chocolate</option>
<option value="croissant">Croissant</option>
<option value="cheesecake">Cheesecake</option>
</select>

<br><br>

<input type="file" name="image" required><br><br>

<button type="submit" name="add_product">Add Product</button>

</form>
</div>
<br><br>

<h2 style="text-align:center;">Product List</h2>

<table style="width:100%;border-collapse:collapse;margin-top:15px;">

<tr style="background:#f5f5f5;">
<th style="padding:10px;border:1px solid #ddd;">ID</th>
<th style="padding:10px;border:1px solid #ddd;">Name</th>
<th style="padding:10px;border:1px solid #ddd;">Price</th>
<th style="padding:10px;border:1px solid #ddd;">Category</th>
<th style="padding:10px;border:1px solid #ddd;">Image</th>
<th style="padding:10px;border:1px solid #ddd;">Action</th>
</tr>

<?php

$result = mysqli_query($conn,"SELECT * FROM products");

while($row = mysqli_fetch_assoc($result)){

?>

<tr style="background:#f5f5f5;">

<td style="padding:10px;border:1px solid #ddd;"><?php echo $row['id']; ?></td>
<td style="padding:10px;border:1px solid #ddd;"><?php echo $row['name']; ?></td>
<td style="padding:10px;border:1px solid #ddd;"><?php echo $row['price']; ?></td>
<td style="padding:10px;border:1px solid #ddd;"><?php echo $row['category']; ?></td>

<td style="padding:10px;border:1px solid #ddd;">
<img src="../images/<?php echo $row['image']; ?>" style="border-radius:0px; width:80%;">
</td>

<td style="padding:10px;border:1px solid #ddd;">

<a href="?edit=<?php echo $row['id']; ?>">Edit</a> |

<a href="?delete=<?php echo $row['id']; ?>" 
onclick="return confirm('Delete this product?')">Delete</a>

</td>

</tr>

<?php } ?>

</table>

<br><br>

<?php

/* EDIT FORM */

if(isset($_GET['edit'])){

$id = $_GET['edit'];

$result = mysqli_query($conn,"SELECT * FROM products WHERE id=$id");

$row = mysqli_fetch_assoc($result);

?>

<h2 style="text-align:center;">Edit Product</h2>

<form method="POST" style="text-align:center;">

<input type="hidden" name="id" value="<?php echo $row['id']; ?>">

<input type="text" name="name" value="<?php echo $row['name']; ?>" required><br><br>

<input type="number" name="price" value="<?php echo $row['price']; ?>" required><br><br>

<select name="category">

<option value="cupcakes">Cupcakes</option>
<option value="cookies">Cookies</option>
<option value="waffles">Waffles</option>
<option value="brownies">Brownies</option>
<option value="cakes">Cakes</option>
<option value="chocolate">Chocolate</option>
<option value="croissant">Croissant</option>
<option value="cheesecake">Cheesecake</option>

</select>

<br><br>

<button type="submit" name="update_product">Update Product</button>

</form>

<?php } ?>

</body>
</html>