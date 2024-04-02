<?php
// Function to get nearby cities using OpenWeather API
function getNearbyCities($village) {
    // API endpoint for OpenWeather API
    $api_url = 'http://api.openweathermap.org/data/2.5/weather?q=' . urlencode($village) . '&appid=cbf75fe89a1cce4844462c1b094da096';

    // Make API call
    $response = file_get_contents($api_url);

    // Check if the response is successful
    if ($response === FALSE) {
        return FALSE; // Return FALSE if API call fails
    }

    // Parse JSON response
    $data = json_decode($response, TRUE);

    // Extract nearby cities from the response (example: just a placeholder)
    $nearby_cities = array(
        array('name' => 'City 1', 'weather' => 'Sunny', 'land_details' => 'Available'),
        array('name' => 'City 2', 'weather' => 'Cloudy', 'land_details' => 'Available'),
        // Add more cities as needed
    );

    return $nearby_cities;  
}
?>
