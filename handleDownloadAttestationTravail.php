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
$sql = "SELECT `Prenom_arabe`, `Nom_arabe`, `N° CIN`, `Grade`FROM `fonctionnairesv3` WHERE `Numéro` = '$userID'";
$result = $conn->query($sql);

// Traiter le résultat de la requête
$response = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $grade = $row['Grade'];
        $sql1 = "SELECT `Libelle_Arabe` FROM `grade` WHERE `Libelle` = '$grade' LIMIT 1";
        $result2 = $conn->query($sql1);
        if ($result->num_rows > 0) {
            $row2 = $result2->fetch_assoc();
        }
        $infos = [
            "Prenom_arabe" => $row["Prenom_arabe"],
            "Nom_arabe" => $row["Nom_arabe"],
            "Grade" => $row2["Libelle_Arabe"],
            "CIN" => $row["N° CIN"]
        ];
        $response[] = $infos;
    }
}

// Fermer la connexion à la base de données
$conn->close();

// Retourner la réponse au format JSON
echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>
