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
$userID = $_POST['userID'];

// Exécuter la requête SQL pour récupérer les congés dans la plage de dates
$sql = "SELECT `Prenom`, `Nom`, `N° CIN`, `Corps`, `Grade`, `Matricule Aujour` FROM `fonctionnairesv3` WHERE `Numéro` = '$userID'";
$result = $conn->query($sql);

// Traiter le résultat de la requête
$response = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $infos = [
            "Prenom" => $row["Prenom"],
            "Nom" => $row["Nom"],
            "Grade" => $row["Grade"],
            "Corps" => $row["Corps"],
            "CIN" => $row["N° CIN"],
            "MatriculeAujour" => $row['Matricule Aujour']
        ];
        $response[] = $infos;
    }
}

// Fermer la connexion à la base de données
$conn->close();

// Retourner la réponse au format JSON
echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>
