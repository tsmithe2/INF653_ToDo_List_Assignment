<?php 
    require('database.php');
?>

<!DOCTYPE html>
<html lang = "en">
    <head>
        <meta charset = "UTF-8">
        <meta name = "viewport" content = "width-device-width, initial-scale=1.0">
        <link rel = "stylesheet" href = "css//main.css">
        <title>ToDo List</title>
    </head>
    <body>
    <p id = "header" colspan = "2">ToDo List</p>
        <table id = "top" style = "border: 1px solid">
            <?php
                if (isset($_POST["del"]))
                {
                    $item = $_POST["del"];
                    $query = "DELETE FROM todoitems WHERE ItemNum = '" . $item . "'";
                    $statement = $db->prepare($query);
                    $statement->execute();
                    $results = $statement->fetchAll();
                    $statement->closeCursor();
                }
                if (isset($_POST["title"]) && isset($_POST["description"]))
                {
                    $title = $_POST["title"];
                    $description = $_POST["description"];
                    $query = "INSERT INTO todoitems (Title, Description) VALUES ('" . $title . "','" . $description . "')";
                    $statement = $db->prepare($query);
                    $statement->execute();
                    $results = $statement->fetchAll();
                    $statement->closeCursor();
                }

                $query = "SELECT ItemNum, Title, Description FROM todoitems ORDER BY ItemNum ASC";
                $statement = $db->prepare($query);
                $statement->execute();
                $results = $statement->fetchAll();
                $statement->closeCursor();
                
                $counter = 1;
                foreach ($results as $result) :
                    echo "<form action = 'index.php' method = 'POST'>";
                    echo "<input type = 'number' name = 'del' value = " . $result["ItemNum"] . " style = 'visibility: hidden;'>";
                    echo "<tr><td class = 'content'><b class = 'title'>" . htmlspecialchars($result["Title"]) . "</b><br>";
                    echo htmlspecialchars($result["Description"]) . "</td><td class = 'other'><input type = 'submit' class = 'del' value = 'Delete'></td></tr></form>";
                    $counter++;
                endforeach;

                $query = "ALTER TABLE todoitems AUTO_INCREMENT = $counter";
                $statement = $db->prepare($query);
                $statement->execute();
                $results = $statement->fetchAll();
                $statement->closeCursor();
            ?>
        </table>
        <table id = "addItem">
            <form action = "index.php" method = "POST">
                <th id = "footer">Add Item</th>
                <tr>
                    <td id = "T_and_D">
                        <input id = "T" type = "text" name = "title" value = "Title" required><br><br>
                        <input id = "D" type = "text" name = "description" value = "Description" required>
                    </td>
                    <td>
                        <input id = "addButton" type = "submit" value = "Add Item">
                    </td>
                </tr>
            </form>
        </table>
    </body>
</html>