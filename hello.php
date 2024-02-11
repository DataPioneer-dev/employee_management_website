<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
    $dateObject = DateTime::createFromFormat('m/d/Y', $dateString);

    $excelDateValue = Date::PHPToExcel($dateObject);

    $phpSpreadsheetDateObject = Date::excelToDateTimeObject($excelDateValue);

    $formattedDate = $phpSpreadsheetDateObject->format('Y-m-d');

    return $formattedDate;
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

        foreach ($data as $row) {
            $Civilite = $conn->real_escape_string($row[1]);
            $Nom_fr = $conn->real_escape_string($row[3]);
            $Prenom_fr = $conn->real_escape_string($row[5]);
            $Nom_ar = $conn->real_escape_string($row[2]);
            $Prenom_ar = $conn->real_escape_string($row[4]);
            $RIB = $conn->real_escape_string($row[6]);
            $group = $conn->real_escape_string($row[7]);
            $CIN = $conn->real_escape_string($row[8]);
            $Date_naissance = convertDate($row[9]);
            $Date_recrutement = convertDate($row[10]);
            $Date_affectation = convertDate($row[11]);
            $Corps = $conn->real_escape_string($row[12]);
            $Grade = $conn->real_escape_string($row[13]);
            // Petit traitement pour le poste de responsabilité
            $Poste_responsabilite_original = $conn->real_escape_string($row[14]);
            $mots = explode(' ',strtolower($Poste_responsabilite_original));
            $Poste_responsabilite_traitee = implode(' ', array_slice($mots, 0, 3));
            $Poste_responsabilite = ucfirst($Poste_responsabilite_traitee);
            // fin de traitement
            $Direction = $conn->real_escape_string($row[15]);
            $Division = $conn->real_escape_string($row[16]);
            $Service = $conn->real_escape_string($row[17]);
            $Situation = $conn->real_escape_string($row[18]);
            $Tel = $conn->real_escape_string($row[19]);
            $email = $conn->real_escape_string($row[20]);

            $sql = "INSERT INTO $tableName (`Civilité`, `Nom`, `Prenom`, `Nom_arabe`, `Prenom_arabe`, `N° CIN`, `Date de naissance`, `Date de recrutement`, `Date d'affectation au CRO`, `Corps`, `Grade`, `Poste de responsabilité`, `Direction`, `Division`, `Service`, `Situation`, `N° Tél`, `Email`, `Solde de Congé`) VALUES ('$Civilite', '$Nom_fr', '$Prenom_fr', '$Nom_ar', '$Prenom_ar', '$CIN', '$Date_naissance', '$Date_recrutement', '$Date_affectation', '$Corps', '$Grade', '$Poste_responsabilite', '$Direction', '$Division', '$Service', '$Situation', '$Tel', '$email', 22)";
            $conn->query($sql);
        }
        $conn->close();
    }
}
?>
