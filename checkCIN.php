<?php
// Establish a connection to the database
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "gestion_fonct";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the start and end dates from the AJAX request
$checkCIN = $_GET['checkCIN'];

// Execute the SQL query to fetch holidays within the date range
$sql = "SELECT `N° CIN` FROM `fonctionnairesv3` WHERE `N° CIN` = '$checkCIN'";
$result = $conn->query($sql);

// Process the query result
$response = false;
if ($result->num_rows > 0) {
    $response = true;
} else {
    $response = false;
}

// Close the database connection
$conn->close();

// Return the response as JSON
echo json_encode($response);
?>