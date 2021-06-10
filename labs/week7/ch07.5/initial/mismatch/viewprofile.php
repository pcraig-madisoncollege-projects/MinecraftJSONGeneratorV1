<?php
    require_once('startsession.php');

    // Display page header and navigation
    $page_title = "View Profile";
    require_once("header.php");
    require_once("navmenu.php");

    require_once('login.php');

    // Confirm user is logged in
    if (!isset($_SESSION['user_id'])) {
        exit('<p class="error">You must be logged in to view this page.</p>');
    }

    require_once('appvars.php');
    require_once('connectvars.php');

    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username'];

    // Retrieve the profile data from the database
    if (!isset($_GET['user_id'])) {
        $query = "SELECT username, first_name, last_name, gender, birthdate,"
                . " city, state, picture FROM mismatch_user WHERE "
                . "user_id = '$user_id';";
    } else {
        $query = "SELECT username, first_name, last_name, gender, birthdate, "
                ."city, state, picture FROM mismatch_user WHERE user_id = '"
                . $_GET['user_id'] . "';";
    }

    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die("Error connecting to database.");

    $data = mysqli_query($dbc, $query)
            or die("Error querying database.");

    // Display user data that was found
    if (mysqli_num_rows($data) == 1) {
        $row = mysqli_fetch_array($data);
        echo '<table>';
        if (!empty($row['username'])) {
            echo '<tr><td class="label">Username:</td><td>'
                    . $row['username'] . '</td></tr>';
        }
        if (!empty($row['first_name'])) {
            echo '<tr><td class="label">First name:</td><td>'
                    . $row['first_name'] . '</td></tr>';
        }
        if (!empty($row['last_name'])) {
            echo '<tr><td class="label">Last name:</td><td>'
                    . $row['last_name'] . '</td></tr>';
        }
        if (!empty($row['gender'])) {
            echo '<tr><td class="label">Gender:</td><td>';
            if ($row['gender'] == 'M') {
                echo 'Male';
            } else if ($row['gender'] == 'F') {
                echo 'Female';
            } else {
                echo '?';
            }
            echo '</td></tr>';
        }
        if (!empty($row['birthdate'])) {
            if (!isset($_GET['user_id']) || ($user_id == $_GET['user_id'])) {
                // Show the user their own birthdate
                echo '<tr><td class="label">Birthdate:</td><td>'
                        . $row['birthdate'] . '</td></tr>';
            } else {
                // Show only the birth year for everyone else
                list($year, $month, $day) = explode('-', $row['birthdate']);
                echo '<tr><td class="label">Year born:</td><td>'
                        . $year . '</td></tr>';
            }
        }
        if (!empty($row['city']) || !empty($row['state'])) {
            echo '<tr><td class="label">Location:</td><td>' . $row['city']
                    . ', ' . $row['state'] . '</td></tr>';
        }
        if (!empty($row['picture'])) {
            echo '<tr><td class="label">Picture:</td><td><img src="'
                    . MM_UPLOADPATH . $row['picture']
                    . '" alt="Profile Picture" /></td></tr>';
        }
        echo '</table>';
        if (!isset($_GET['user_id']) || ($user_id == $_GET['user_id'])) {
            echo '<p>Would you like to <a href="editprofile.php">edit your'
                    . ' profile</a>?</p>';
        }
    } else {
        echo '<p class="error">There was a problem accessing the profile.</p>';
    }

    mysqli_close($dbc);

    // Display html footer on page
    require_once("footer.php");
?>