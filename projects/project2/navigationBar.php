<?php
    require_once("startSession.php");
    require_once("connectVars.php");

    // Display a different navigation bar if not logged in
    if (isset($_SESSION['userID'])) {
        // Connect to database
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                or die("Error connecting to database.");
        
        // Validate user id
        $userID = mysqli_real_escape_string($dbc, trim($_SESSION['userID']));
        
        // Initialize empty username to display
        $username = "";
        
        // Clear notification and title html
        $profileNotification = "";
        $profileNotificationTitle = "";
        
        // Retrieve user profile information
        $query = "select * from exercise_user where id='$userID';";
        
        $result = mysqli_query($dbc, $query)
                or die("Error querying database.");
        
        // Confirm that valid user was found from id
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_array($result);
            $username = $row['username'];
            $firstName = $row['first_name'];
            $lastName = $row['last_name'];
            $gender = $row['gender'];
            $birthdate = $row['birthdate'];
            $weight = $row['weight'];
        } else {
            // Display error if no valid user was found with specified id
            echo '<p class="error">Unknown error occurred</p>';
            require_once('footer.php');
            mysqli_close($dbc);
            exit();
        }
        
        // Display notification asterisk if any part of profile hasn't been set up yet
        if (empty($firstName) || empty($lastName) || empty($gender)
                || empty($birthdate) || empty($weight)) {
            $profileNotification = "<span class=\"notification\">*</span>";
            $profileNotificationTitle = " title=\"You have profile info to finish setting up\"";
        }
        
        mysqli_close($dbc);
?>
<nav>
    <a href="index.php">Homepage</a>
    <a href="logExercise.php">Log an Exercise</a>
    <a href="viewProfile.php" <?php echo $profileNotificationTitle; ?>>View Profile<?php echo $profileNotification; ?></a>
    <a href="logout.php">Logout (<?php echo $username; ?>)</a>
</nav>
<?php
    } else {
?>
<nav>
    <a href="index.php">Homepage</a>
    <a href="createAccount.php">Create Account</a>
    <a href="login.php">Login</a>
</nav>
<?php
    }
?>