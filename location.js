function updateLocation(){

if(navigator.geolocation){

navigator.geolocation.getCurrentPosition(function(position){

var lat = position.coords.latitude;
var lng = position.coords.longitude;

var xhr = new XMLHttpRequest();

xhr.open("POST","update_location.php",true);

xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");

xhr.send("lat="+lat+"&lng="+lng);

});

}

}

// location every 10 seconds update
setInterval(updateLocation,10000);

// first time run
updateLocation();