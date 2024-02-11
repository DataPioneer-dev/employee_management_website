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

function convertDate($dateString) {
    $date = DateTime::createFromFormat('Y-m-d', $dateString);
    if ($date === false) {
        // Failed to create a DateTime object
        throw new Exception('Invalid date format. Expected format: Y-m-d');
        // Alternatively, you can return null to indicate the conversion failed
        // return null;
    }
    $formattedDate = $date->format('d-m-Y');
    return $formattedDate;
}

$start_date = "07-08-2023";
$date = DateTime::createFromFormat('d-m-Y', $start_date);
$formattedDate = $date->format('Y-m-d');


// Use prepared statement to fetch holidays within the date range
$sql = "SELECT * FROM `jours_fériés` WHERE `Date_départ` >= ? ORDER BY `Date_départ` ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $formattedDate);
$stmt->execute();
$result = $stmt->get_result();

// Process the query result
$response = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $holiday = [
            "Date_depart" => convertDate($row["Date_départ"]),
            "nombres_jours" => $row["nombres_jours"],
            "Date_fin" => convertDate($row["Date_fin"])
        ];
        $response[] = $holiday;
    }
}

// Close the database connection
$stmt->close();
$conn->close();

// Return the response as JSON
echo json_encode($response);
?>
