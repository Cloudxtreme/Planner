<!DOCTYPE html>

<html>
    <head>
        
    </head>
    <body>
        <?php
        session_start();
        
        if(empty($_SESSION['logged_in']) || $_SESSION['sessionusername'] != 'superuser')
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
        
        $sql = "SELECT * FROM admin";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "id: " . $row["id"]. " - username: " . $row["username"]. " - password: " . $row["pwd"]. "<br>";
            }
        } else {
            echo "0 results";
        }
        $conn->close();
        ?>
    </body>
</html>