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
            <h7>Question 1</h7>
            <h3>How many legs has a spider?</h3>

            <form action="question.php" method="post" onsubmit="return validateAnswerSelection();">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="answer" id="answer-0" value="0">
                    <label class="form-check-label" for="single-choice-0">6</label>
                </div>
                <div class="form-check">
                <input class="form-check-input" type="radio" name="answer" id="answer-1" value="1">
                    <label class="form-check-label" for="single-choice-1">8</label>
                </div>

                <!-- hidden: lastPageID -->
                <input type="hidden" name="lastPageID" value="<?php echo $currentPageID; ?>">
                <input type="hidden" name="lastQuestionIndex" value="<?php echo $currentQuestionIndex; ?>">

                <!-- Validierungswarnung -->
                <p id="validation-warning" class="warning"></p>

                <!-- submit -->
                <button type="submit" class="btn btn-primary">Next</button>
                <p class="spacer"></p>
            </form>
        </div>
    </div>

</body>
</html>