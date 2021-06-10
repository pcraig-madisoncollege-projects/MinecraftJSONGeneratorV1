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
                $query = "SELECT username FROM exercise_user WHERE username='$enteredUsername';";
                $result = mysqli_query($dbc, $query)
                        or die("Error querying database.");
                
                // Check if any users have been found with same username
                if (mysqli_num_rows($result) == 0) {
                    // This username is unique, so create new user
                    $query = "INSERT INTO exercise_user (username, password)"
                            . " VALUES('$enteredUsername', SHA('$enteredPassword'));";
                    $result = mysqli_query($dbc, $query)
                            or die("Error querying database.");

                    echo "<h2>Successfully created your account! You can now "
                            . "<a href=\"login.php\">login</a>"
                            . " and begin!</h2>";
                    require_once('footer.php');
                    exit();
                } else {
                    echo "<p class=\"error\">Your username is already in use. "
                            . "Please select a different username.</p>";
                }
            } else {
                echo "<p class=\"error\">Your passwords do not match. "
                        . "Enter matching passwords to continue.</p>";
            }
        } else {
            echo "<p class=\"error\">You must enter all fields "
                    . "in the form.</p>";
        }
        
        mysqli_close($dbc);
    }
?>

<h2>Please enter your username and desired password to create an account with Fitness Advanced.</h2>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <fieldset>
        <legend>User Information</legend>
        <label for="username"><span class="required">*</span>Username:</label>
        <input type="text" id="username" name="username" value="<?php if (!empty($enteredUsername)) echo $enteredUsername; ?>"><br>
        <label for="password"><span class="required">*</span>Password:</label>
        <input type="password" id="password" name="password"><br>
        <label for="confirmedPassword"><span class="required">*</span>Password (re-enter):</label>
        <input type="password" id="confirmedPassword" name="confirmedPassword"><br>
    </fieldset>
    <input type="submit" value="Create Account" name="submit">
    <p><span class="required">*</span> Required fields</p>
</form>

<?php
    require_once("footer.php");
?>