<?php
    include "./includes/data-collector.php"; // Muss ganz am Anfang der Hauptseite sein, enthält start_session().
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
        // Hole die $id der aktuellen Frage aus $quiz
        if (isset($quiz["questionIdSequence"])) {
            $id = $quiz["questionIdSequence"][$currentQuestionIndex];
        } 

        // Hole alle Datenfelder zur Frage mit $id von der Datenbank
        $question = fetchQuestionById($id, $dbConnection);
    ?>

    <!-- DEVONLY -->
    <div class="container">
        <div class="row">
            <div class="col-4"><?php prettyPrint($_SESSION["quiz"], "\$quiz is");?></div>
            <div class="col-6"><?php prettyPrint($question, "\$question is");?></div>
        </div>
    </div>
    <!-- END:DEVONLY -->

    <!-- FORMULAR "Fragestellung" -->
    <div class="row" style="padding: 20px;">
        <div class="col-sm-8">
            <!-- Fragestellung -->
            <h7>Frage <?php echo ($currentQuestionIndex + 1); ?> von <?php echo $quiz["questionNum"]; ?></h7>
            <h3><?php echo $question["question_text"]; ?></h3>
            <p>&nbsp;</p>

            <form id="quiz-form" action="<?php echo $actionUrl; ?>" method="post" onsubmit="return navigate('next');">
                <?php 
                    // Generiere die Antworten, entweder Radio- oder Checkbox-Buttons.

                    /*
                        Vorbereitung für die Verteilung von Antwortpunkten:

                        Zerlege den String mit den richtigen Antworten in ein Array mit id-Strings. 
                        Vermeide Leerschläge in den id-Strings.
                    */
                    $correct = $question["correct"]; // Zum Beispiel den String "1 , 3"
                    $pattern = "/\s*,\s*/"; // RegEx-Suchmuster für die Trennzeichen
                    $correctItems = preg_split($pattern, $correct); // https://www.w3schools.com/php/func_regex_preg_split.asp

                    // Verwandle die id-Strings in id-Nummern.
                    foreach($correctItems as $i => $item) {
                        $correctItems[$i] = intval($item);
                    }

                    // Entscheide, ob wir single-choice (radio) oder multiple-choice (checkbox) Antworten benötigen.
                    if (count($correctItems) > 1) $multipleChoice = true;
                    else $multipleChoice = false; // Bedeutet Single Choice

                    for ($a = 1; $a <= 5; $a++) {
                        // Setze für $answerColumnName den Namen der Tabellenspalte "answer-N" zusammen
                        $answerColumnName = "answer_" . $a;

                        // Falls es überhaupt Antworttext in $question[$answerColumnName] gibt
                        // und der Antwortext nicht leer ist, dann ...
                        if (isset($question[$answerColumnName]) && !empty($question[$answerColumnName])) {
                            // ... hole den Antworttext aus $question.
                            $answerText = $question[$answerColumnName];

                            // Entscheide für $value, wieviele Punkte die Anwort ergibt: 
                            // richtig -> 1 Punkt, falsch -> 0 Punkte
                            if (in_array($a, $correctItems, true)) $value = 1; // [1, 3]
                            else $value = 0;

                            // Gib Checkboxes oder Radio-Buttons mit Beschriftungen aus.
                            echo "\n<div class='form-check'>\n"; // Verwende "\n" für eine neue Zeile.

                            if ($multipleChoice) { 
                                // multiple choice
                                echo "  <input class='form-check-input' type='checkbox' name='$answerColumnName' id='$answerColumnName' value='$value'>\n";
                            }
                            else { 
                                // single choice
                                echo "  <input class='form-check-input' type='radio' name='single-choice' id='$answerColumnName' value='$value'>\n";
                            }

                            echo "  <label class='form-check-label' for='$answerColumnName'>$answerText</label>\n";
                            echo "</div>";
                        }
                    }
                ?>

                <!-- 
                    input type="hidden"
                        questionNum, lastQuestionIndex: mit PHP gesetzt
                        indexStep: mit JavaScript setIntValue(fieldId, value) verändert
                -->
                <input type="hidden" id="questionNum" name="questionNum" value="<?php echo $quiz["questionNum"]; ?>">
                <input type="hidden" id="lastQuestionIndex" name="lastQuestionIndex" value="<?php echo $currentQuestionIndex; ?>">
                <input type="hidden" id="multipleChoice" name="multipleChoice" value="<?php echo $multipleChoice ? 'true':'false'; ?>">
                <input type="hidden" id="indexStep" name="indexStep" value="1">

                <!-- Validierungswarnung -->
                <p id="validation-warning" class="warning"></p>

                <!-- submit -->
                <!-- button type="submit" class="btn btn-primary" onclick="navigatePrevious();">Previous</button -->
                <button type="submit" class="btn btn-primary" 
                        style="position:fixed;left:400px;bottom:50px;">Next</button>
                <p class="spacer"></p>
            </form>
        </div>
    </div>
    <?php prettyPrint($_SESSION, "\$_SESSION") ?>
</body>
</html>