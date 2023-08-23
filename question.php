<?php
    /* Muss ganz am Anfang der Hauptseite sein, 
        enthält start_session(). */
    require "./includes/data-collector.php"; 
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
        // END NEW -------------------------------------------------

        /*
            Hole die Liste (array) von Frage-id-Nummern für das ganze Quiz.
            Mögliches Resultat: [3, 5, 1, 17, 29, 7, 11, 119]

            Vorbereitung:
            a) Hole aus $_POST den Wert für $topic
            b) Hole aus $_POST den Wert für $questionNum
            c) definiere fetchQuestionIdSequence() in db.php

            Test:
            d) zeige mit prettyPrint() den Wert von $questionIdSequence
        */
        if (isset($_POST["topic"])) $topic = $_POST["topic"];
        else $topic = 'music';

        if (isset($_POST["questionNum"])) $questionNum = $_POST["questionNum"];
        else $questionNum = 5;

        $questionIdSequence = fetchQuestionIdSequence($topic, $questionNum, $dbConnection);
        prettyPrint($questionIdSequence, "Question ID Sequence");
        // END NEW -------------------------------------------------

        // Hole die Daten für die aktuelle Frage aus der Datenbank.
        $questionId = 1;
        $question = fetchQuestionById($questionId, $dbConnection);

        prettyPrint($question, "Question");
        exit("see you later ...");








        // Bestimme die Anzahl der verfügbaren Fragen
        if (isset($quiz["questionIdSequence"])) {
            $id = $quiz["questionIdSequence"][$currentQuestionIndex];
        } 

        // Hole alle Datenfelder zur Frage mit $id von der Datenbank
        $question = fetchQuestionById($id, $dbConnection);
    ?>

    <!-- FORMULAR "Fragestellung" -->
    <div class="row" style="padding: 20px;">
        <div class="col-sm-8">
            <!-- Fragestellung -->
            <h7>Frage <?php echo ($currentQuestionIndex + 1); ?> von <?php echo $quiz["questionNum"]; ?></h7>
            <!--p>&nbsp;</p-->
            <h3><?php echo $question["question_text"]; ?></h3>
            <p>&nbsp;</p>

            <form id="quiz-form" action="<?php echo $actionUrl; ?>" method="post" onsubmit="return navigate('next');">
                <?php 
                    // Generiere Antwort-Radio-Buttons mit Beschriftung

                    // Single Choice: Hole den Namen der richtigen Antwortspalte in $correct, aus $question["correct"]
                    $correct = $question["correct"];

                    for ($a = 1; $a <= 5; $a++) {
                        // Setze für $answerColumnName den Namen der Tabellenspalte "answer-N" zusammen
                        $answerColumnName = "answer-" . $a;

                        // Falls es überhaupt Antworttext in $question[$answerColumnName] gibt
                        // und der Antwortext nicht gleich '', dann ...
                        if (isset($question[$answerColumnName]) && $question[$answerColumnName] !== '') {
                            // ... hole den Antworttext aus $question.
                            $answerText = $question[$answerColumnName];

                            // Entscheide für $value, wieviele Punkte die Anwort ergibt: 
                            // richtig -> 1 Punkt, falsch -> 0 Punkte
                            if ($correct === $answerColumnName) $value = 1;
                            else $value = 0;

                            echo "<div class='form-check'>
                                    <input class='form-check-input' type='radio' name='single-choice' id='$answerColumnName' value='$value'>
                                    <label class='form-check-label' for='$answerColumnName'>$answerText</label>
                                  </div>";
                        }
                    }
                ?>

                <!-- 
                    input type="hidden"
                        questionNum, lastQuestionIndex: mit PHP gesetzt
                        indexStep: mit JavaScript setIntValue(fieldId, value) verändert
                -->
                <input type="hidden" id="questionNum" value="<?php echo $quiz["questionNum"]; ?>">
                <input type="hidden" id="lastQuestionIndex" name="lastQuestionIndex" value="<?php echo $currentQuestionIndex; ?> ">
                <input type="hidden" id="indexStep" name="indexStep" value="1">

                <!-- Validierungswarnung -->
                <p id="validation-warning" class="warning"></p>
                <p>&nbsp;</p>
                <!-- button type="submit" class="btn btn-primary" onclick="navigatePrevious();">Previous</button -->
                <input type="submit" class="btn btn-primary" value="Next">
            </form>
        </div>
    </div>

</body>
</html>