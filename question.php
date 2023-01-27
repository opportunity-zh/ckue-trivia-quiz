<?php
    require "./includes/data-collector.php"; // Muss ganz am Anfang der Hauptseite sein, enthält start_session().
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
            <h7>Frage <?php echo ($currentQuestionIndex + 1); ?> von <?php echo $quiz["questionNum"]; ?></h7>
            <h3>Wieviele Beine hat eine Spinne?</h3>

            <form id="quiz-form" action="question.php" method="post" onsubmit="return navigate('next');">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="answer" id="answer-0" value="0">
                    <label class="form-check-label" for="single-choice-0">6</label>
                </div>
                <div class="form-check">
                <input class="form-check-input" type="radio" name="answer" id="answer-1" value="1">
                    <label class="form-check-label" for="single-choice-1">8</label>
                </div>

                <!-- 
                    input type="hidden"
                        questionNum, lastQuestionIndex: mit PHP gesetzt
                        indexStep: mit JavaScript setIntValue(fieldId, value) verändert
                -->
                <input type="hidden" id="questionNum" value="<?php echo $quiz["questionNum"]; ?>">
                <input type="hidden" id="lastQuestionIndex" name="lastQuestionIndex" value="<?php echo $currentQuestionIndex; ?>">
                <input type="hidden" id="indexStep" name="indexStep" value="1">

                <!-- Validierungswarnung -->
                <p id="validation-warning" class="warning"></p>

                <!-- submit -->
                <button type="submit" class="btn btn-primary" onclick="navigatePrevious();">Previous</button>
                <button type="submit" class="btn btn-primary">Next</button>
                <p class="spacer"></p>
            </form>
        </div>
    </div>

</body>
</html>