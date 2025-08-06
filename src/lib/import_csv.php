<?php
require_once 'functions.php';

$csvFile = '../../assets/csv/blog-artikel_db.csv';

$connection = databaseConnection();

if (!$connection) {
    die("Datenbankverbindung fehlgeschlagen.");
}

if (!file_exists($csvFile)) {
    die("CSV-Datei nicht gefunden: $csvFile");
}

if (($handle = fopen($csvFile, "r")) !== FALSE) {
    $header = fgetcsv($handle); // skip header row

    $insertCount = 0;
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if (count($data) < 7) {
            echo "Übersprungene Zeile wegen unvollständiger Daten: " . implode(", ", $data) . "<br>";
            continue;
        }

        // Read values
        [$id, $title, $image, $text, $date, $author, $tags, $online] = $data;

        // Prepare insert
        $stmt = $connection->prepare("
            INSERT INTO article (ID, Title, Image, Text, Date, Author, Tags, Online) 
            VALUES (:id, :title, :image, :text, :date, :author, :tags, :online)
            ON DUPLICATE KEY UPDATE 
                Title = VALUES(Title),
                Image = VALUES(Image),
                Text = VALUES(Text),
                Date = VALUES(Date),
                Author = VALUES(Author),
                Tags = VALUES(Tags),
                Online = VALUES(Online)
        ");

        // Execute insert
        $stmt->execute([
            ':id' => $id,
            ':title' => $title,
            ':image' => $image,
            ':text' => $text,
            ':date' => $date,
            ':author' => $author,
            ':tags' => $tags,
            ':online' => $online,
        ]);

        $insertCount++;
    }

    fclose($handle);
    echo "Import erfolgreich abgeschlossen. $insertCount Artikel importiert.";
} else {
    echo "Fehler beim Öffnen der CSV-Datei.";
}
