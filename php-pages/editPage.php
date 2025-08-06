<?php

$file_path = "../html.pages/editPage.html";
include '../src/lib/functions.php';
/* *
 * This function allowed to edit the content of an article.
 *
 * @param string $csvFile csv file path
 * @param int $requestedId requsted article id
 */
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id']) && isset($_SESSION['sessionLog']) && $_SESSION['sessionLog'] === true) {
    $editId = (int)$_POST['edit_id'];
    editArticle($editId);
} else {
    echo "Sie müssen sich <a href='login.php'> anmelden</a>, um einen neuen Artikel bearbeiten zu können.";
}

function editArticle($requestedId) {
    $connection = databaseConnection();

    if($connection){
        try {
            $statement = $connection->prepare("
                                        SELECT * 
                                        FROM article 
                                        WHERE id = :id");
            $statement->bindParam(':id', $requestedId, PDO::PARAM_INT);
            $statement->execute();
            $article = $statement->fetch(PDO::FETCH_ASSOC);

            if ($article) {
                $title = htmlspecialchars($article['Title']);
                $image = htmlspecialchars($article['Image']);
                $content = htmlspecialchars($article['Text']);
                $author = htmlspecialchars($article['Author']);
                $date = date("Y-m-d", strtotime($article['Date']));
                $approval = htmlspecialchars($article['Online']);

                // Render edit form
                echo "
                <!DOCTYPE html>
                <html lang='de'>
                <head>
                    <meta charset='UTF-8'>
                    <link rel='stylesheet' href='../assets/css/main.css'>
                    <title>Artikel bearbeiten</title>
                </head>
                <body>
                    <div class='pageWidth'>
                        <div class='breadcrumbs'>
                            <a class='link' href='../php-pages/startpage.php'>Startseite  |</a>
                            <a class='link' href='../php-pages/new_article.php'>Neuen Artikel anlegen | </a>
                            <a class='link' href='../php-pages/login.php'>Login</a>
                        </div>
                        <h1>Artikel bearbeiten</h1>
                        <hr>
                        <form method='post' action='' enctype='multipart/form-data'>
                            <input type='hidden' name='save_id' value='{$requestedId}'>
                            <div>
                                <p id='title' class='marg input'>Titel:</p>
                                <input class='inputField' type='text' id='title' name='title' value='{$title}' required>
                            </div>
                            <div>
                                <p id='photo' class='marg input'>Bild:</p>
                                <input class='inputField' type='file' id='image' name='image'>
                                <input type='hidden' name='existImage' value='{$image}'>
                                <div>
                                    <input type='checkbox' id='delete_image' name='delete_image'>
                                    <label for='delete_image'>Kein Bild</label>
                                </div>
                            </div>
                            <div>
                                <p id='author' class='marg input'>Autor</p>
                                <select name='author' class='inputField extra' required>
                                    <option value='Jan Nordland' " . ($author == 'Jan Nordland' ? 'selected' : '') . ">Jan Nordland</option>
                                    <option value='Bill Darrent' " . ($author == 'Bill Darrent' ? 'selected' : '') . ">Bill Darrent</option>
                                    <option value='Viola Meridiane' " . ($author == 'Viola Meridiane' ? 'selected' : '') . ">Viola Meridiane</option>
                                    <option value='Adora Viagem' " . ($author == 'Adora Viagem' ? 'selected' : '') . ">Adora Viagem</option>
                                </select>
                            </div>
                            <div>
                                <p id='date' class='marg input'>Datum:</p>
                                <input class='inputField' type='date' id='date' name='date' value='{$date}' required>
                            </div>
                            <div>
                                <p id='content' class='marg input '>Text:</p>
                                <textarea class='inputField large-input' id='content' name='content' required>{$content}</textarea>
                            </div>
                            <div>
                                <p id='approval' value='{$approval}'>Artikel veröffentlichen?</p>
                                <input type='radio' id='yes' name='approval' value='1' " . ($approval == '1' ? 'checked' : '') . ">
                                <label for='yes'>Ja</label><br>
                                <input type='radio' id='no' name='approval' value='0' " . ($approval == '0' ? 'checked' : '') . ">
                                <label for='no'>Nein</label><br>
                            </div>
                            <button class='marg2' type='submit'>Speichern</button>
                        </form>
                        <div class='end marg2'>
                            <p>© 2021 |</p>
                            <a class='link' href='../php-pages/impressum.php'>Impressum</a>
                        </div>
                    </div>
                </body>
                </html>
                ";
            }
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    } else {
        echo "Datenbankverbindung festgeschlagen.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_id'])) {
    $saveId = (int)$_POST['save_id'];
    saveArticle($saveId, $_POST);
}

function saveArticle($requestedId, $postData) {
    $connection = databaseConnection();
    $csvFile = "../assets/csv/blog-artikel_db.csv";

    if($connection){
        try {
            $title = htmlspecialchars($postData['title']);
            $stmt = $connection->prepare("
                                    SELECT Image 
                                    FROM article 
                                    WHERE id = :id");
            $stmt->bindParam(':id', $requestedId, PDO::PARAM_INT);
            $stmt->execute();

            //change image
            $image = !empty($_FILES['image']['name']) ? '../assets/img/' . htmlspecialchars($_FILES['image']['name']) : htmlspecialchars($postData['existImage']);
            if (!empty($_FILES['image']['name'])) {
                move_uploaded_file($_FILES['image']['tmp_name'], $image);
            }
            if (isset($postData['delete_image']) && $postData['delete_image'] == 'on') {
                $image = ''; // set image path to empty
            }

            
            $content = htmlspecialchars($postData['content']);
            $date = date("Y-m-d", strtotime($postData['date']));
            $author = htmlspecialchars($postData['author']);
            $approval = htmlspecialchars($postData['approval']);

            // Update the database
            $sql = "UPDATE article 
                    SET Title = :Title, 
                        Image = :Image, 
                        Text = :Text, 
                        Date = :Date, 
                        Author = :Author, 
                        Online = :Online 
                    WHERE id = :id
                    ";
            $statement = $connection->prepare($sql);
            $statement->bindParam(':Title', $title);
            $statement->bindParam(':Image', $image);
            $statement->bindParam(':Text', $content);
            $statement->bindParam(':Date', $date);
            $statement->bindParam(':Author', $author);
            $statement->bindParam(':Online', $approval);
            $statement->bindParam(':id', $requestedId, PDO::PARAM_INT);
            $statement->execute();

            // Update the CSV file
            if (($file = fopen($csvFile, "r+")) !== FALSE) {
                $header = fgetcsv($file, 1000, ",");
                $lines = [];
                while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
                    $id = (int)$data[0];
                    if ($id === $requestedId) {
                        $data[1] = $title;
                        $data[2] = $image;
                        $data[3] = $content;
                        $data[4] = strtotime($date);
                        $data[5] = $author;
                        $data[7] = $approval;
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

                header("Location: article.php?id={$requestedId}");
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