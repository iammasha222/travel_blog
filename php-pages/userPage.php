<?php

session_start();

$file_path = "../html-pages/userPage.html";
if (file_exists($file_path)) {
    $htmlTemplate = file_get_contents($file_path);
} else {
    echo "Datei nicht gefunden.";
    exit();
}


if (isset($_SESSION['sessionLog']) && $_SESSION['sessionLog'] === true) {
    $email = htmlspecialchars($_SESSION['username']);

    $usernames = [
        "viola_meridiane@gmail.com" => "Viola Meridiane",
        "jan_nordland@gmail.com" => "Jan Nordland",
        "bill_darrent@gmail.com" => "Bill Darrent",
        "adora_viagem@gmail.com" => "Adora Viagem"
    ];

    if (array_key_exists($email, $usernames)) {
        $username = $usernames[$email];
        $htmlTemplate = str_replace('###', $username, $htmlTemplate);
        echo $htmlTemplate;
    } else {
        echo "Der Nutzer existiert nicht.";
        header("Location: login.php");
    }
} else {
    echo "Sie sind nicht eingeloggt.";
    exit();
}
