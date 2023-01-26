<?php
/*
    Muss vor dem Gebrauch von $_SESSION ausgeführt werden.
    Am Besten ganz am Anfang einer Webseite, bevor irgendwelche 
    andere PHP-Skripte ausgeführt werden.
*/
session_start();

// Hilfswerkzeuge laden
include 'tools.php';

// Hole den Namen der letzten Seite aus $_POST "lastPageID".
if (isset($_POST["lastPageID"])) {
    $lastPageID = $_POST["lastPageID"];
}

// Hole die Indexnummer der letzten Frage aus $_POST "lastQuestionIndex".
if (isset($_POST["quiz-last-question-index"])) {
    // https://www.php.net/manual/en/function.intval.php
    $lastQuestionIndex = intval($_POST["quiz-last-question-index"]);
}
else {
    $lastQuestionIndex = -1; // -1 bedeutet, dass das Quiz noch nicht gestartet wurde.
}

// index.php -> question.php: neues Quiz starten
if ($lastQuestionIndex === -1 && isset($_POST["topic"])) {
    $quiz = array(
        "topic" => $_POST["topic"], 
        "questionNum" => $_POST["questionNum"],
        "lastQuestionIndex" => $lastQuestionIndex,
        "questionIdSequence" => array()
    );

    $_SESSION["quiz"] = $quiz;
}

// Speichere alle Daten des letzen Posts mit den Namen $lastPageID in der Session.
$_SESSION[$lastPageID] = $_POST;

// DEVONLY: Gib die aktuelle $_SESSION in die Seite aus.
prettyPrint($_SESSION, '$_SESSION = ');

?>




