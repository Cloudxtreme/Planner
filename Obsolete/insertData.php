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
        
        function clean_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        
        clean_input($_POST['taskname']);
        clean_input($_POST['duedate']);
        
        //Create table
        $sql = "INSERT INTO MyTasks (taskname, duedate)"
                . "VALUES ('" . mysql_real_escape_string($_POST["taskname"]) 
                . "', '" . mysql_real_escape_string($_POST["duedate"]) . "')";
        
        $previous = $_SERVER['HTTP_REFERER'];
        
        if ($conn->query($sql) == TRUE) {
            echo "Added the task!<br>";
            echo 'Click here to go back: <a href="'. $previous 
                    . '">GO BACK</a>';
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
        $conn->close();
        ?>
    </body>
</html>