<?php
/*
    session_start() Muss vor dem Gebrauch von $_SESSION ausgeführt werden.
    Dazu muss das data-collector.php ganz am Anfang einer Hauptseite per 
    'include' oder 'require' referenziert werden.
*/
session_start();

// Hilfswerkzeuge laden
include 'tools.php';
include 'db.php';

// DEVONLY: Gib die aktuelle $_SESSION in die Seite aus.
// prettyPrint($_SESSION, '$_SESSION = ');
?>




