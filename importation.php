<?php
/*error_reporting(E_ALL);
ini_set('display_errors', 1);*/

require 'libs/phpoffice/phpspreadsheet/vendor/autoload.php'; 
// ...
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;

function columnLetterToIndex($letter) {
    $base = ord('A') - 1; 

    $letter = strtoupper($letter);

    $index = 0;
    $length = strlen($letter);

    for ($i = 0; $i < $length; $i++) {
        $char = ord($letter[$i]) - $base;
        $index = $index * 26 + $char;
    }

    return $index;
}

function convertDate($dateString) {
    $unixTimestamp = ($dateString - 25569) * 86400;

    $dateObject = new DateTime("@$unixTimestamp");

    $formattedDate = $dateObject->format('Y-m-d');

    return $formattedDate;
}

function MaxID($conn, $tableName) {
    $sql_max_id = "SELECT MAX(`Numéro`) AS max_id FROM $tableName";
    $result = $conn->query($sql_max_id);

    if ($result) {
        $max_id_row = $result->fetch_assoc();
        if ($max_id_row && isset($max_id_row['max_id'])) {
            $max_id = $max_id_row['max_id'];
            return $max_id;
        }
    }

    return 1;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file']['tmp_name'])) {
    if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileName = $_FILES['file']['tmp_name'];

        $excel = IOFactory::load($fileName);
        $worksheet = $excel->getActiveSheet();

        $highestColumnLetter = $worksheet->getHighestColumn();
        $highestColumnIndex = columnLetterToIndex($highestColumnLetter);

        $highestRow = $worksheet->getHighestRow();

        $startRow = 1;
        for ($row = 1; $row <= $highestRow; $row++) {
            $isEmptyRow = true;
            for ($column = 0; $column < $highestColumnIndex; $column++) { 
                $cellValue = $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                if ($cellValue !== null && trim($cellValue) !== '') {
                    $isEmptyRow = false;
                    break;
                }
            }
            if (!$isEmptyRow) {
                $startRow = $row;
                break;
            }
        }

        $servername = 'localhost';
        $username = 'root';
        $password = '';
        $dbname = 'gestion_fonct';

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }

        $data = [];
        for ($row = $startRow + 1; $row <= $highestRow; $row++) {
            $rowData = [];
            $isEmptyRow = true;
            for ($column = 1; $column <= $highestColumnIndex; $column++) {
                $cellValue = $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                $rowData[] = $cellValue;
                if ($cellValue !== null && trim($cellValue) !== '') {
                    $isEmptyRow = false;
                }
            }
            if (!$isEmptyRow) {
                $data[] = $rowData;
            }           
        }

        $tableName = 'fonctionnairesv3';
        $currentDate = new DateTime();

        $MaxID = MaxID($conn, $tableName);

        foreach ($data as $row) {
            $Numero = intval($conn->real_escape_string($row[0])) + $MaxID;
            $Civilite = $conn->real_escape_string($row[1]);
            $Nom_fr = $conn->real_escape_string($row[3]);
            $Prenom_fr = $conn->real_escape_string($row[5]);
            $Nom_ar = $conn->real_escape_string($row[2]);
            $Prenom_ar = $conn->real_escape_string($row[4]);
            $RIB = $conn->real_escape_string($row[6]);
            $Groupe = $conn->real_escape_string($row[7]);
            $CIN = $conn->real_escape_string($row[8]);
            $Date_naissance = convertDate(intval($row[9]));
            $birthdate = new DateTime($Date_naissance);
            $ageInterval = $birthdate->diff($currentDate);
            $age = $ageInterval->y;
            $Date_recrutement = convertDate(intval($row[10]));
            $Date_affectation = convertDate(intval($row[11]));
            $Corps = $conn->real_escape_string($row[12]);
            $Grade = $conn->real_escape_string($row[13]);
            // Petit traitement pour le poste de responsabilité
            $Poste_responsabilite = mb_strtolower($conn->real_escape_string($row[14]), 'UTF-8');
            // fin de traitement
            $Direction = $conn->real_escape_string($row[15]);
            $Division = $conn->real_escape_string($row[16]);
            $Service = $conn->real_escape_string($row[17]);
            $Situation = $conn->real_escape_string($row[18]);
            $Tel = $conn->real_escape_string($row[19]);
            $email = $conn->real_escape_string($row[20]);
            $matriculeAujour = $conn->real_escape_string($row[23]);

            $sql = "INSERT INTO $tableName (`Numéro`, `Civilité`, `Nom`, `Prenom`, `Nom_arabe`, `Prenom_arabe`, `N° CIN`, `RIB`, `Date de naissance`, `Date de recrutement`, `Date d'affectation au CRO`, `Groupe`, `Corps`, `Grade`, `Poste de responsabilité`, `Direction`, `Division`, `Service`, `Situation`, `N° Tél`, `Email`, `Matricule Aujour`, `Age`, `updated_from_table_nombre_jours_congé`) VALUES ('$Numero', '$Civilite', '$Nom_fr', '$Prenom_fr', '$Nom_ar', '$Prenom_ar', '$CIN', '$RIB', '$Date_naissance', '$Date_recrutement', '$Date_affectation', '$Groupe', '$Corps', '$Grade', '$Poste_responsabilite', '$Direction', '$Division', '$Service', '$Situation', '$Tel', '$email', '$matriculeAujour', '$age', 0)";
            $conn->query($sql);
            if (strpos($Poste_responsabilite, "chef") !== false || strpos($Poste_responsabilite, "directeur") !== false || strpos($Poste_responsabilite, "directrice") !== false) {
                $sql_2 = "ALTER TABLE demande_congé_map ADD COLUMN" . "`" . $Nom_fr . "-" . $Prenom_fr . "-" . $Numero . "` VARCHAR(255)";
                $conn->query($sql_2); 
            }
        }

        
        $new_auto_increment_value = MaxID($conn, $tableName) + 1;
        $sql_alter_table = "ALTER TABLE $tableName AUTO_INCREMENT = $new_auto_increment_value";
        $conn->query($sql);

        $conn->close();
    }
    header('Location: fonctionnairesv3.php');
}
?>


