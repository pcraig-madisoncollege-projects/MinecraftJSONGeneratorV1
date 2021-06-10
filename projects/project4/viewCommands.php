<?php
    require_once("startSession.php");
    require_once("connectVars.php");
    
    $pageTitle = "View Saved Commands";
    require_once("header.php");
    
    require_once("login.php");
    
    // Retrieve user id
    $userID = $_SESSION['userID'];
    
    // Retrieve user commands saved in database
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die("Error connecting to database.");
    
    $query = "select * from tellraw_commands where userID='$userID' "
            . "order by datesaved desc;";
    
    $result = mysqli_query($dbc, $query)
            or die("Error querying database.");
    
    // Display commands or message if no commands have been saved yet
    if (mysqli_num_rows($result) > 0) {
        // Retrieve and display each command on the page
        while ($row = mysqli_fetch_array($result)) {
            $id = $row['id'];
            $name = $row['name'];
            $command = $row['command'];
            $dateSaved = $row['datesaved'];
            
            // Display command
            echo "<section class=\"container\"><h2>$name</h2><h3>Saved on $dateSaved</h3>"
                    . "<textarea class=\"form-control\" readonly cols=\"150\" rows=\"6\">$command"
                    . "</textarea><br><a href=\"deleteCommand.php?id=$id\">"
                    . "Delete Command</a></section>";
        }
    } else {
        echo "<div class=\"container\"><p>You do not have any saved commands.</p></div>";
    }
    
    mysqli_close($dbc);
    
    require_once("footer.php");
?>