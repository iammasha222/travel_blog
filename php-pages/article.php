<?php

include '../src/lib/functions.php';
filePath('article');

session_start();

/**
 * This function displays the full article content based on its ID from the database.
 *
 * @param int $requestedId Requested article ID
 */
function showArticle($requestedId) {
    //Create a connection to the database 
    $connection = databaseConnection();

    if($connection){
        try {
            $statement = $connection->prepare("
    SELECT article.*, GROUP_CONCAT(tag.name) AS tags
    FROM article
    LEFT JOIN article_tag 
        ON article.id = article_tag.article_id
    LEFT JOIN tag 
        ON article_tag.tag_id = tag.id
    WHERE article.id = :id
    GROUP BY article.id
");
            //Binds a parameter to the specified variable name
            $statement->bindParam(':id', $requestedId, PDO::PARAM_INT);
            $statement->execute();

            if ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $title = htmlspecialchars($row['Title']);
                $image = htmlspecialchars($row['Image']);
                $content = htmlspecialchars($row['Text']);
                $date = date("d.m.Y", strtotime($row['Date']));
                $author = htmlspecialchars($row['Author']);
                $tags = htmlspecialchars($row['tags']);
                $approval = isset($row['Online']) ? htmlspecialchars($row['Online']) : '0';
                $approvalMessage = $approval === "0" ? "Der Artikel ist noch in Bearbeitung.<br> Nur angemeldete Benutzer können es sehen." : "";

                // Display tags as hashtags
                $tagsArray = array_map('trim', explode(',', $tags));
                $tagsDisplay = '';
                foreach ($tagsArray as $tag) {
                    $tagsDisplay .= '#' . htmlspecialchars($tag) . ' ';
                }

                echo "<!DOCTYPE html>
                    <html lang='de'>
                    <head>
                        <meta charset='UTF-8'>
                        <link rel='stylesheet' href='../assets/css/main.css'>
                        <title>{$title}</title>
                    </head>
                    <body>
                        <div class='pageWidth'>
                            <div class='breadcrumbs'>
                                <a class='link' href='../php-pages/startpage.php'>Startseite  |</a>
                                <a class='link' href='../php-pages/new_article.php'>Neuen Artikel anlegen | </a>
                                <a class='link' href='../php-pages/login.php'>Login</a>
                            </div>
                            <h1>{$title}</h1>
                            <hr>
                            <div class='breadcrumbs'>
                            <form method='post' action='editPage.php'>
                                    <input type='hidden' name='edit_id' value='{$requestedId}'>
                                    <button class='delete' type='submit'>Artikel bearbeiten |</button>
                                </form>
                            
                                <form method='post' action=''>
                                    <input type='hidden' name='delete_id' value='{$requestedId}'>
                                    <button class='delete' type='submit'>Artikel löschen</button>
                                </form>
                            </div>
                            <p class='error'>{$approvalMessage}</p>
                            <br>
                            <img class='marg2' src='{$image}' alt='Bild'>
                            <p>{$tagsDisplay}</p>
                            <p class='textBold'>Autor: {$author}</p>
                            <p>Datum: {$date}</p>
                            <p>{$content}</p>
                            <div class='end marg2'>
                                <p>© 2021 |</p>
                                <a class='link' href='../php-pages/impressum.php'>Impressum</a>
                            </div>
                        </div>
                    </body>
                    </html>";
            } else {
                echo "<p>Artikel nicht gefunden.</p>";
            }
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    } else{
        echo "Datenbankverbindung festgeschlagen.";
    }
}

// Display the article
if (isset($_GET['id'])) {
    $requestedId = (int)$_GET['id'];
    showArticle($requestedId);
}

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id']) && isset($_SESSION['sessionLog']) && $_SESSION['sessionLog'] === true) {
    $deleteId = (int)$_POST['delete_id'];
    deleteArticle($deleteId);
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo "Sie müssen sich <a href='login.php'> anmelden</a>, um einen Artikel löschen zu können.";
    }
} 