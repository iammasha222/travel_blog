<?php

include '../src/lib/functions.php';
filePath('login');

session_start();
//read data for successful login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    $connection = databaseConnection();

    if ($connection){
        try {
            // Take username and password from the database (max. 1 user)
            $sql = "SELECT * 
                    FROM users 
                    WHERE email = :username 
                    LIMIT 1
                    ";
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            // Check if a user was found
            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                // check password
                switch(true){
                    case($password == $user['password']):
                        $_SESSION['sessionLog'] = true; // Set session variable when user is logged in
                        $_SESSION['username'] = $username; // Save username in session
                        header("Location: userPage.php"); // Redirect to user profile page
                        exit();
                    default:
                    echo "Benutzername oder Passwort sind ungültig.";
                    break;
                }      
            } else {
                echo "Benutzername oder Passwort sind ungültig.";
            }

        } catch (PDOException $e) {
            echo "Verbindung fehlgeschlagen: " . $e->getMessage();
        }
    } else {
        echo "Datenbankverbindung festgeschlagen.";
    }
} if(isset($_SESSION['sessionLog']) && $_SESSION['sessionLog'] === true){
    header("Location: userPage.php");
}
