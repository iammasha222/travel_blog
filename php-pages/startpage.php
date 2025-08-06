<?php

session_start();

$file_path = '../html-pages/startpage.html';
include '../src/lib/functions.php';

if (file_exists($file_path)) {
    $tagFilter = isset($_GET['tag']) ? $_GET['tag'] : null; //Check if there is a tag filter in GET parameters
    if (isset($_SESSION['sessionLog']) && $_SESSION['sessionLog'] === true) {
        $articlesHTML = getArticles(true, $tagFilter); //display all article
    } else {
        $articlesHTML = getArticles(false, $tagFilter); //display article only with approval
    }

    $tagsSort = getAllTags();
    $htmlTemplate = file_get_contents($file_path);
    $htmlTemplate = str_replace('{{articles}}', $articlesHTML, $htmlTemplate);
    $htmlTemplate = str_replace('{{tags}}', $tagsSort, $htmlTemplate);
    echo $htmlTemplate;

} else {
    echo "File $file_path not found.";
}
/**
 * This function get the content of an article from csv file and display it as an article block at the startpage of blog.
 * 
 * @param bool $showAll Determines whether to display all articles or only approved ones.
 * @param string|null $tagFilter Filter by tags, if you want to display articles with a specific tag.
 *
*/
//tagFilter is optional and if you don't use it, it will be "null"
/* function getArticles($showAll, $tagFilter = null) {
    $connection = databaseConnection(); 

    if($connection){
        try {
            
            //SQL query to get articles and their tags
            $sql = "SELECT article.*, GROUP_CONCAT(tag.name) AS tags
                    FROM article
                    JOIN article_tag 
                        ON article.id = article_tag.article_id
                    JOIN tag 
                        ON article_tag.tag_id = tag.id
                    ";
                    
            // shows only published articles
            if (!$showAll) {
                $sql .= " WHERE article.online = 1";
            }
            
            if ($tagFilter) {
                //If a WHERE condition already exists, use AND
                if(!$showAll){
                    $sql .= " AND";
                } else {
                    $sql .= " WHERE";
                }
                $sql .= " tag.name = :tagFilter";
            }

            $sql .= " GROUP BY article.id";
            $article = $connection->prepare($sql);
            
            // Bind the tag value to the request
            if ($tagFilter) {
                $article->bindParam(':tagFilter', $tagFilter);
            }

            $article->execute();
            $articlesHTML = ''; 

            while($row = $article->fetch(PDO::FETCH_ASSOC)){
                $id = htmlspecialchars($row['ID']);
                $title = htmlspecialchars($row['Title']); 
                $image = htmlspecialchars($row['Image']); 
                $text = htmlspecialchars($row['Text']);
                $formattedDate = date("d.m.Y", strtotime($row['Date']));
                $author = htmlspecialchars($row['Author']);
                $tags = htmlspecialchars($row['tags']);

                $approval = isset($row['Online']) ? htmlspecialchars($row['Online']) : '0';
                $approvalMessage = $approval === "0" ? "Der Artikel ist noch in Bearbeitung.<br> Nur angemeldete Benutzer können es sehen." : "";

                //shows all tags
                $tagsArray = array_map('trim', explode(',', $tags));
                $tagsDisplay = '';
                foreach ($tagsArray as $tag) {
                    $tagsDisplay .= "<a href='?tag={$tag}'>#" . htmlspecialchars($tag) . "</a> ";
                }

                //shows preview only 100 characters
                $contentPreview = strlen($text) > 100 ? substr($text, 0, 100) . '...' : $text;

                $articlesHTML .= "
                <article>
                    <p class='error'>{$approvalMessage}</p>
                    <h2>{$title}</h2>
                    <div>
                        <p>Autor: {$author}</p>
                        <p>Datum: {$formattedDate}</p>
                        <p>{$tagsDisplay}</p>
                    </div>
                    <img class='marg2' src='{$image}' alt='Bild'>
                    <div>
                        <p>{$contentPreview}</p>
                    </div>
                    <a class='link' href='article.php?id={$id}'>Zum Artikel</a>
                    <hr>
                </article>"; 
            } 
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        } 
    } else {
        echo "Datenbankverbindung festgeschlagen.";
    }
        
    return $articlesHTML;
} */
function getArticles($showAll, $tagFilter = null) {
    $connection = databaseConnection(); 

    if($connection){
        try {
            $sql = "SELECT * FROM article";

            if (!$showAll) {
                $sql .= " WHERE online = 1";
            }

            if ($tagFilter) {
                // Если уже есть WHERE, добавляем AND, иначе WHERE
                if (!$showAll) {
                    $sql .= " AND";
                } else {
                    $sql .= " WHERE";
                }
                $sql .= " tags LIKE :tagFilter";  // Предположим, теги в поле tags как строка
            }

            $sql .= " GROUP BY id";

            $article = $connection->prepare($sql);

            if ($tagFilter) {
                $tagLike = '%' . $tagFilter . '%';
                $article->bindParam(':tagFilter', $tagLike);
            }

            $article->execute();
            $articlesHTML = ''; 

            while($row = $article->fetch(PDO::FETCH_ASSOC)){
                // Обрати внимание на регистр ключей — у тебя в базе поля, скорее всего, в нижнем регистре
                $id = htmlspecialchars($row['ID']);
                $title = htmlspecialchars($row['Title']); 
                $image = htmlspecialchars($row['Image']); 
                $text = htmlspecialchars($row['Text']);
                $formattedDate = date("d.m.Y", strtotime($row['Date']));
                $author = htmlspecialchars($row['Author']);
                $tags = htmlspecialchars(isset($row['tags']) ? $row['tags'] : '');

                $approval = isset($row['Online']) ? htmlspecialchars($row['Online']) : '0';
                $approvalMessage = $approval === "0" ? "Der Artikel ist noch in Bearbeitung.<br> Nur angemeldete Benutzer können es sehen." : "";

                //shows all tags
                $tagsArray = array_map('trim', explode(',', $tags));
                $tagsDisplay = '';
                foreach ($tagsArray as $tag) {
                    $tagsDisplay .= "<a href='?tag={$tag}'>#" . htmlspecialchars($tag) . "</a> ";
                }

                //shows preview only 100 characters
                $contentPreview = strlen($text) > 100 ? substr($text, 0, 100) . '...' : $text;

                $articlesHTML .= "
                <article>
                    <p class='error'>{$approvalMessage}</p>
                    <h2>{$title}</h2>
                    <div>
                        <p>Autor: {$author}</p>
                        <p>Datum: {$formattedDate}</p>
                        <p>{$tagsDisplay}</p>
                    </div>
                    <img class='marg2' src='{$image}' alt='Bild'>
                    <div>
                        <p>{$contentPreview}</p>
                    </div>
                    <a class='link' href='article.php?id={$id}'>Zum Artikel</a>
                    <hr>
                </article>"; 
            } 
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        } 
    } else {
        echo "Datenbankverbindung festgeschlagen.";
    }
        
    return $articlesHTML;
}



