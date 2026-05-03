<?php
session_start();
include '../db.php';

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}

if(isset($_POST['assign'])){
    $order_id = intval($_POST['order_id']);
    $delivery_person_id = intval($_POST['delivery_person_id']);

    // Update order with delivery person and status
    mysqli_query($conn,"UPDATE orders SET delivery_person_id=$delivery_person_id, status='Out for Delivery' WHERE id=$order_id");

    // Optional: notify delivery person via email
    $res = mysqli_query($conn,"SELECT email, name FROM delivery_persons WHERE id=$delivery_person_id");
    if($res && mysqli_num_rows($res)>0){
        $dp = mysqli_fetch_assoc($res);
        $to = $dp['email'];
        $subject = "New Delivery Assigned!";
        $message = "Hi ".$dp['name'].",\nYou have been assigned Order #$order_id. Please check your dashboard.";
        $headers = "From: no-reply@cozybite.com";
        mail($to,$subject,$message,$headers);
    }

    header("Location: delivery.php");
    exit();
}
?>