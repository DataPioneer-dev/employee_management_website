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
$demandID = $_POST['demandID'];

// Exécuter la requête SQL pour récupérer les congés dans la plage de dates
$sql = "SELECT demande.`Date de départ`, demande.`Date de retour`, demande.`Nombre de jours demandés`, fonct.`Civilité`, fonct.`Prenom`, fonct.`Nom`, fonct.`Grade`
        FROM `fonctionnairesv3` as fonct
        JOIN `demande_congé` as demande ON demande.`demande_id` = '$demandID' AND fonct.`Numéro` = demande.`user_id`";

$result = $conn->query($sql);

// Traiter le résultat de la requête
$response = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $infos = [
            "Civilite" => $row['Civilité'],
            "Date_de_retour" => $row["Date de retour"],
            "Date_de_depart" => $row["Date de départ"],
            "nbr_jours" => $row["Nombre de jours demandés"],
            "Prenom" => $row["Prenom"],
            "Nom" => $row["Nom"],
            "Grade" => $row["Grade"],
        ];
        $response[] = $infos;
    }
}

// Fermer la connexion à la base de données
$conn->close();

// Retourner la réponse au format JSON
echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>
