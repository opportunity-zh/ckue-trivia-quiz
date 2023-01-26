<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</head>
<body>
    <?php
        require "./includes/db.php";

        echo "Hello Quiz!";

        $sqlStatement = $dbConnection->query("SELECT * FROM `questions`");

        echo "<table>";

        while ( $row = $sqlStatement->fetch(PDO::FETCH_ASSOC) ) {
            echo "<tr>";

            // Durch den Array hindurch die Angaben zu einem Buch in eine Tabellenzelle ausgeben.
            foreach ($row as $columnName => $value) {
                echo "<td>$value</td>";
            }

            echo "</tr>";
        }

        echo "</table>";
    ?>  
</body>
</html>