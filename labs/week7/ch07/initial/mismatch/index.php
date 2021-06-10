
<?php
    require_once('initializesession.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Mismatch - Where opposites attract!</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
    <h3>Mismatch - Where opposites attract!</h3>

<?php
    require_once('appvars.php');
    require_once('connectvars.php');

    // Display navigation menu based off of login status
    if (isset($_SESSION['username'])) {
        echo '&#10084; <a href="viewprofile.php">View Profile</a><br />';
        echo '&#10084; <a href="editprofile.php">Edit Profile</a><br />';
        echo '&#10084; <a href="logout.php">Log Out ('
                . $_SESSION['username'] . ')</a><br />';
    } else {
        echo '&#10084; <a href="login.php">Log In</a><br />';
        echo '&#10084; <a href="signup.php">Sign Up</a><br />';
    }

    // Retrieve the all user profile data
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die("Error connecting to database.");
    $query = "SELECT user_id, first_name, picture FROM mismatch_user "
            . "WHERE first_name IS NOT NULL ORDER BY join_date DESC LIMIT 5";
    $data = mysqli_query($dbc, $query)
            or die("Error querying database.");
    mysqli_close($dbc);

    // Display user all profile data as formatted HTML
    echo '<h4>Latest members:</h4>';
    echo '<table>';
    while ($row = mysqli_fetch_array($data)) {

        // Display user profile pictures
        if (is_file(MM_UPLOADPATH . $row['picture'])
                && filesize(MM_UPLOADPATH . $row['picture']) > 0) {
            echo '<tr><td><img src="' . MM_UPLOADPATH . $row['picture']
                    . '" alt="' . $row['first_name'] . '" /></td>';
        }
        else {
            echo '<tr><td><img src="' . MM_UPLOADPATH . 'nopic.jpg'
                    . '" alt="' . $row['first_name'] . '" /></td>';
        }

        // Display viewable user profile hyperlinks only if user is logged in
        if (isset($_SESSION['user_id'])) {
            echo '<td><a href="viewprofile.php?user_id=' . $row['user_id']
                    . '">' . $row['first_name'] . '</a></td></tr>';
        } else {
            echo '<td>' . $row['first_name'] . '</td></tr>';
        }
    }
    echo '</table>';
?>

</body> 
</html>
