<!DOCTYPE html>

<html style="background-color:#ffb6c1">
    <head>
        
    </head>
    <body style="font-family:verdana">
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "myDB";
        
        //Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        //Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        //Create table
        $sql = "DELETE FROM MyTasks WHERE id=" . $_POST['id'];
        
        $previous = $_SERVER['HTTP_REFERER'];
        
        if ($conn->query($sql) == TRUE) {
            echo "Nice!<br>";
        } else {
            echo "Error deleting record:" . $conn->error;
        }
        
        $conn->close();
        ?>
    </body>
</html>