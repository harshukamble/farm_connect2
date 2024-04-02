<?php
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the uploaded file exists and is a PDF
    if (isset($_FILES['id_proof']) && $_FILES['id_proof']['error'] === UPLOAD_ERR_OK) {
        // Move uploaded file to a local folder
        $upload_dir = 'uploads/'; // Path to your upload folder
        $filename = $_FILES['id_proof']['name'];
        $destination = $upload_dir . basename($filename);
        if (!move_uploaded_file($_FILES['id_proof']['tmp_name'], $destination)) {
            exit("Error: Failed to move uploaded file to destination.");
        }

        // Connect to your database
        $conn = new mysqli("localhost", "root", "", "farm_connect");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and bind parameters
        $stmt = $conn->prepare("INSERT INTO landowners (name, mobile_number, village, land_quantity, id_proof) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt) {
            // Error handling: Output error message and SQL error details
            die("Error: " . $conn->error);
        }

        // Bind parameters
        if (!$stmt->bind_param("sssss", $name, $mobile_number, $village, $land_quantity, $destination)) {
            // Error handling: Output error message and SQL error details
            die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
        }

        // Set parameters
        $name = $_POST['name'];
        $mobile_number = $_POST['mobile_number'];
        $village = $_POST['village'];
        $land_quantity = $_POST['land_quantity'];

        // Execute SQL statement
        if (!$stmt->execute()) {
            // Error handling: Output error message and SQL error details
            die("Execution failed: (" . $stmt->errno . ") " . $stmt->error);
        }

        // Close statement
        $stmt->close();

        // Close connection
        $conn->close();

        echo "Landowner registration successful!";
    } else {
        // Handle the case where file upload failed or no file was uploaded
        exit("Error: Failed to upload file or no file was uploaded.");
    }
}
?>
