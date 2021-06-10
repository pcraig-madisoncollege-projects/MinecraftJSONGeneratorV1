<?php
    require_once('startSession.php');
    
    require_once('connectVars.php');

    $errorMessage = "";

    // Confirm user is not logged in already
    if (!isset($_SESSION['userID'])) {
        if (isset($_POST['submit'])) {
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die("Error connecting to database.");

            $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
            $password = mysqli_real_escape_string($dbc, trim($_POST['password']));

            if (!empty($username) && !empty($password)) {

                // Search for user in database
                $query = "SELECT id, username FROM exercise_user "
                        . "WHERE username = '$username' AND "
                        . "password = SHA('$password')";
                $data = mysqli_query($dbc, $query)
                        or die("Error querying database.");

                // Confirm that user exists with specified credentials
                if (mysqli_num_rows($data) == 1) {
                    // Store the user ID and username variables for this session
                    $row = mysqli_fetch_array($data);
                    $_SESSION['userID'] = $row['id'];

                    // Store user login info in cookie to ensure user login retaining if selected
                    if (isset($_POST['saveLogin'])) {
                        setcookie('userID', $row['id'], time() + 2592000);
                    }

                    // Redirect user to homepage after logging in
                    $homeURL = 'http://' . $_SERVER['HTTP_HOST']
                            . dirname($_SERVER['PHP_SELF']) . '/index.php';
                    header('Location: ' . $homeURL);
                } else {
                    // Invalid username or password
                    $errorMessage = "Sorry, you must enter a valid username and "
                            . "password to log in.";
                }
            } else {
                // No username or password entered
                $errorMessage = "Sorry, you must enter your username and "
                        . "password to login.";
            }
        }
    }

    // Display the error message if no login cookie exists
    if (empty($_SESSION['userID'])) {
        // Display login header and navigation bar if no header has been displayed
        $displayLoginHTML = !isset($headerDisplayed);
        if ($displayLoginHTML) {
            $pageTitle = "Login";
            require_once("header.php");
        }
        
        // Display unauthorized access error and close html on page
        if (!isset($displayLoginHTML) || !$displayLoginHTML) {
            // Redirect user to homepage if already logged in
            if (!isset($_SESSION['userID'])) {
                echo '<p class="error">You must be logged in to view'
                        . ' this page.</p>';
                require_once("footer.php");
                exit();
            }
        }
        
        // Display the error message if it isn't empty
        if (!empty($errorMessage)) {
            echo '<p class="error">' . $errorMessage . '</p>';
        }
?>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <fieldset>
            <legend>Log In</legend>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username"
            value="<?php if (!empty($username)) echo $username; ?>" /><br />
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" /><br /><br />
            <input type="checkbox" value="yes" id="saveLogin" name="saveLogin">
            <label for="saveLogin">Save Login</label>
            <p>*Saving login requires cookies to be enabled</p>
        </fieldset>
        <input type="submit" value="Log In" name="submit" />
    </form>

<?php
    }
    
    // Display footer if page is specifically the login page
    if (isset($displayLoginHTML) && $displayLoginHTML) {
        require_once("footer.php");
    }
?>