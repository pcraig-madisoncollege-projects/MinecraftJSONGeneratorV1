
<?php
    require_once('startsession.php');

    require_once('appvars.php');
    require_once('connectvars.php');

    // Display page header and navigation
    $page_title = "Where opposites attract!";
    require_once("header.php");
    require_once("navmenu.php");

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

    // Display html footer on page
    require_once("footer.php");
?>