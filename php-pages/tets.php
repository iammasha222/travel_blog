<?php
    require ("../src/lib/functions.php");
    $connection = databaseConnection();
?>

<table>
    <thead>
        <tr>
            <h2>Article table</h2>
            <th></th>
            <th>ID</th>
            <th>Title</th>
            <th>Image</th>
            <th>Text</th>
            <th>Date</th>
            <th>Author</th>
            <th>Online</th>
        </tr>
    </thead>
    <tbody>
        <?php
            
            $sql = "SELECT * FROM article";
            $article = $connection->prepare($sql);
            $article->execute();

            if($article->rowCount() >0){
                while($row = $article->fetch(PDO::FETCH_ASSOC)){
                    echo "<tr>
                            <td> </td>
                            <td>" . $row['ID'] . "</td>
                            <td>" . $row['Title'] . "</td>
                            <td>" . $row['Image'] . "</td>
                            <td>" . $row['Text'] . "</td>
                            <td>" . $row['Date'] . "</td>
                            <td>" . $row['Author'] . "</td>
                            <td>" . $row['Online'] . "</td>
                        </td>";
                }
            } else{
                echo "<tr><td colspan='5'> No records found!</td></tr>";
            }
            
        ?>
    </tbody>
</table>


<table>
    <thead>
        <tr>
            <h2>User table</h2>
            <th></th>
            <th>ID</th>
            <th>Email</th>
            <th>Password</th>
            <th>Forname</th>
            <th>Surname</th>

        </tr>
    </thead>
    <tbody>
        <?php
            $sql = "SELECT * FROM user";
            $user = $connection->prepare($sql);
            $user->execute();

            if($user->rowCount()>0){
                while($row = $user->fetch(PDO::FETCH_ASSOC)){
                    echo "<tr>
                    <td> </td>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['email'] . "</td>
                    <td>" . $row['password'] . "</td>
                    <td>" . $row['forname'] . "</td>
                    <td>" . $row['surname'] . "</td>
                
                </td>";
                }
            } else{
                echo "<tr><td colspan='5'> No records found!</td></tr>";
            } 
        ?>
    </tbody>
</table>
            
<table>
    <thead>
        <tr>
            <h2>Tag table</h2>
            <th></th>
            <th>ID</th>
            <th>name</th>

        </tr>
    </thead>
    <tbody>
        <?php
            $sql = "SELECT * FROM tag";
            $tag = $connection->prepare($sql);
            $tag->execute();

            if($tag->rowCount()>0){
                while($row = $tag->fetch(PDO::FETCH_ASSOC)){
                    echo "<tr>
                    <td> </td>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['name'] . "</td>
                
                </td>";
                }
            } else{
                echo "<tr><td colspan='5'> No records found!</td></tr>";
            } 
        ?>
    </tbody>
</table>