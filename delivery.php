<?php
session_start();
include '../db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

/* =========================
   DELIVERY PERSON MANAGEMENT
========================= */

// Add Delivery Person
if(isset($_POST['add_person'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $photo_name = '';
    if(isset($_FILES['photo']) && $_FILES['photo']['error']==0){
        $photo_name = time().'_'.$_FILES['photo']['name'];
        move_uploaded_file($_FILES['photo']['tmp_name'], '../uploads/'.$photo_name);
    }

    mysqli_query($conn, "INSERT INTO delivery_persons(name, phone, email, address, password, photo, is_active) VALUES('$name','$phone','$email','$address','$password','$photo_name',1)");
    header("Location: delivery.php");
    exit();
}

// Edit Delivery Person
if(isset($_POST['edit_person'])){
    $id = intval($_POST['person_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    $photo_sql = '';
    if(isset($_FILES['photo']) && $_FILES['photo']['error']==0){
        $photo_name = time().'_'.$_FILES['photo']['name'];
        move_uploaded_file($_FILES['photo']['tmp_name'], '../uploads/'.$photo_name);
        $photo_sql = ", photo='$photo_name'";
    }

    mysqli_query($conn, "UPDATE delivery_persons SET name='$name', phone='$phone', email='$email', address='$address', password='$password', is_active=$is_active $photo_sql WHERE id=$id");
    header("Location: delivery.php");
    exit();
}

// Delete Delivery Person
if(isset($_GET['delete_person'])){
    $id = intval($_GET['delete_person']);
    mysqli_query($conn, "DELETE FROM delivery_persons WHERE id=$id");
    header("Location: delivery.php");
    exit();
}

// Fetch person for editing
$edit_person = null;
if(isset($_GET['edit_person'])){
    $id = intval($_GET['edit_person']);
    $res = mysqli_query($conn, "SELECT * FROM delivery_persons WHERE id=$id");
    if($res && mysqli_num_rows($res)>0){
        $edit_person = mysqli_fetch_assoc($res);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cozybite - Delivery Persons</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table { width:100%;border-collapse:collapse;margin-top:15px; }
        th, td { padding:10px;border:1px solid #ddd;}
        tr { background:#f5f5f5; }
        img.photo { width: 50px; height: 50px; border-radius: 50%; }
        a { text-decoration: none; color: #4B2E05; }
        a:hover { text-decoration: underline; }
        button { border:none; border-radius:5px; cursor:pointer; }
        .btn-delete { background-color: #f44336; color: #fff; }
        .btn-delete:hover { background-color: #d32f2f; }
        .btn-edit { background-color: #2196F3; color: #fff; }
        .btn-edit:hover { background-color: #1976D2; }
        .form-inline { display: flex; justify-content: center; gap:10px; margin:10px 0; flex-wrap: wrap; }
        .form-inline input, .form-inline select { padding:5px; border-radius:5px; border:1px solid #ccc; }
        
    </style>
</head>
<body>
<div class="header">
		<img src="..\images\logo.png">
		<nav>
			<a href ="dashboard.php">Dashboard</a>
			<a href ="products.php">Products</a>
			<a href ="orders.php" >Orders</a>
			<a href ="custome.php">Custome Orders</a>
			<a href ="delivery.php" style="text-decoration: underline;">Delivery</a>

		</nav>

        <button onclick="location.href='logout.php'" style="margin-left:50px;">Logout</button>

		<a href="profile.php" class="profileicon">
			<img src="..\images\user.png" alt="Profile">
		</a>
	</div>

<div style="box-shadow:5px 5px 10px;text-align:center;width:300px;margin:50px auto;padding:20px;background-color:#FFF8F0;border-radius:30px;">
<h2 style="text-align:center; margin-top:20px;">Delivery Persons</h2>

<!-- Add / Edit Delivery Person Form -->
<form method="POST" class="form-inline" enctype="multipart/form-data">
<?php if($edit_person): ?>
<input type="hidden" name="person_id" value="<?php echo $edit_person['id']; ?>">
<input type="text" name="name" placeholder="Name" value="<?php echo $edit_person['name']; ?>" required>
<input type="text" name="phone" placeholder="Phone" value="<?php echo $edit_person['phone']; ?>" required>
<input type="email" name="email" placeholder="Email" value="<?php echo $edit_person['email']; ?>" required>
<input type="password" name="password" placeholder="Password" required>
<input type="text" name="address" placeholder="Address" value="<?php echo $edit_person['address']; ?>" required>
<select name="is_active">
<option value="1" <?php if($edit_person['is_active']==1) echo 'selected'; ?>>Active</option>
<option value="0" <?php if($edit_person['is_active']==0) echo 'selected'; ?>>Inactive</option>
</select>
<input type="file" name="photo">
<button type="submit" name="edit_person" class="btn-edit">Update Person</button>
<a href="delivery.php"><button type="button">Cancel</button></a>
<?php else: ?>
<input type="text" name="name" placeholder="Name" required>
<input type="text" name="phone" placeholder="Phone" required>
<input type="email" name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password" required>
<input type="text" name="address" placeholder="Address" required>
<input type="file" name="photo">
<button type="submit" name="add_person">Add Person</button>
<?php endif; ?>
</form>
</div>
<!-- =========================
   Assign Delivery Person
========================= -->
<h2 style="text-align:center; margin-top:20px;">Assign Delivery Person</h2>

<?php
$orders = mysqli_query($conn, "SELECT id, user_id, status FROM orders WHERE status='Pending' OR status='Preparing' OR status='Paid' ORDER BY id DESC");
?>
<?php if(mysqli_num_rows($orders) > 0): ?>
<table>
<tr>
<th>Order ID</th>
<th>User ID</th>
<th>Status</th>
<th>Assign Delivery Person</th>
<th>Action</th>
</tr>
<?php while($order = mysqli_fetch_assoc($orders)): ?>
<tr>
<td><?php echo $order['id']; ?></td>
<td><?php echo $order['user_id']; ?></td>
<td><?php echo $order['status']; ?></td>
<td>
<form method="POST" action="assign_delivery.php">
<input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
<select name="delivery_person_id" required>
<option value="">Select Delivery Person</option>
<?php
$persons = mysqli_query($conn,"SELECT id,name FROM delivery_persons WHERE is_active=1");
while($p = mysqli_fetch_assoc($persons)){
    echo "<option value='{$p['id']}'>{$p['name']}</option>";
}
?>
</select>
</td>
<td>
<button type="submit" name="assign" style="padding:5px 10px; border-radius:5px; cursor:pointer;">Assign</button>
</form>
</td>
</tr>
<?php endwhile; ?>
</table>
<?php else: ?>
<p style="text-align:center;">No pending orders to assign.</p>
<?php endif; ?>

<h2 style="text-align:center; margin-top:40px;">Assign Delivery Person (Custom Orders)</h2>

<?php
$custom_orders = mysqli_query($conn, "SELECT id, name, cake_type, status 
FROM custom_orders 
WHERE status='confirmed' 
OR status='Preparing' 
OR status='Paid'
OR status='Completed'
ORDER BY id DESC");
?>

<?php if(mysqli_num_rows($custom_orders) > 0): ?>
<table style="width:90%; margin:20px auto;">
<tr>
<th>Order ID</th>
<th>Customer</th>
<th>Cake Type</th>
<th>Status</th>
<th>Assign Delivery Person</th>
<th>Action</th>
</tr>

<?php while($order = mysqli_fetch_assoc($custom_orders)): ?>
<tr>

<td><?php echo $order['id']; ?></td>
<td><?php echo htmlspecialchars($order['name']); ?></td>
<td><?php echo htmlspecialchars($order['cake_type']); ?></td>
<td><?php echo htmlspecialchars($order['status']); ?></td>

<td>
<form method="POST" action="assign_custom_delivery.php">
<input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">

<select name="delivery_person_id" required>
<option value="">Select Delivery Person</option>

<?php
$persons = mysqli_query($conn,"SELECT id,name FROM delivery_persons WHERE is_active=1");
while($p = mysqli_fetch_assoc($persons)){
echo "<option value='{$p['id']}'>{$p['name']}</option>";
}
?>

</select>
</td>

<td>
<button type="submit" name="assign" style="padding:5px 10px;border-radius:5px;">Assign</button>
</form>
</td>

</tr>
<?php endwhile; ?>

</table>

<?php else: ?>

<p style="text-align:center;">No custom orders to assign.</p>

<?php endif; ?>
<!-- Live Map -->
<div id="map"></div>

<table>
<tr>
<th>ID</th>
<th>Photo</th>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>Address</th>
<th>Status</th>
<th>Current Location</th>
<th>Last Seen</th>
<th>Created At</th>
<th>Actions</th>
</tr>

<?php
$persons = mysqli_query($conn, "SELECT * FROM delivery_persons ORDER BY id DESC");
if(!$persons){
    die("Error fetching delivery persons: ".mysqli_error($conn));
}
while($p = mysqli_fetch_assoc($persons)):
?>
<tr>
<td><?php echo $p['id']; ?></td>
<td>
<?php if(!empty($p['photo'])): ?>
<img src="../uploads/<?php echo $p['photo']; ?>" class="photo" alt="Photo">
<?php else: ?>
N/A
<?php endif; ?>
</td>
<td><?php echo $p['name']; ?></td>
<td><?php echo $p['email']; ?></td>
<td><?php echo $p['phone']; ?></td>
<td><?php echo $p['address']; ?></td>
<td><?php echo $p['is_active'] ? "Active" : "Inactive"; ?></td>
<td>
<?php if(!empty($p['current_lat']) && !empty($p['current_lng'])): ?>
<a href="https://www.google.com/maps?q=<?php echo $p['current_lat'].','.$p['current_lng']; ?>" target="_blank">View Location</a>
<?php else: ?>
N/A
<?php endif; ?>
</td>
<td><?php echo $p['last_seen']; ?></td>
<td><?php echo $p['created_at']; ?></td>
<td>
<a href="?edit_person=<?php echo $p['id']; ?>"><button class="btn-edit" style="margin-bottom:5px;">Edit</button></a> |
<a href="?delete_person=<?php echo $p['id']; ?>" onclick="return confirm('Delete this person?')"><button class="btn-delete">Delete</button></a>
</td>
</tr>
<?php endwhile; ?>
</table>
</body>
</html>