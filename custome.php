<?php
session_start();
include '../db.php'; // database connection

// Admin login check
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

/* =========================
   STATUS UPDATE WITH NOTIFICATION
========================= */
if(isset($_GET['complete'])){
    $id = intval($_GET['complete']); // ensure integer

    // Update order status
    $update = mysqli_query($conn, "UPDATE custom_orders SET status='Completed' WHERE id=$id");

    if($update){
        // Fetch user info
        $user_query = mysqli_query($conn, "SELECT user_id FROM custom_orders WHERE id=$id");
        if($user_query && mysqli_num_rows($user_query) > 0){
            $user = mysqli_fetch_assoc($user_query);
            $user_id = $user['user_id'];

            // Insert notification
            $message = "Your custom order #$id is Completed!";
            mysqli_query($conn, "INSERT INTO notifications (user_id, message, created_at) 
            VALUES ($user_id, '$message', NOW())");
        }
    } else {
        die("Error updating order: " . mysqli_error($conn));
    }

    header("Location: custome.php");
    exit();
}

/* =========================
   DELETE ORDER
========================= */
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']); // ensure integer
    $delete = mysqli_query($conn, "DELETE FROM custom_orders WHERE id=$id");
    if(!$delete){
        die("Error deleting order: " . mysqli_error($conn));
    }
    header("Location: custome.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Cozybite - Custom Orders</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table { border-collapse: collapse; width: 90%; margin: 30px auto; }
        th, td { border: 1px solid #ddd; text-align: center; }
        th { background-color: #f2f2f2; }
        img.cake_image { width: 100px; height: auto; }
    
    </style>
</head>
<body>
    <div class="header">
		<img src="..\images\logo.png">
		<nav>
			<a href ="dashboard.php">Dashboard</a>
			<a href ="products.php">Products</a>
			<a href ="orders.php" >Orders</a>
			<a href ="custome.php" style="text-decoration: underline;">Custome Orders</a>
			<a href ="delivery.php">Delivery</a>

		</nav>

        <button onclick="location.href='logout.php'" style="margin-left:50px;">Logout</button>

		<a href="profile.php" class="profileicon">
			<img src="..\images\user.png" alt="Profile">
		</a>
	</div>

    <h2 style="text-align:center; margin-top:30px;">Custom Cake Orders</h2>

    <?php
    $result = mysqli_query($conn, "SELECT * FROM custom_orders ORDER BY id DESC");
    if(!$result){
        die("Error fetching orders: " . mysqli_error($conn));
    }

    if(mysqli_num_rows($result) > 0){
    ?>

    <table style="border-collapse:collapse;margin-top:15px; width:100%;">
        <tr style="background:#f5f5f5;">
            <th style="border:1px solid #ddd;">ID</th>
            <th style="border:1px solid #ddd;">User ID</th>
            <th style="border:1px solid #ddd;">Name</th>
            <th style="border:1px solid #ddd;">Phone</th>
            <th style="border:1px solid #ddd;">Email</th>
            <th style="border:1px solid #ddd;">Address</th>
            <th style="border:1px solid #ddd;">Cake Type</th>
            <th style="border:1px solid #ddd;">Flavour</th>
            <th style="border:1px solid #ddd;">Size</th>
            <th style="border:1px solid #ddd;">Message</th>
            <th style="border:1px solid #ddd;">Image</th>
            <th style="border:1px solid #ddd;">Request Date</th>
            <th style="border:1px solid #ddd;">Status</th>
            <th style="border:1px solid #ddd;">Action</th>
            <th style="border:1px solid #ddd;">Price</th>
            <th style="border:1px solid #ddd;">Payment</th>
            
        </tr>

        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr style="background:#f5f5f5;">
            <td style="border:1px solid #ddd;"><?php echo $row['id']; ?></td>
            <td style="border:1px solid #ddd;"><?php echo $row['user_id']; ?></td>
            <td style="border:1px solid #ddd;"><?php echo $row['name']; ?></td>
            <td style="border:1px solid #ddd;"><?php echo $row['phone']; ?></td>
            <td style="border:1px solid #ddd;"><?php echo $row['email']; ?></td>
            <td style="border:1px solid #ddd;"><?php echo $row['address']; ?></td>
            <td style="border:1px solid #ddd;"><?php echo $row['cake_type']; ?></td>
            <td style="border:1px solid #ddd;"><?php echo $row['flavour']; ?></td>
            <td style="border:1px solid #ddd;"><?php echo $row['size']; ?></td>
            <td style="border:1px solid #ddd;"><?php echo $row['message']; ?></td>
            <td style="border:1px solid #ddd;">
                <?php if(!empty($row['image'])): ?>
                    <img src="../uploads/<?php echo $row['image']; ?>" class="cake_image">
                <?php else: ?>
                    N/A
                <?php endif; ?>
            </td>
            <td style="border:1px solid #ddd;"><?php echo $row['request_date']; ?></td>
            <td style="border:1px solid #ddd;"><?php echo $row['status']; ?></td>

            <td style="border:1px solid #ddd;">
                <?php if($row['status'] != "Completed"): ?>
                    <a href="?complete=<?php echo $row['id']; ?>" onclick="return confirm('Mark this order as completed?')">Complete</a>  |
                <?php endif; ?>
                <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete this order?')">Delete</a>
            </td>

            <td style="border:1px solid #ddd;">
                <?php if(empty($row['price'])){ ?>

                <form method="POST" action="set_price.php">

                <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">

                <input type="number" name="price" placeholder="Enter Price" required>

                <button type="submit">Set</button>

                </form>

                <?php } else { ?>

                    ₹<?php echo $row['price']; ?>

                <?php } ?>
            </td>

            <td style="border:1px solid #ddd;">
                <?php
                if($row['payment_status']=="advance_paid"){
                echo "Advance Paid";
                }
                elseif($row['payment_status']=="paid"){
                echo "Fully Paid";
                }
                else{
                echo "Pending";
                }
                ?>
            </td>

        </tr>
        <?php endwhile; ?>
    </table>

    <?php
    } else {
        echo "<p style='text-align:center;'>No custom orders found.</p>";
    }
    ?>

</body>
</html>