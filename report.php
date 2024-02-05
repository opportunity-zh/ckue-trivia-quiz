<?php
    include "./includes/data-collector.php"; // Muss zuerst sein wegen start_session()
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
        /*
            Bestimme die Anzahl der erreichten Punkte. Dazu wird das
            'value'-Attribut des Feldes 'single-choice' ausgewertet.

            Wichtig: Sämtliche $_SESSION-Werte müssen fertig gesetzt sein,
                     bevor die Punktzahlen gesammelt werden dürfen.
        */
        $totalPoints = 0;
        $maxTotalPoints = 0;

        foreach ($_SESSION as $questionKey => $data) {
            if (str_contains($questionKey, 'question-')) {
                if ($data["multipleChoice"] === 'true') { 
                    // Multiple Choice: checkboxes
                    foreach ($data as $key => $value) {
                        if (str_contains($key, 'answer_')) {
                            $points = intval($value);
                            $totalPoints = $totalPoints + $points; // Kurzform: $totalPoints += $points;
                        }
                    }
                }
                else if ($data["multipleChoice"] === 'false') { 
                    // Single Choice: radio buttons

                    // Falls keine Antwort gewählt wurde fehlt "single-choice" im $_POST.
                    if (isset($data["single-choice"])) { 
                        $points = intval($data["single-choice"]);
                        $totalPoints = $totalPoints + $points; // Kurzform: $totalPoints += $points;
                    }
                }

                $maxTotalPoints = $maxTotalPoints + intval($data["maxPoints"]); // Kurzform: $maxTotalPoints += intval($data["maxPoints"]);
            }
        }
    ?>

    <div class="row" style="padding: 20px;">
        <div class="col-sm-8">
            <!-- Bilanz -->
            <h7>Congratulations!</h7>
            <p>&nbsp;</p>
            <h3>You achieved <?php echo $totalPoints; ?> out of 
                    possible <?php echo $maxTotalPoints; ?> points.</h3>

        </div>
        <p>&nbsp;</p>
        <button class="btn btn-primary" onclick="document.location='/index.php';"
                style="position:fixed;bottom:150px;">Neues Quiz</button>
    </div>

</body>
</html>