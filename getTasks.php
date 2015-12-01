<!DOCTYPE html>

<html style="background-color:#ffb6c1">
    <head>
        <title>Planner</title>
        <meta charset="utf-8">
        <title>jQuery UI Datepicker - Default functionality</title>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <link href='http://fonts.googleapis.com/css?family=Short+Stack' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <link rel="stylesheet" href="/resources/demos/style.css">
        <link rel='stylesheet' type='text/css' href='masterCSS.css'>
        <script>
        $(function() {
          $( "#datepicker" ).datepicker();
        });
        </script>
    </head>
    <body>
        <?php
        session_start();
        
        if(empty($_SESSION['logged_in']))
        {
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/PhpProject1/login.php');
            exit;
        }
        ?>
        <div id='titleDiv'>
        <h1>Planner</h1>
        <form action="login.php">
            <input type="submit" value="Log out" id='submit1'>
        </form>
        <br><br>
        </div>
        
        <div id='newTaskDiv'>
        <p>Add a new task:</p>
        <form action="" method="post">
            Task Name: <input type="text" name="taskname" id='taskField'><br><br>
            Due Date: <input type="text" name="duedate" id='taskField'><br><br>
            <input type="submit" value="Add task" id='submit1'>
        </form>
        </div>
        <?php
        $servername = "localhost";
        $serverusername = "root";
        $serverpassword = "";
        $dbname = "myDB";
        $shadeInt = 0;
        $_SESSION['can_register'] = FALSE;
                
        //Create connection
        $conn = new mysqli($servername, $serverusername, $serverpassword, $dbname);
        //Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        //Create table
        $sql = "SELECT taskname, duedate, id FROM " . $_SESSION['sessionusername'] . " ORDER BY duedate ASC";
        $result = $conn->query($sql);
        
        echo '<table id="taskTable">';
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                if($shadeInt%2 == 0) {
                    echo '<tr><td><div id="blueRow">'
                            . 'Task Name: ' . $row["taskname"] . "<br>"
                            . "Due Date: " . $row["duedate"] . "<br>"
                            . '<form action="" method="post"><br>
                                    <input type="submit" value="Task complete!" 
                                    id="submit1">
                                    <input type="hidden" name="id" 
                                    value="' .$row['id'] . '" />'
                            . '</form><br>'
                            . '</div></td></tr>';
                    ++$shadeInt;
                } else {
                    echo '<tr><td><div id="greenRow">'
                            . 'Task Name: ' . $row["taskname"] . "<br>"
                            . "Due Date: " . $row["duedate"] . "<br>"
                            . '<form action="" method="post"><br>
                                    <input type="submit" value="Task complete!" 
                                    id="submit1">
                                    <input type="hidden" name="id" 
                                    value="' .$row['id'] . '" />'
                            . '</form><br>'
                            . '</div></td></tr>';
                    ++$shadeInt;
                }
            }

        } else {
            echo '<tr><td><div id="greenRow">No tasks!</td></tr>';
        }
        
        echo '</table>';
        
        if (isset($_POST['id'])) {
            $sql = "DELETE FROM " . $_SESSION['sessionusername'] . " WHERE id=" . $_POST['id'];

            if ($conn->query($sql) == TRUE) {
                echo '<meta http-equiv="refresh" content="0">';
            } else {
                echo "Error deleting record:" . $conn->error;
            }
        }
        
        if (isset($_POST['taskname'])) {
            
            clean_input($_POST['taskname']);
            clean_input($_POST['duedate']);
            
            $sql = "INSERT INTO " . $_SESSION['sessionusername'] . " (taskname, duedate)"
                    . "VALUES ('" . mysql_real_escape_string($_POST["taskname"]) 
                    . "', '" . mysql_real_escape_string($_POST["duedate"]) . "')";
            
            if ($conn->query($sql) == TRUE) {
                echo '<meta http-equiv="refresh" content="0">';
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        
        function clean_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        
        $conn->close();
        ?>
    </body>
</html>