<!DOCTYPE html>
<html>
<body>

<p>Click the button to get your coordinates.</p>

<button onclick="getLocation()">Try It</button>

<p id="demo"></p>

<script>
var storage = window.localStorage;

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else { 
        console.log("Geolocation is not supported by this browser.")
    }
}

function showPosition(position){
    storage.setItem('coordX', position.coords.latitude);
    storage.setItem('coordY', position.coords.longitude);
}

function showError(error) {
    switch(error.code) {
        case error.PERMISSION_DENIED:
            console.log("User denied the request for Geolocation.");
            break;
        case error.POSITION_UNAVAILABLE:
            console.log("Location information is unavailable.");
            break;
        case error.TIMEOUT:
            console.log("The request to get user location timed out.");
            break;
        case error.UNKNOWN_ERROR:
            console.log("An unknown error occurred.");
            break;
    }
}

window.onload = function() {
  getLocation();
};

console.log(storage.getItem('coordX'));
console.log(storage.getItem('coordY'));
</script>

</body>
</html>
