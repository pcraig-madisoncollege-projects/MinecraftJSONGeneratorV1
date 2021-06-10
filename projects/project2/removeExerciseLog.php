<?php
    require_once("startSession.php");
    require_once("connectVars.php");
    
    // Display general page html
    $pageTitle = "Remove Exercise Log";
    require_once("header.php");
    
    // Authorize user
    require_once("login.php");
    
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                or die("Error connecting to database.");
    
    // Check if valid exercise log exists
    if (isset($_GET['id'])) {
        // Retrieve exercise log id from GET
        $id = mysqli_real_escape_string($dbc, trim($_GET['id']));
        
        // Retrieve exercise log from database
        $query = "select user_id, date, type, time_in_minutes, heartrate, calories "
                . "from exercise_log where id='$id';";
        $result = mysqli_query($dbc, $query)
                or die("Error querying database.");
                
        // Display error if no exercise logs are found
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_array($result);
            $storedUserID = $row['user_id'];
            $date = $row['date'];
            $type = $row['type'];
            $length = $row['time_in_minutes'];
            $averageHeartRate = $row['heartrate'];
            $calories = $row['calories'];
            
            // Attempting to remove other user's exercise log
            if ($storedUserID != $userID) {
                echo '<p class="error">Invalid exercise log!</p>';
                require_once("footer.php");
                mysqli_close($dbc);
                exit();
            }
        } else {
            echo '<p class="error">Invalid exercise log!</p>';
            require_once("footer.php");
            exit();
        }

        mysqli_close($dbc);
    } else if (isset($_POST['submit']) && isset($_POST['id'])) {
        // Retrieve hidden exercise log id value
        $id = mysqli_real_escape_string($dbc, trim($_POST['id']));
        
        // Delete specified exercise log
        $query = "DELETE FROM exercise_log WHERE id='$id';";
        $result = mysqli_query($dbc, $query);
        
        // Display failure to delete if unable to remove exercise log
        if (!$result) {
            echo '<p class="error">Unable to delete exercise log.</p>';
        } else {
            echo '<h2>Successfully removed exercise log</h2>';
        }
        
        mysqli_close($dbc);
        require_once("footer.php");
        exit();
    } else {
        echo '<p class="error">No exercise log to remove!</p>';
        require_once("footer.php");
        mysqli_close($dbc);
        exit();
    }
?>

<section class="infoSection">
    <h2>Are you sure you wish to remove this exercise log?</h2>
    <h3>Exercise Log Info:</h3>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
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
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="submit" name="submit" value="Yes">
        <a href="viewProfile.php">No</a>
    </form>
</section>

<?
    
    require_once("footer.php");
?>