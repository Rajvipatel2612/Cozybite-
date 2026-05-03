<?php
// get_locations.php
// Admin side: return all delivery persons current location in JSON

include '../db.php'; // admin folder se db connection

header('Content-Type: application/json');

$result = mysqli_query($conn, "SELECT id, name, current_lat, current_lng FROM delivery_persons ORDER BY id DESC");

$locations = [];

if($result){
    while($row = mysqli_fetch_assoc($result)){
        $locations[] = $row;
    }
}

// JSON output
echo json_encode($locations);
?>