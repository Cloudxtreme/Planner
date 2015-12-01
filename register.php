<!DOCTYPE html>

<html>
    <head>
        
    </head>
    <body>
        <?php
        session_start();
        
        if(empty($_SESSION['can_register']))
        {
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/PhpProject1/login.php');
            exit;
        }
        
        echo $_POST['username'];
        $_SESSION['sessionusername'] = $_POST['username'];
        
        $servername = "localhost";
        $serverusername = "root";
        $serverpassword = "";
        $dbname = "myDB";
        
        //Create connection
        $conn = new mysqli($servername, $serverusername, $serverpassword, $dbname);
        //Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        //Create table
       
        
        $sql = "INSERT INTO admin (username, pwd)
                VALUES ('". mysql_real_escape_string($_POST['username']) . "','" 
                . $_POST['pwd'] .  "')";
        
        $conn->query($sql);

        $sql = "CREATE TABLE " . mysql_real_escape_string($_POST['username']) . " ("
                        . "id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, "
                        . "taskname VARCHAR(100), "
                        . "duedate VARCHAR(30))";
        
        if ($conn->query($sql) == TRUE) {
            header("location: getTasks.php");
            $_SESSION['logged_in'] = TRUE;
            exit();
        } else {
            header("location: login.php");
            exit();
        }

        $conn->close();
        ?>
    </body>
</html>