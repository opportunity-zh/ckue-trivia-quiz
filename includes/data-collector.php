<?php
/*
    session_start() Muss vor dem Gebrauch von $_SESSION ausgeführt werden.
    Dazu muss das data-collector.php ganz am Anfang einer Hauptseite per 
    'include' oder 'require' referenziert werden.

    CAUTION: Certain settings in nginx/conf.d/php.conf force the 'index' to
             be the single point of entry. This may erase the content of the
             $_SESSION because of a redirect over index.php with session_unset().
*/
session_start();

// Hilfswerkzeuge laden
include 'tools.php'; // prettyPrint() laden
include 'db.php';    // Datenbank-Verbindung $dbConnection aufbauen

// Falls verfügbar, hole die Quiz-Daten aus der Session.
if (isset($_SESSION["quiz"])) $quiz = $_SESSION["quiz"];
else $quiz = null;

/*
    Hole die Indexnummer der letzten Frage aus $_POST "lastQuestionIndex".
    $lastQuestionIndex wird für question.php und report.php verwendet, jedoch
    nicht für index.php.
*/
if (isset($_POST["lastQuestionIndex"])) {
    // https://www.php.net/manual/en/function.intval.php
    $lastQuestionIndex = intval($_POST["lastQuestionIndex"]);

    // Nur für gültige Fragenindexe: Post-Daten in $_SESSION speichern.
    if ($lastQuestionIndex >= 0) {
        $questionName = "question-" . $lastQuestionIndex;
        $_SESSION[$questionName] = $_POST;
    }
}
else {
    // -1 soll bedeuten, dass das Quiz noch nicht gestartet wurde.
    $lastQuestionIndex = -1;
}

// Abhängig von der aktuellen Hauptseite: Bereite die benötigten Seitendaten vor.
$scriptName = $_SERVER['SCRIPT_NAME']; // https://www.php.net/manual/en/reserved.variables.server.php

// index.php (Startseite) ----------------------------------------------------------------
if (str_contains($scriptName, 'index')) {
    // Lösche die Daten, inklusive bestehende Quiz-Daten in der $_SESSION.
    session_unset();

    // Setze explizit auch $quiz zurück (Konsistenz gegenüber Session).
    $quiz = null;
}
// question.php (Frageseite) -------------------------------------------------------------
else if (str_contains($scriptName, 'question')) {
    // Quiz-Daten vorbereiten
    if ($quiz === null) { // Falls noch keine $quiz Daten verfügbar sind ...
        // Hole die Anzahl Fragen aus dem $_POST.
        $questionNum = intval($_POST["questionNum"]);

        // Hole die Sequenz der Frage 'id'-s aus der Datenbank.
        $questionIdSequence = fetchQuestionIdSequence(
            $_POST["topic"], 
            $questionNum, 
            $dbConnection
        );

        // Berechne die wirklich mögliche Anzahl von Fragen.
        $questionNum = count($questionIdSequence);

        // Sammle Quiz-Daten in $quiz und speicher $quiz in der Session.
        $quiz = array(
            "topic" => $_POST["topic"], 
            "questionNum" => $questionNum,
            "lastQuestionIndex" => $lastQuestionIndex,
            "currentQuestionIndex" => -1,
            "questionIdSequence" => $questionIdSequence
        );

        $_SESSION["quiz"] = $quiz;

        // DEVONLY
        // prettyPrint($_SESSION["quiz"], "\$quiz is");
    }

    // Index der aktuellen Frage, sowie für das Quiz setzen.
    $currentQuestionIndex = $lastQuestionIndex + 1;

    if ($currentQuestionIndex >= $quiz["questionNum"] - 1) {
        // Auf die report.php-Seite springen.
        $actionUrl = "report.php";
    }
    else {
        // Die nächste Frage darstellen.
        $actionUrl = "question.php";
    }
}
// report.php (Auswertungsseite) -------------------------------------------------------------
else if (str_contains($scriptName, 'report')) {

}














?>




