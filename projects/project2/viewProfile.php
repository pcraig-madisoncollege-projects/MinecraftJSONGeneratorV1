<?php
    require_once("startSession.php");
    require_once("connectVars.php");
    
    $pageTitle = "View Profile";
    require_once("header.php");
    
    require_once("login.php");
    
    // Retrieve user info from database
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die("Error connecting to database.");
    
    $query = "select * from exercise_user where id='$userID';";
    
    $result = mysqli_query($dbc, $query)
            or die("Error querying database.");
    
    // Confirm that valid user was found
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);

        // Store profile information or not set if profile hasn't been edited yet
        $username = $row['username'];
        $firstName = $row['first_name'];
        $lastName = $row['last_name'];
        $gender = $row['gender'];
        $birthdate = $row['birthdate'];
        $weight = $row['weight'];
        
        // Store empty value strings for unentered profile info
        if (empty($firstName)) {
            $firstName = "(not set)";
        }
        if (empty($lastName)) {
            $lastName = "(not set)";
        }
        if (empty($gender)) {
            $gender = "(not set)";
        }
        if (empty($birthdate)) {
            $birthdate = "(not set)";
        }
        if (empty($weight)) {
            $weight = "(not set)";
        } else {
            $weight = $weight . " lbs";
        }
    } else {
        echo '<p class="error">Unable to find profile.</p>';
        require_once('footer.php');
        mysqli_close($dbc);
        exit();
    }
    
    mysqli_close($dbc);
?>

<section class="profile">
    <h2><?php echo strtoupper($username); ?>'s Profile</h2>
    <table class="profile">
        <tr>
            <td>First Name:</td>
            <td><?php echo $firstName; ?></td>
        </tr>
        <tr>
            <td>Last Name:</td>
            <td><?php echo $lastName; ?></td>
        </tr>
        <tr>
            <td>Gender:</td>
            <td><?php echo $gender; ?></td>
        </tr>
        <tr>
            <td>Birthdate:</td>
            <td><?php echo $birthdate; ?></td>
        </tr>
        <tr>
            <td>Weight:</td>
            <td><?php echo $weight; ?></td>
        </tr>
    </table>
    
    <a href="editProfile.php">Edit Profile</a>
</section>
<section class="infoSection">
    <h2><?php echo strtoupper($username); ?>'s Recently Logged Exercises</h2>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Type of Exercise</th>
                <th>Length (minutes)</th>
                <th>Average Heartrate</th>
                <th>Calories</th>
                <th></th>
            </tr>
        </thead>
        <tbody>

<?php
    // Retrieve user exercise logs from database
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die("Error connecting to database.");
    $query = "SELECT id, date, type, time_in_minutes, heartrate, calories FROM"
            . " exercise_log WHERE user_id='$userID' ORDER BY date DESC LIMIT 15;";
    $result = mysqli_query($dbc, $query)
            or die("Error querying database.");
    while ($row = mysqli_fetch_array($result)) {
        $id = $row['id'];
        $date = $row['date'];
        $type = $row['type'];
        $length = $row['time_in_minutes'];
        $averageHeartRate = $row['heartrate'];
        $calories = $row['calories'];
        ?>
            <tr>
                <td><?php echo $date; ?></td>
                <td><?php echo $type; ?></td>
                <td><?php echo $length; ?></td>
                <td><?php echo $averageHeartRate; ?></td>
                <td><?php echo $calories; ?></td>
                <td>
                    <a href="removeExerciseLog.php?id=<?php echo $id;?>">Delete Log</a>
                </td>
            </tr>
<?php
    }
    
    mysqli_close($dbc);
?>

        </tbody>
    </table>
</section>

<?php
    
    require_once("footer.php");
?>