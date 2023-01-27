<?php
    require "./includes/data-collector.php"; // Muss zuerst sein wegen start_session()

    // Variable für den Index der aktuellen Frage vorbereiten
    // $lastQuestionIndex wird im data-collector.php vorbereitet.
    $currentQuestionIndex = $lastQuestionIndex + 1;

    // Variablen für die hidden-Felder vorbereiten (lastPageID, quiz-last-question-index)
    $currentPageID = "question-" . $currentQuestionIndex;
?>
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

    ?>  

    <!-- FORMULAR "Fragestellung" -->
    <div class="row">
        <div class="col-sm-8">
            <!-- Fragestellung -->
            <h7>Congratulations!</h7>
            <h3>You achieved x out of possible y points.</h3>

        </div>

        <button class="btn btn-primary" onclick="document.location='/index.php';">Neues Quiz</button>
    </div>

</body>
</html>