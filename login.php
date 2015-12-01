<!DOCTYPE html>

<html>
    <head>
        <title>Planner</title>
        <meta charset="utf-8">
        <link href='http://fonts.googleapis.com/css?family=Short+Stack' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
        <link rel='stylesheet' type='text/css' href='masterCSS.css'>
        <script>
        $(function() {
          $( "#datepicker" ).datepicker();
        });
        </script>
    </head>
    <body>
        <h1>Planner</h1>
        <div id='login1'>
        <p>Please login or create an account:</p>
        <form action="" method="post">
            Username: <input id='user1' type="username" name="username"><br><br>
            Password: <input id='user1' type="password" name="pwd"><br><br>
            <input id='submit1' type="submit" value="Login">
        </form>
        </div><br>
        <?php
        session_start();
        session_unset();
        $servername = "localhost";
        $serverusername = "root";
        $serverpassword = "";
        $dbname = "myDB";
        
        $username = "";
        $pwd = "";
        $pwvalid = FALSE;
        $uservalid = FALSE;
        $pwdorig = "";
        
        //Create connection
        $conn = new mysqli($servername, $serverusername, $serverpassword, $dbname);
        //Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        //Create table
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!empty($_POST['username'])) {
                $username = test_input($_POST['username']);
                $uservalid = TRUE;
            } else {
                echo "<center>No username entered!</center><br>";
            }
            
            if (!empty($_POST['pwd'])) {
                $pwd = $_POST['pwd'];
                $pwdorig = $pwd;
                if (strlen($pwd) > 5) {
                    $pwvalid = TRUE;
                    $pwd = password_hash($pwd, PASSWORD_BCRYPT);
                } else {
                    echo "<center>Password must be at least 6 characters long!</center><br>";
                }
            } else {
                echo "<center>No password entered!</center><br>";
            }
            
            $stmt = $conn->prepare("SELECT pwd FROM admin WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            
            $count = $result->num_rows; 
            
            if ($count>0 && password_verify($pwdorig, $row['pwd']) == TRUE && $pwvalid == TRUE && $uservalid == TRUE) {
                
                $_SESSION['logged_in'] = TRUE;
                $_SESSION['sessionusername'] = $username;
                header("location: getTasks.php");
                exit();
            } elseif ($count>0 && $pwvalid == TRUE && $uservalid == TRUE) {
                echo '<center>That username and password combination is incorrect!'
                . '</center><br>';
            } elseif ($count!=1 && $pwvalid == TRUE && $uservalid == TRUE){
                $_SESSION['can_register'] = TRUE;
                echo '<center>This username does not exist. Click below to register '
                . 'an account!</center><br>'
                        . '<center><form action="register.php" method="post">'
                        . '<input type="submit" value="Register" '
                        . 'id="submit1">'
                        . '<input type="hidden" name="username"'
                        . 'value="' . $username . '" />'
                        .'<input type="hidden" name="pwd"'
                        . 'value="' . $pwd . '" />';
            } 
        }
        
        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        
        $conn->close();
        ?>
    </body>
</html>