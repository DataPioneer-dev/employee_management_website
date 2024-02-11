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

// Récupérer les dates de début et de fin depuis la requête AJAX
$ID_Cor = $_POST['ID_Cor'];

// Exécuter la requête SQL pour récupérer les congés dans la plage de dates
$sql = "SELECT `Libelle` FROM `corps` WHERE `ID_Cor` = '$ID_Cor'";
$result = $conn->query($sql);

// Traiter le résultat de la requête
$response = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $infos = [
            "corps" => $row["Libelle"]
        ];
        $response[] = $infos;
    }
}

// Fermer la connexion à la base de données
$conn->close();

// Retourner la réponse au format JSON
echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>
