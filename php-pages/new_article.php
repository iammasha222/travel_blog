<?php

//require("blog_db.php");
include '../src/lib/functions.php';
filePath('new_article');

session_start();
/**
 * Add a new article to csv file.
 *
 * @param array $articleData data of the new article as an associative array
 * @param string $csvFile path to csv file
 * @return bool if the new article was added successfully, return true
 */

 function addNewArticle() {
    $connection = databaseConnection();
    $csvFile = '../assets/csv/blog-artikel_db.csv';
 
    // Check if the form was sent
    if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_SESSION['sessionLog']) && $_SESSION['sessionLog'] === true) {
        // Read data from article
        $title = isset($_POST["title"]) ? htmlspecialchars($_POST["title"]) : 'no data';
        $formattedDate = isset($_POST["date"]) ? date("Y-m-d", strtotime(str_replace('.', '-', $_POST["date"]))) : date("Y-m-d");
        $photo = isset($_FILES["photo"]["name"]) ? htmlspecialchars($_FILES["photo"]["name"]) : '';
        $photo_path = '../assets/img/' . $photo;
        $author = $_SESSION['username']; // Use the author's email from the session
        $text = isset($_POST["text"]) ? htmlspecialchars($_POST["text"]) : '';
        $tags = isset($_POST["tags"]) ? htmlspecialchars($_POST["tags"]) : '';
        $tagsArray = array_map('trim', explode(',', $tags));
        $approval = isset($_POST["approval"]) ? htmlspecialchars($_POST["approval"]) : '0';
        $csvFile = '../assets/csv/blog-artikel_db.csv';

        // Handle photo upload
        if ($photo && !move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path)) {
            echo "Error uploading photo.";
            return false;
        }
        
        if($connection){
            try {
                // Fetch author full name from database
                $sql = "
                        SELECT CONCAT(forname, ' ', surname) AS authorName 
                        FROM user 
                        WHERE email = :email
                        ";
                $authorName = $connection->prepare($sql);
                $authorName->bindParam(':email', $author);
                $authorName->execute();
                $author = $authorName->fetchColumn();

                // Insert article into the database
                $sql = "INSERT INTO article (Title, Image, Text, Date, Author, Online)
                        VALUES (:Title, :Image, :Text, :Date, :Author, :Online);";
                $result = $connection->prepare($sql);
                $values = [
                    ":Title" => $title,
                    ":Image" => $photo_path,
                    ":Text" => $text,
                    ":Date" => $formattedDate,
                    ":Author" => $author,
                    ":Online" => $approval
                ];
                $result->execute($values);

                $articleId = $connection->lastInsertId();

                foreach ($tagsArray as $tag) {
                    // Check if tag already exists
                    $sqlTag = "SELECT id FROM tag WHERE name = :name";
                    $resultTag = $connection->prepare($sqlTag);
                    $resultTag->execute([":name" => $tag]);
                    $tagId = $resultTag->fetchColumn();

                    // Add, if the tag does not exist
                    if (!$tagId) {
                        $sqlTagInsert = "
                                        INSERT INTO tag (name) 
                                        VALUES (:name)
                                        ";
                        $resultTagInsert = $connection->prepare($sqlTagInsert);
                        $resultTagInsert -> execute([":name" => $tag]);
                        $tagId = $connection->lastInsertId();
                    }

                    // Add to article_tag table
                    $sqlArticleTag = "
                                    INSERT INTO article_tag (article_id, tag_id) 
                                    VALUES (:article_id, :tag_id)
                                    ";
                    $resultArticleTag = $connection->prepare($sqlArticleTag);
                    $resultArticleTag->execute([":article_id" => $articleId, ":tag_id" => $tagId]);
                }

                // Prepare new article array
                $newArticle = [
                    $articleId, $title, $photo_path, $text, $formattedDate, $author, implode(',', $tagsArray), $approval
                ];

                // Add the new article to the CSV file
                $fp = fopen($csvFile, 'a'); // "a" - append (hinzufügen)
                if ($fp) {
                        // Check if the file already exists
                        if (!file_exists($csvFile) || filesize($csvFile) === 0) {
                            fputcsv($fp, ['Article ID', 'Title', 'Image', 'Text', 'Date', 'Author', 'Tags', 'Approval']);
                        }

                        // Add article content to csv file
                        fputcsv($fp, $newArticle);

                        // Close csv file
                        fclose($fp);
                        header("Location: startpage.php");
                        return true;
                    } else {
                        echo "Fehler beim Hinzufügen des Artikels in die CSV-Datei.";
                        return false;
                    }
            } catch (PDOException $e) {
                echo "Failed to insert article: " . $e->getMessage();
            }
        } else {
            echo "Datenbankverbindung festgeschlagen.";
        }
    } else{
        echo "Hinweis: Sie müssen sich <a href='login.php'> anmelden</a>, um einen neuen Artikel hinzufügen zu können.";
    }
}
addNewArticle();
