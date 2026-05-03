<?php
session_start();
include 'db.php';

// check login
if(!isset($_SESSION['user_id'])){
    echo "Please login first.";
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch notifications
$query = "SELECT * FROM notifications WHERE user_id='$user_id' ORDER BY created_at DESC";
$result = mysqli_query($conn,$query);

if(!$result){
    die("Query Failed: " . mysqli_error($conn));
}

if(mysqli_num_rows($result) > 0){
    echo "<h3>Notifications:</h3><ul>";

    while($row = mysqli_fetch_assoc($result)){

        $style = ($row['is_read']==0) ? "font-weight:bold;" : "";

        echo "<li style='$style'>".$row['message']." <small>(".$row['created_at'].")</small></li>";

        // mark as read
        mysqli_query($conn,"UPDATE notifications SET is_read=1 WHERE id=".$row['id']);
    }

    echo "</ul>";

}else{
    echo "<p>No notifications.</p>";
}
?>