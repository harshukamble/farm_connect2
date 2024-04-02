<?php
// Include database connection and functions
include 'db_functions.php';

// Receive farmer's search criteria
$village = $_POST['village'];
$land_quantity = $_POST['land_quantity'];

// Validate and sanitize input data (not shown)

// Search for matching landowners
$matching_landowners = getMatchingLandowners($village, $land_quantity);

if ($matching_landowners) {
    // Matching landowners found, return JSON response
    $response['matching_landowners'] = $matching_landowners;
} else {
    // No matching landowners found, use OpenWeather API to find nearby cities
    include 'weather_api.php';
    $nearby_cities = getNearbyCities($village);

    // Display nearby cities with available land
    if ($nearby_cities) {
        $response['nearby_cities'] = $nearby_cities;
    } else {
        $response['error'] = "No matching landowners or nearby cities found.";
    }
}

// Return JSON response
echo json_encode($response);
?>
