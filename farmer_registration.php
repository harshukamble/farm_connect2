<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "farm_connect");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Geocoding Logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $location = $_POST['location']; // Assuming user enters the location
    $api_key = 'cbf75fe89a1cce4844462c1b094da096'; // Replace with your OpenWeather API key
    
    // Use OpenWeather API to fetch latitude and longitude
    $geo_api_url = "https://api.openweathermap.org/geo/1.0/direct?q=" . urlencode($location) . "&limit=1&appid={$api_key}";
    $geo_response = file_get_contents($geo_api_url);
    $geo_data = json_decode($geo_response);

    if ($geo_data && isset($geo_data[0])) {
        $latitude = $geo_data[0]->lat;
        $longitude = $geo_data[0]->lon;

        // Fetch nearby cities within 200 km radius
        $weather_api_url = "https://api.openweathermap.org/data/2.5/find?lat={$latitude}&lon={$longitude}&cnt=10&appid={$api_key}";
        $weather_response = file_get_contents($weather_api_url);
        $weather_data = json_decode($weather_response);

        // Process nearby cities data
        $matched_cities = [];
        if ($weather_data && isset($weather_data->list)) {
            foreach ($weather_data->list as $city) {
                // Check if the city's village matches any village in the landowners table
                $city_name = $city->name;
                $landowners_query = $conn->prepare("SELECT * FROM landowners WHERE village = ?");
                $landowners_query->bind_param("s", $city_name);
                $landowners_query->execute();
                $landowners_result = $landowners_query->get_result();

                if ($landowners_result->num_rows > 0) {
                    // City's village found in landowners table, include it in the matched cities array
                    $matched_cities[] = $city_name;
                }
            }
        }
echo "<h1>Exact Matching Cities</h1>";
// ****************************************************************************************************
// Retrieving farmer's details from the form

$name = $_POST['name'];
$mobile_number = $_POST['mobile_number'];
// $village = $_POST['village'];
$land_quantity = $_POST['land_quantity'];
$location = $_POST['location'];
$id_proof = file_get_contents($_FILES['id_proof']['tmp_name']);

// Query to find matching landowners
// Query to find matching landowners

$sql = "SELECT *
        FROM landowners
        WHERE village = '$location' AND land_quantity = $land_quantity";



$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data in table format
    echo "<table border='1'>";
    echo "<tr><th>Name</th><th>Mobile Number</th><th>Land Quantity</th><th>Location</th><th>ID Proof</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        // echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["mobile_number"] . "</td>";
        // echo "<td>" . $row["village"] . "</td>";
        echo "<td>" . $row["land_quantity"] . "</td>";
        echo "<td>{$row['village']}</td>";
        // echo "<td>" . $row["location"] . "</td>";
        echo "<td><a href='{$row['id_proof']}' download>Download ID Proof</a></td>"; 
        // echo "<td>" . $row["farmer_land_quantity"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No matching landowners found.";
}






// ****************************************************************************************************
echo "<h1>Narby Matching Cities</h1>";
        // Display the data in a table
        if (!empty($matched_cities)) {
            echo "<table border='1'>";
            echo "<tr><th>Name</th><th>Mobile Number</th><th>Village</th><th>Land Quantity</th><th>ID Proof</th></tr>";
            
            // Fetch and display details of landowners for matched cities
            foreach ($matched_cities as $matched_city) {
                $landowners_query = $conn->prepare("SELECT * FROM landowners WHERE village = ?");
                $landowners_query->bind_param("s", $matched_city);
                $landowners_query->execute();
                $landowners_result = $landowners_query->get_result();

                while ($row = $landowners_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['name']}</td>";
                    echo "<td>{$row['mobile_number']}</td>";
                    echo "<td>{$row['village']}</td>";
                    echo "<td>{$row['land_quantity']}</td>";
                    echo "<td><a href='{$row['id_proof']}' download>Download ID Proof</a></td>"; // Assuming ID proof path is stored in 'id_proof_path' column
                    echo "</tr>";
                }
            }
            echo "</table>";
        } else {
            echo "No matching cities found in landowners table.";
        }
    } else {
        // Handle case where geocoding fails
        echo json_encode(['status' => 'error', 'message' => 'Geocoding failed.']);
    }
}

// Farmer Registration Logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare and bind parameters for farmer registration
    $stmt = $conn->prepare("INSERT INTO farmers (name, mobile_number, village, land_quantity, location, id_proof) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $mobile_number, $village, $land_quantity, $location, $id_proof);

    // Set parameters for farmer registration
    $name = $_POST['name'];
    $mobile_number = $_POST['mobile_number'];
    // $village = $_POST['village'];
    $land_quantity = $_POST['land_quantity'];
    $location = $_POST['location']; // Assuming user enters the location
    $id_proof = file_get_contents($_FILES['id_proof']['tmp_name']); // Read file contents

    // Execute SQL statement for farmer registration
    if ($stmt->execute()) {
        // Return success response
        // echo json_encode(['status' => 'success', 'message' => 'Farmer registered successfully!']);
    } else {
        // Error handling for SQL statement execution
        // echo json_encode(['status' => 'error', 'message' => 'Failed to register farmer.']);
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
