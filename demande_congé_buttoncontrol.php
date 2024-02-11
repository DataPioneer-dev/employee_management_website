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
$status = $_POST['status'];
$demandeID = $_POST['demandeID'];


// Execute the SQL query to fetch holidays within the date range
$sql = "UPDATE demande_congé SET `Status`=$status WHERE demande_id=$demandeID";
$conn->query($sql);

// Close the database connection
$conn->close();
?>