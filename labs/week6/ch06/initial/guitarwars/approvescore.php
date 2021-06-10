<?php
    require_once('authorize.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Guitar Wars - Approve a High Score</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
  <h2>Guitar Wars - Approve a High Score</h2>

<?php
    require_once('appvars.php');
    require_once('connectvars.php');

    // Confirm page has been loaded
    if (isset($_GET['id']) && isset($_GET['date'])
            && isset($_GET['name']) && isset($_GET['score'])) {

        // Retrieve score data from GET array
        $id = $_GET['id'];
        $date = $_GET['date'];
        $name = $_GET['name'];
        $score = $_GET['score'];
    } else if (isset($_POST['id']) && isset($_POST['name'])
            && isset($_POST['score'])) {
            
        // Retrieve score data from POST array
        $id = $_POST['id'];
        $name = $_POST['name'];
        $score = $_POST['score'];
    } else {
        echo '<p class="error">Sorry, no high score was specified for approval.</p>';
    }

    if (isset($_POST['submit'])) {
        if ($_POST['confirm'] == 'Yes') {

            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                    or die("Failed to connect to database.");

            // Approve the score data in the database
            $query = "UPDATE guitarwars SET approved = 1 WHERE id = $id;";
            mysqli_query($dbc, $query)
                    or die("Failed to query database.");
            mysqli_close($dbc);

            // Confirm approval success with the user
            echo '<p>The high score of ' . $score . ' for ' . $name
                    . ' was successfully approved.';
        } else {
            echo '<p class="error">The high score was not approved.</p>';
        }
    }
    else if (isset($id) && isset($name) && isset($date) && isset($score)) {
        // Display form if page has loaded with proper score values
        echo '<p>Are you sure you want to approve the following high score?</p>';
        echo '<p><strong>Name: </strong>' . $name . '<br /><strong>Date: </strong>' . $date .
        '<br /><strong>Score: </strong>' . $score . '</p>';
        echo '<form method="post" action="approvescore.php">';
        echo '<input type="radio" name="confirm" value="Yes" /> Yes ';
        echo '<input type="radio" name="confirm" value="No" checked="checked" /> No <br />';
        echo '<input type="submit" value="Submit" name="submit" />';
        echo '<input type="hidden" name="id" value="' . $id . '" />';
        echo '<input type="hidden" name="name" value="' . $name . '" />';
        echo '<input type="hidden" name="score" value="' . $score . '" />';
        echo '</form>';
    }

    echo '<p><a href="admin.php">&lt;&lt; Back to admin page</a></p>';
?>

</body> 
</html>