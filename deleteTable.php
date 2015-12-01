<!DOCTYPE html>

<html>
    <head>
        
    </head>
    <body>
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
        $sql = "DROP TABLE MyTasks";
        
        if ($conn->query($sql) == TRUE) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record:" . $conn->error;
        }
        
        $conn->close();
        ?>
    </body>
</html>