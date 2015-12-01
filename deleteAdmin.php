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
        
        $sql = "DROP TABLE admin";
        
        if ($conn->query($sql) == TRUE) {
            echo "Successfully dropped admin";
        } else {
            echo "Error dropping account: " . $conn->error;
        }

        $conn->close();
        ?>
    </body>
</html>