<!DOCTYPE html>
<html>
<head>
    <title>Display Results</title>
</head>
<body>
    <h1>Results</h1>
    <?php
    // Retrieve the data from the query parameters
    $nom1 = $_GET['nom'] ?? '';
    ?>
    <p>First Line: <?php echo $nom1; ?></p>
</body>
</html>
