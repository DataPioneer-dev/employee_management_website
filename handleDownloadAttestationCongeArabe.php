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
$sql = "SELECT demande.`Date de Demande`, demande.`Date de départ`, demande.`Nombre de jours demandés`, demande.`Autorisation de sortie du territoire national` as `Auto`, demande.`Type`, fonct.`Prenom`, fonct.`Nom`, fonct.`Nom_arabe`, fonct.`Prenom_arabe`, grade.`Libelle_Arabe` as `Grade`, `service`.`Nom_Arabe` as `Service`, division.`Nom_Arabe` as `Division`, direction.`Libelle_Arabe` as `Direction`
        FROM `fonctionnairesv3` as fonct
        JOIN `demande_congé` as demande ON demande.`demande_id` = '$demandID' AND fonct.`Numéro` = demande.`user_id`
        LEFT JOIN `grade` ON fonct.`Grade` = grade.`Libelle`
        LEFT JOIN `service` ON fonct.`Service` = `service`.`Nom_Serv`
        LEFT JOIN `division` ON fonct.`Division` = division.`Nom_Div`
        LEFT JOIN `direction` ON fonct.`Direction` = direction.`Libelle`
        WHERE fonct.`Numéro` = demande.`user_id`";

$result = $conn->query($sql);

// Traiter le résultat de la requête
$response = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $infos = [
            "Date_de_demande" => $row["Date de Demande"],
            "Date_de_depart" => $row["Date de départ"],
            "nbr_jours" => $row["Nombre de jours demandés"],
            "Autorisation" => $row["Auto"],
            "Type" => $row['Type'],
            "Prenom" => $row["Prenom"],
            "Nom" => $row["Nom"],
            "Nom_arabe" => $row["Nom_arabe"],
            "Prenom_arabe" => $row["Prenom_arabe"],
            "Grade" => $row["Grade"],
            "Service" => $row["Service"],
            "Division" => $row["Division"],
            "Direction" => $row["Direction"]
        ];
        $response[] = $infos;
    }
}

// Fermer la connexion à la base de données
$conn->close();

// Retourner la réponse au format JSON
echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>
