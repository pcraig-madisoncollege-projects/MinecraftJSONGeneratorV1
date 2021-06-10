<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Guitar Wars - High Scores</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
    <h2>Guitar Wars - High Scores</h2>
    <p>Welcome, Guitar Warrior, do you have what it takes to crack the high score list? If so, just <a href="addscore.php">add your own score</a>.</p>
    <hr />

<?php
    // Retrieve application constants
    require_once("appvars.php");
    
    // Retrieve database connection constants
    require_once("connectvars.php");
    
    // Initialize unverified image directory
    $unverified_dir = GW_UPLOADPATH . "unverified.gif";
    
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die("Error connecting to database.");

    // Retrieve score data from guitar wars database sorted by highest to lowest score
    $query = "SELECT * FROM guitarwars ORDER BY score DESC;";
    $data = mysqli_query($dbc, $query)
            or die("Error querying database.");

    // Display each user's score formatted as HTML from score data
    echo '<table>';
    
    $index = 0;
    
    while ($row = mysqli_fetch_array($data)) {
        $score = $row['score'];
        $name = $row['name'];
        $date = $row['date'];
        $screenshot = $row['screenshot'];
        $screenshot_dir = GW_UPLOADPATH . $screenshot;
        
        // Display highscore message for first sorted entry
        if ($index == 0) {
            echo "<tr><td colspan=\"2\" class=\"topscoreheader\">"
                    . "Top Score: $score</td></tr>";
        }

        // Display the score data
        echo '<tr><td class="scoreinfo">';
        echo '<span class="score">' . $score . '</span><br />';
        echo '<strong>Name:</strong> ' . $name . '<br />';
        echo '<strong>Date:</strong> ' . $date . '<br />';

        // Display user-submitted image if it is valid
        if (is_file($screenshot_dir) && filesize($screenshot_dir) > 0) {
            echo "<td><img src=\"$screenshot_dir\" alt=\"Score image\" /></td></tr>";
        } else {
            echo "<td><img src=\"$unverified_dir\" alt=\"Unverified score\" /></td></tr>";
        }
        
        $index++;
    }
    echo '</table>';

    mysqli_close($dbc);
?>

</body> 
</html>
