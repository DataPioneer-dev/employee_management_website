<?php
// Établir une connexion à la base de données
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "gestion_fonct";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Exécuter la requête SQL pour récupérer les congés dans la plage de dates
$sql = "UPDATE `phpgen_users` SET `count_reload_page` = `count_reload_page` + 1 WHERE `user_id` = 1";
$conn->query($sql);

$conn->close();

?>
