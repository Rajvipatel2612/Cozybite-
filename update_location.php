<?php
session_start();
include '../db.php';

if(!isset($_SESSION['delivery_id'])){
exit();
}

$id = $_SESSION['delivery_id'];

$lat = $_POST['lat'] ?? '';
$lng = $_POST['lng'] ?? '';

if($lat && $lng){

mysqli_query($conn,"
UPDATE delivery_persons 
SET current_lat='$lat',
current_lng='$lng',
last_seen=NOW()
WHERE id='$id'
");

}
?>