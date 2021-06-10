<?php
    $pageTitle = "Create Account";
    require_once("header.php");
    require_once("connectVars.php");
    
    // Confirm that form has been submitted
    if (isset($_POST['submit'])) {
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                        or die("Error connecting to database.");

        // Retrieve entered profile data
        $enteredUsername = mysqli_real_escape_string($dbc, trim($_POST['username']));
        $enteredPassword = mysqli_real_escape_string($dbc, trim($_POST['password']));
        $confirmedPassword = mysqli_real_escape_string($dbc, trim($_POST['confirmedPassword']));
        
        // Validate that fields were entered in form
        if (!empty($enteredUsername) && !empty($enteredPassword)
                && !empty($confirmedPassword)) {
            // Validate that passwords entered match
            if ($enteredPassword == $confirmedPassword) {
                
                // Check if username is unique
                $query = "SELECT username FROM tellraw_user WHERE username='$enteredUsername';";
                $result = mysqli_query($dbc, $query)
                        or die("Error querying database.");
                
                // Check if any users have been found with same username
                if (mysqli_num_rows($result) == 0) {
                    // This username is unique, so create new user
                    $query = "INSERT INTO tellraw_user (username, password)"
                            . " VALUES('$enteredUsername', SHA('$enteredPassword'));";
                    $result = mysqli_query($dbc, $query)
                            or die("Error querying database.");

                    echo '<div class="container">';
                    echo "<h2>Successfully created your account! You can now "
                            . "<a href=\"login.php\">login</a>"
                            . " and begin!</h2></div>";
                    require_once('footer.php');
                    exit();
                } else {
                    echo "<p class=\"alert\">Your username is already in use. "
                            . "Please select a different username.</p>";
                }
            } else {
                echo "<p class=\"alert\">Your passwords do not match. "
                        . "Enter matching passwords to continue.</p>";
            }
        } else {
            echo "<p class=\"alert\">You must enter all fields "
                    . "in the form.</p>";
        }
        
        mysqli_close($dbc);
    }
?>

<div class="container">
    <h2>Create an Account</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="container-fluid">
        <fieldset>
            <legend>User Information</legend>
            <div class="form-group">
                <label for="username"><span class="required">*</span>Username:</label>
                <input class="form-control" type="text" id="username" name="username" value="<?php if (!empty($enteredUsername)) echo $enteredUsername; ?>">
            </div>
            <div class="form-group">
                <label for="password"><span class="required">*</span>Password:</label>
                <input class="form-control" type="password" id="password" name="password">
            </div>
            <div class="form-group">
                <label for="confirmedPassword"><span class="required">*</span>Password (re-enter):</label>
                <input class="form-control" type="password" id="confirmedPassword" name="confirmedPassword">
            </div>
        </fieldset>
        <div class="form-group">
            <input class="btn btn-primary"  type="submit" value="Create Account" name="submit">
        </div>
        <p><span class="required">*</span> Required fields</p>
    </form>
</div>

<?php
    require_once("footer.php");
?>