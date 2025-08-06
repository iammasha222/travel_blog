<?php
/**
 * The function includes a file if it exists.
 *
 * @param string $file_path The path to the file to include.
 * @return void
 */
function filePath($path) {
    switch($path) {
        case "login":
            include '../html-pages/login.html';
            break;
        case "new_article":
            include '../html-pages/new_article.html';
            break;
        case "article":
            include '../html-pages/article.html';
            break;
        case "userPage":
            include '../html-pages/userPage.html';
            break;
        case "editPage":
            include '../html-pages/editPage.html';
            break;
        default:
            include '../html-pages/startpage.html'; 
            break;
    }
}

/**
 * 
 * The function creates a connection to the database.
 *
*/
function databaseConnection(){
    $servername = '127.0.0.1';
    $username = 'root';
    $password  = '';
    $dbname = 'blog';

    try {
        $conf = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
        return $conf;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        return null;
    }
}


/**
* The getAllTags function gets all the tags from the database and generates HTML to display them on the page.
*
*/
function getAllTags() {
    $connection = databaseConnection();
    $tagsHTML = '';
 
    if($connection){
         try {
             $sql = "SELECT name FROM tag";
             $tags = $connection->prepare($sql);
             $tags->execute();
 
             while($row = $tags->fetch(PDO::FETCH_ASSOC)){
                 $tagName = htmlspecialchars($row['name']);
                 $tagsHTML .= "<li><a href='?tag={$tagName}'></a></li>"; //creates tags links
             }
         } catch (PDOException $e) {
             echo "Connection failed: " . $e->getMessage();
         } 
     } else {
         echo "Datenbankverbindung festgeschlagen.";
     }  
     return $tagsHTML;
 }


 /**
 * This function deletes the full article from the database and the CSV file.
 *
 * @param int $requestedId Requested article ID
 */
function deleteArticle($requestedId) {
    $connection = databaseConnection();

    if($connection){
        try {
            // Delete from article_tag 
            $statement = $connection->prepare("DELETE FROM article_tag WHERE article_id = :id");
            $statement->bindParam(':id', $requestedId, PDO::PARAM_INT);
            $statement->execute();

            // Delete from the database
            $statement = $connection->prepare("DELETE FROM article WHERE id = :id");
            $statement->bindParam(':id', $requestedId, PDO::PARAM_INT);
            $statement->execute();

            // Delete from the CSV file
            $csvFile = '../assets/csv/blog-artikel_db.csv';
            if (($file = fopen($csvFile, "r+")) !== FALSE) {
                $header = fgetcsv($file, 1000, ",");

                $deleted = false;
                $lines = [];
                while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
                    $id = (int)$data[0];

                    if ($id === $requestedId) {
                        $deleted = true;
                        continue;
                    }
                    $lines[] = $data;
                }

                ftruncate($file, 0);
                fseek($file, 0);
                fputcsv($file, $header);
                foreach ($lines as $line) {
                    fputcsv($file, $line);
                }
                fclose($file);

                if ($deleted) {
                    header("Location: startpage.php");
                    exit;
                } else {
                    header("Location: startpage.php");
                    echo "Fehler beim Löschen.";
                }
            } else {
                echo "CSV-Datei kann nicht geöffnet werden.";
            }
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    } else {
        echo "Datenbankverbindung festgeschlagen.";
    }
}


/**
 * This function generate a special ID for each article and save it in csv file as first colunm. 
 * Based on the number of the rows in the csv file.
 *
 * @param string $csvFile csv file path
 * 
 */
function generateID($csvFile) {
    $articleId = 0;
    //open csv file in read mode
    if (($file = fopen($csvFile, "r")) !== FALSE) {
        fgetcsv($file);
        //find the highest existing article id
        while (($data = fgetcsv($file)) !== FALSE) {
            $id = (int)$data[0]; //take article id from current row
            if ($id > $articleId) {
                $articleId = $id; //update the highest article id when a larger one is found
            }
        }
        fclose($file);
    }
    //return the next available article id
    return $articleId + 1;
}