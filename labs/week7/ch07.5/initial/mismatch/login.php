<?php
    require_once('startsession.php');
    
    require_once('connectvars.php');

    $error_msg = "";

    // Confirm user is not logged in already
    if (!isset($_SESSION['user_id'])) {
        if (isset($_POST['submit'])) {
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die("Error connecting to database.");

            $user_username = mysqli_real_escape_string($dbc, trim($_POST['username']));
            $user_password = mysqli_real_escape_string($dbc, trim($_POST['password']));

            if (!empty($user_username) && !empty($user_password)) {

                // Search for user in database
                $query = "SELECT user_id, username FROM mismatch_user "
                        . "WHERE username = '$user_username' AND "
                        . "password = SHA('$user_password')";
                $data = mysqli_query($dbc, $query)
                        or die("Error querying database.");

                // Confirm that user exists with specified credentials
                if (mysqli_num_rows($data) == 1) {
                    // Store the user ID and username variables for this session
                    $row = mysqli_fetch_array($data);
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['username'] = $row['username'];

                    // Store user login info in cookie to ensure user login retaining if selected
                    if (isset($_POST['savelogin'])) {
                        setcookie('user_id', $row['user_id'], time() + 2592000);
                        setcookie('username', $row['username'], time() + 2592000);
                    }

                    // Redirect user to homepage after logging in
                    $home_url = 'http://' . $_SERVER['HTTP_HOST']
                            . dirname($_SERVER['PHP_SELF']) . '/index.php';
                    header('Location: ' . $home_url);
                } else {
                    //Invalid username or password
                    $error_msg = "Sorry, you must enter a valid username and "
                            . "password to log in.";
                }
            } else {
                // No username or password entered
                $error_msg = "Sorry, you must enter your username and "
                        . "password to login.";
            }
        }
    }

    // Display the error message if no login cookie exists
    if (empty($_SESSION['user_id'])) {
    echo '<p class="error">' . $error_msg . '</p>';

    // Display login header and navigation bar if no header has been displayed
    $display_login_html = !isset($header_displayed);
    if ($display_login_html) {
        $page_title = "Login";
        require_once("header.php");
        require_once("navmenu.php");
    }
?>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <fieldset>
            <legend>Log In</legend>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username"
            value="<?php if (!empty($user_username)) echo $user_username; ?>" /><br />
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" /><br /><br />
            <input type="checkbox" value="yes" id="savelogin" name="savelogin">
            <label for="savelogin">Save Login</label>
            <p>*Saving login requires cookies to be enabled</p>
        </fieldset>
        <input type="submit" value="Log In" name="submit" />
    </form>

<?php
    }

    // Display login footer if it has not been already displayed
    if (isset($display_login_html) && $display_login_html) {
        require_once("footer.php");
    } else {
        // Redirect user to homepage if already logged in
        if (!isset($_SESSION['user_id'])) {
            exit('<p class="error">You must be logged in to view this page.</p>');
        }
    }
?>