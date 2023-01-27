<?php
/*
    session_start() Muss vor dem Gebrauch von $_SESSION ausgeführt werden.
    Dazu muss das data-collector.php ganz am Anfang einer Hauptseite per 
    'include' oder 'require' referenziert werden.
*/
session_start();

// Hilfswerkzeuge laden
include 'tools.php';

/*
    Hole die Indexnummer der letzten Frage aus $_POST "lastQuestionIndex".
    $lastQuestionIndex wird für question.php und report.php verwendet, jedoch
    nicht für index.php.
*/
if (isset($_POST["lastQuestionIndex"])) {
    // https://www.php.net/manual/en/function.intval.php
    $lastQuestionIndex = intval($_POST["lastQuestionIndex"]);
}
else {
    // -1 soll bedeuten, dass das Quiz noch nicht gestartet wurde.
    $lastQuestionIndex = -1;
}

// Abhängig von der aktuellen Hauptseite: Bereite die benötigten Seitendaten vor.
$scriptName = $_SERVER['SCRIPT_NAME']; // https://www.php.net/manual/en/reserved.variables.server.php
echo "scriptName = " . $scriptName . "<br>";

if (str_contains($scriptName, 'index')) { // https://www.php.net/manual/en/function.str-contains.php
    // index.php (Startseite) ----------------------------------------------------------------

    // Lösche die Daten in der $_SESSION.
    session_unset();

    // Setze das Quiz explizit in $_SESSION zurück.
    $_SESSION["quiz"] = null;
}
else if (str_contains($scriptName, 'question')) {
    // question.php (Frageseite) -------------------------------------------------------------

    if ($lastQuestionIndex === -1) { // -1 bedeutet, dass das Quiz noch nicht gestartet wurde.
        // Starte ein neues Quiz ...
        $quiz = array(
            "topic" => $_POST["topic"], 
            "questionNum" => $_POST["questionNum"],
            "lastQuestionIndex" => $lastQuestionIndex,
            "currentQuestionIndex" => -1,
            "questionIdSequence" => array()
        );
    
        // ... und speichere die Quiz-Daten als "quiz" in $_SESSION.
        $_SESSION["quiz"] = $quiz;
    }
    else {
        $quiz = $_SESSION["quiz"];
    }

    /*
        Variable für den index-Schritt setzen.

        -1 bedeutet "vorangehender Frage-Index".
         1 bedeutet "nächster Frage-Index".

         Wichtig: "Frage-Index" steht für den Index im "questionIdSequence"-Array,
                  NICHT für die "id" der Frage in der Tabelle.
    */
    $indexStep = 1;

    if (isset($_POST["indexStep"])) {
        // https://www.php.net/manual/en/function.intval.php
        $indexStep = intval($_POST["indexStep"]);
    }

    // Index der aktuellen Frage, sowie für das Quiz setzen.
    $currentQuestionIndex = $lastQuestionIndex + $indexStep;
    $quiz["currentQuestionIndex"] = $currentQuestionIndex;

    // Anhand des $currentQuestionIndex entscheiden, wie's weitergeht.
    if ($currentQuestionIndex < 0) {
        // Navigation von der 1. Frage zur Startseite: zur Startseite springen.
    }
    else if ($currentQuestionIndex < $quiz["questionNum"]) {
        // Fragestellung anzeigen 
    }
    else { // $currentQuestionIndex >= $quiz["questionNum"]
        // Zur Auswertungsseite springen
    }

    // Speichere alle Daten der letzten Frage in der Session.
    if ($lastQuestionIndex >= 0) {
        $questionName = "question-" . $lastQuestionIndex;
        $_SESSION[$questionName] = $_POST;
    }
}
else if (str_contains($scriptName, 'report')) {
    // report.php (Auswertungsseite) ---------------------------------------------------------

    // Speichere alle Daten der letzten Frage in der Session.
    if ($lastQuestionIndex >= 0) {
        $questionName = "question-" . $lastQuestionIndex;
        $_SESSION[$questionName] = $_POST;
    }

}
else {
    // Unbekannte URL
}

// DEVONLY: Gib die aktuelle $_SESSION in die Seite aus.
prettyPrint($_SESSION, '$_SESSION = ');

?>




