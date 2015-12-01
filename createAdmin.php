<!DOCTYPE html>

<html>
    <head>
        
    </head>
    <body>
        <?php
        session_start();
        
        if(empty($_SESSION['logged_in']) || $_SESSION('sessionusername') != 'superuser')
        {
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/PhpProject1/login.php');
            exit;
        }
        
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
        
        $sql = "CREATE TABLE admin ("
                        . "id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, "
                        . "username VARCHAR(30) NOT NULL, "
                        . "pwd CHAR(255) NOT NULL)";
        
        if ($conn->query($sql) == TRUE) {
            echo "Successfully created admin";
        } else {
            echo "Error registering account: " . $conn->error;
        }

        $conn->close();
        ?>
    </body>
</html>