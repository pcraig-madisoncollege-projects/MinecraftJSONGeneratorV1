<?php
    require_once("startSession.php");
    require_once("connectVars.php");
    
    $pageTitle = "Edit Profile";
    require_once("header.php");
    
    require_once("login.php");
    
    // Store empty sticky values for selection options in form
    $noneSelected = "";
    $maleSelected = "";
    $femaleSelected = "";
    if (!empty($gender)) {
        // Auto-select the currently saved gender
        if ($gender == 'm') {
            $maleSelected = "selected";
        } else {
            $femaleSelected = "selected";
        }
    } else {
        $noneSelected = "selected";
    }
    
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die("Error connecting to database.");
    
    // Edit profile values if form hasn't been submitted
    if (!isset($_POST['submit'])) {
        // Store generic name in case no username is obtained
        $username = "User";
        $userID = mysqli_real_escape_string($dbc, trim($_SESSION['userID']));
        
        // Retrieve user profile information
        $query = "select * from exercise_user where id='$userID';";
        
        $result = mysqli_query($dbc, $query)
                or die("Error querying database.");
        
        // Confirm that valid user was found
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_array($result);

            // Store profile information or not set if profile hasn't been edited yet
            $username = $row['username'];
            $firstName = "";
            $lastName = "";
            $gender = "";
            $birthdate = "";
            $weight = "";
            
            if (!empty($row['first_name'])) {
                $firstName = $row['first_name'];
            }
            if (!empty($row['last_name'])) {
                $lastName = $row['last_name'];
            }
            if (!empty($row['birthdate'])) {
                $birthdate = $row['birthdate'];
            }
            if (!empty($row['weight'])) {
                $weight = $row['weight'];
            }
        }
    } else {
        $enteredFirstName = "'"
                . mysqli_real_escape_string($dbc, trim($_POST['firstName']))
                . "'";
        $enteredLastName = "'"
                . mysqli_real_escape_string($dbc, trim($_POST['lastName']))
                . "'";
        $enteredGender = "'"
                . mysqli_real_escape_string($dbc, trim($_POST['gender']))
                . "'";
        $enteredBirthdate = "'"
                . mysqli_real_escape_string($dbc, trim($_POST['birthdate']))
                . "'";
        $enteredWeight = mysqli_real_escape_string($dbc, trim($_POST['weight']));
        
        // Validate that weight provided was a number
        if (empty($enteredWeight) || is_numeric($enteredWeight)) {
            $validEnteredWeight = true;
            if (empty($enteredWeight)) {
                // Store empty weight
                $enteredWeight = "null";
            } else {
                // Compare entered weight to make sure it isn't a decmial number
                $enteredWeightDecimal = (float) $enteredWeight;
                if (round($enteredWeight) != $enteredWeightDecimal) {
                    $validEnteredWeight = false;
                    echo '<p class="error">You cannot enter decimal numbers for'
                            . ' your weight.</p>';
                    $weight = $enteredWeight;
                }
            }
            
            // Confirm that entered weight is not a decimal
            if ($validEnteredWeight) {
                // Set values to null if no value was given
                if ($enteredFirstName == "''") {
                    $enteredFirstName = "null";
                }
                if ($enteredLastName == "''") {
                    $enteredLastName = "null";
                }
                if ($enteredGender == "''") {
                    $enteredGender = "null";
                }
                if ($enteredBirthdate == "''") {
                    $enteredBirthdate = "null";
                }
                
                // Update user's information with provided values
                $query = "update exercise_user set first_name=$enteredFirstName,"
                        . "last_name=$enteredLastName,gender=$enteredGender,"
                        . "birthdate=$enteredBirthdate,weight=$enteredWeight "
                        . "where id=$userID;";
                mysqli_query($dbc, $query)
                        or die("Error querying database.");
                        
                echo "<h2>You successfully updated your profile!</h2>";
                require_once("viewProfile.php");
                
                // Close the connection to the database if it still exists
                if (!$dbc) {
                    mysqli_close($dbc);
                }
                
                exit();
            }
        } else if (!is_numeric($enteredWeight)) {
            // Display error if value entered is not a valid weight
            echo '<p class="error">You must enter a valid number for your '
                    . 'weight with no decimal numbers.';
        }
    }
    
    // Close the connection to the database if it still exists
    if (!$dbc) {
        mysqli_close($dbc);
    }
    
?>

<section class="profile">
    <h2><?php echo strtoupper($username); ?>'s Profile</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <table class="profile">
            <tr>
                <td>First Name:</td>
                <td><input type="text" name="firstName" value="<?php echo $firstName; ?>"></td>
            </tr>
            <tr>
                <td>Last Name:</td>
                <td><input type="text" name="lastName" value="<?php echo $lastName; ?>"></td>
            </tr>
            <tr>
                <td>Gender:</td>
                <td>
                    <select name="gender">
                        <option value=""  <?php echo $noneSelected; ?>></option>
                        <option value="m" <?php echo $maleSelected; ?>>M</option>
                        <option value="f" <?php echo $femaleSelected; ?>>F</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Birthdate:</td>
                <td><input type="date" name="birthdate" value="<?php echo $birthdate; ?>"></td>
            </tr>
            <tr>
                <td>Weight:</td>
                <td><input type="text" name="weight" value="<?php echo $weight; ?>"> lbs</td>
            </tr>
        </table>
        
        <input type="submit" name="submit" value="Save Profile">
        <a href="viewProfile.php">Cancel</a>
        <p>
            *Note: None of the fields are required to be entered, but you 
            cannot log any exercises until the minimum of gender, birthdate, 
            and weight have been entered.
        </p>
    </form>
</section>

<?php
    
    require_once("footer.php");
?>