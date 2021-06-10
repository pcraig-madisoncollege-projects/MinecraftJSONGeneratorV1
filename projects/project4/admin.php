<?php
    require_once("authorize.php");
    $pageTitle = "Administrator Control Page";
    require_once("header.php");

    require_once("connectVars.php");
    
    // Retrieve previously entered blog posts
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die("Error connecting to database.");
    
    $query = "select TC.id, name, command, datesaved, TU.username"
            . " from TELLRAW_USER AS TU"
            . " join TELLRAW_COMMANDS AS TC"
            . " on TU.id = TC.userID"
            . " order by datesaved desc;";
    
    $result = mysqli_query($dbc, $query)
            or die("Error querying database.");
    
    mysqli_close($dbc);
            
    // Display each command and link to delete command on the page
    echo '<section class="container">';
    while ($row = mysqli_fetch_array($result)) {
        $id = $row['id'];
        $name = $row['name'];
        $command = $row['command'];
        $dateSaved = $row['datesaved'];
        $username = $row['username'];
        
        // Display command
        echo "<section class=\"container\"><h2>$name</h2><h3>Saved by $username"
                . " on $dateSaved</h3>"
                . "<textarea class=\"form-control\" readonly cols=\"150\" rows=\"6\">$command"
                . "</textarea><br><a href=\"adminDeleteCommand.php?id=$id\">"
                . "Delete Command</a></section>";
    }
    echo "</section>";

    require_once("footer.php");
?>
