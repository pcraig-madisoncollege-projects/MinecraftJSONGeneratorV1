<?php
    require_once("connectVars.php");
    
    // Display general page html
    $pageTitle = "Log an Exercise";
    require_once("header.php");
    
    // Authorize user
    require_once("login.php");
    
    // Confirm that all required profile info has been entered already
    if (!empty($gender) && !empty($birthdate) && !empty($weight)) {
        // Store sticky values for selection list in form
        $date = "";
        $exerciseTypes = array("none" => "", "running" => "", "walking" => "", 
                "weightlifting" => "", "swimming" => "", "biking" => "", 
                "yoga" => "", "other" => "");
        $length = "";
        $averageHeartRate = "";
        
        // Calculate age from birthdate and current year
        $birthdateValues = explode("-", $birthdate);
        $yearOfBirth = (int)($birthdateValues[0]);
        $year = (int)(date("Y"));
        $age = $year - $yearOfBirth;
        
        // Form has been submitted
        if (isset($_POST['submit'])) {
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                or die("Error connecting to database.");
            
            // Retrieve entered exercise log values
            $date = mysqli_real_escape_string($dbc, trim($_POST['date']));
            $type = mysqli_real_escape_string($dbc, trim($_POST['type']));
            $length = (mysqli_real_escape_string($dbc, trim($_POST['length'])));
            $averageHeartRate = mysqli_real_escape_string($dbc, trim($_POST['averageHeartRate']));
            
            // Confirm that proper values were entered in exercise log
            if (!empty($date) && !empty($type) && !empty($length)
                    && !empty($averageHeartRate)) {
                // Confirm that proper numbers were entered for length and heart rate
                if (is_numeric($length) && is_numeric($averageHeartRate)) {
                    // Round length and average heart rates
                    $length = (int) $length;
                    $averageHeartRate = (int) $averageHeartRate;
                    
                    // Calculate calories based on gender
                    if ($gender == 'm') {
                        $calories = ((-55.0969 + (0.6309 * $averageHeartRate)
                                + (0.090174 * $weight)
                                + (0.2017 * $age)) / 4.184) * $length;
                    } else {
                        $calories = ((-20.4022 + (0.4472 * $averageHeartRate)
                                - (0.057288 * $weight)
                                + (0.074 * $age)) / 4.184) * $length;
                    }
                    
                    $calories = round($calories);
                } else {
                    echo '<p class="error">You must enter valid numbers for '
                        . 'the length of the exercise and the average heart '
                        . ' rate before submitting the exercise log.';
                }
            } else {
                echo '<p class="error">You must enter all fields in the '
                        . 'exercise log.';
            }
            
            // Log exercise, display exercise logged and success of logging
            if (isset($calories)) {
                $query = "INSERT INTO exercise_log (user_id, date, type, "
                        . "time_in_minutes, heartrate, calories) values "
                        . "('$userID', '$date', '$type', '$length', "
                        . "'$averageHeartRate', '$calories');";

                $result = mysqli_query($dbc, $query)
                        or die("Error querying database.");
?>

<section class="infoSection">
    <h2>Successfully logged your exercise!</h2>
    <h3>You burned <?php echo $calories;?> calories</h3>
    <p>Here's what was logged...</p>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Type of Exercise</th>
                <th>Length (minutes)</th>
                <th>Average Heartrate</th>
                <th>Calories</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo $date; ?></td>
                <td><?php echo $type; ?></td>
                <td><?php echo $length; ?></td>
                <td><?php echo $averageHeartRate; ?></td>
                <td><?php echo $calories; ?></td>
            </tr>
        </tbody>
    </table>
    
    <p>You can now view this log on your profile.</p>
    
    <a href="<?php echo $_SERVER['PHP_SELF']; ?>">Enter Another Exercise Log</a>
</section>

<?php
                mysqli_close($dbc);
                require_once("footer.php");
                exit();
            } else {
                // Store entered exercise type as html attribute so it can be retained in form
                $exerciseTypes[$type] = "selected";
            }
            
            mysqli_close($dbc);
        }
    } else {
        // Display error to user if required info is not available yet
        echo '<p class="error">You must have entered your gender, birthdate, '
                . 'and weight before you can log exercises.';
        require_once("footer.php");
        exit();
    }
?>

<form class="logExercise" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <h2>Enter Your Exercise Below</h2>
    <label for="date"><span class="required">*</span>Date of Exercise:</label>
    <input type="date" name="date" id="date" value="<?php echo $date; ?>">
    <label for="type"><span class="required">*</span>Type of Exercise:</label>
    <select id="type" name="type" value="<?php echo $type; ?>">
        <option value="none" <?php echo $exerciseTypes['none']; ?>></option>
        <option value="running" <?php echo $exerciseTypes['running']; ?>>Running</option>
        <option value="walking" <?php echo $exerciseTypes['walking']; ?>>Walking</option>
        <option value="weightlifting" <?php echo $exerciseTypes['weightlifting']; ?>>Weightlifting</option>
        <option value="swimming" <?php echo $exerciseTypes['swimming']; ?>>Swimming</option>
        <option value="biking" <?php echo $exerciseTypes['biking']; ?>>Biking</option>
        <option value="yoga" <?php echo $exerciseTypes['yoga']; ?>>Yoga</option>
        <option value="other" <?php echo $exerciseTypes['other']; ?>>Other</option>
    </select>
    <label for="length"><span class="required">*</span>Length of Exercise (minutes):</label>
    <input type="text" name="length" id="length" value="<?php echo $length; ?>">
    <label for="averageHeartRate"><span class="required">*</span>Average Heart Rate:</label>
    <input type="text" name="averageHeartRate" id="averageHeartRate" value="<?php echo $averageHeartRate; ?>">
    <input type="submit" name="submit" value="Log Exercise">
    <p><span class="required">*</span> Required fields</p>
</form>

<?php    
    require_once("footer.php");
?>