<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Mismatch - Sign Up</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
    <h3>Mismatch - Sign Up</h3>

<?php
    require_once('appvars.php');
    require_once('connectvars.php');


    if (isset($_POST['submit'])) {

        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                or die("Error connecting to database.");

        // Retrieve entered profile data
        $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
        $password1 = mysqli_real_escape_string($dbc, trim($_POST['password1']));
        $password2 = mysqli_real_escape_string($dbc, trim($_POST['password2']));

        // Validate username and password entries
        if (!empty($username) && !empty($password1) && !empty($password2)
                && ($password1 == $password2)) {

            // Confirm that no other user exists with matching username
            $query = "SELECT * FROM mismatch_user WHERE username = '$username'";
            $data = mysqli_query($dbc, $query)
                    or die("Error querying database.");

            // Create new user if no other users have been found
            if (mysqli_num_rows($data) == 0) {
                $query = "INSERT INTO mismatch_user (username, password, join_date)"
                        . "VALUES ('$username', SHA('$password1'), NOW())";
                mysqli_query($dbc, $query)
                        or die("Error querying database.");

                // Confirm account creation success
                echo '<p>Your new account has been successfully created. '
                        . 'You\'re now ready to log in and '
                        . '<a href="editprofile.php">edit your profile</a>.</p>';

                mysqli_close($dbc);
                exit();
            } else {
                // Display error message if an account already exists
                echo '<p class="error">An account already exists for this username. Please use a different address.</p>';
                $username = "";
            }
        } else {
            echo '<p class="error">You must enter all of the sign-up data, including the desired password twice.</p>';
        }

        mysqli_close($dbc);
    }

?>

    <p>Please enter your username and desired password to sign up to Mismatch.</p>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <fieldset>
            <legend>Registration Info</legend>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php if (!empty($username)) echo $username; ?>" /><br />
            <label for="password1">Password:</label>
            <input type="password" id="password1" name="password1" /><br />
            <label for="password2">Password (retype):</label>
            <input type="password" id="password2" name="password2" /><br />
        </fieldset>
        <input type="submit" value="Sign Up" name="submit" />
    </form>
</body> 
</html>
