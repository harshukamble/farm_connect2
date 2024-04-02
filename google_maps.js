// Global variable to store the Google Maps instance
var map;

// Function to initialize Google Maps
function initMap() {
    // Center the map on a specific location (e.g., latitude and longitude)
    var center = { lat: 0, lng: 0 }; // Replace with actual coordinates
    // Create a new map instance
    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 10, // Adjust the initial zoom level as needed
        center: center
    });
}

// Function to add markers for matching landowners
function addMatchingLandownersMarkers(landowners) {
    // Loop through the list of landowners
    landowners.forEach(function(landowner) {
        // Extract latitude and longitude from landowner data
        var latLng = { lat: parseFloat(landowner.latitude), lng: parseFloat(landowner.longitude) };

        // Create a marker for each landowner
        var marker = new google.maps.Marker({
            position: latLng,
            map: map,
            title: landowner.name // Add a title for the marker (optional)
        });
    });
}

// Function to add markers for nearby cities
function addNearbyCitiesMarkers(cities) {
    // Loop through the list of cities
    cities.forEach(function(city) {
        // Extract latitude and longitude from city data
        var latLng = { lat: parseFloat(city.latitude), lng: parseFloat(city.longitude) };

        // Create a marker for each city
        var marker = new google.maps.Marker({
            position: latLng,
            map: map,
            title: city.name // Add a title for the marker (optional)
        });
    });
}
