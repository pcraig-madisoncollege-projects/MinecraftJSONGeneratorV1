<?php
    require_once('initializesession.php');

    require_once('login.php');

    // Confirm user is logged in
    if (!isset($_SESSION['user_id'])) {
        exit('<p class="error">You must be logged in to view this page.</p>');
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Mismatch - Edit Profile</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
    <h3>Mismatch - Edit Profile</h3>

<?php

    require_once('appvars.php');
    require_once('connectvars.php');

    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username'];

    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die("Error connecting to database.");

    // Retrieve profile data when form is submitted
    if (isset($_POST['submit'])) {
        $first_name = mysqli_real_escape_string($dbc, trim($_POST['firstname']));
        $last_name = mysqli_real_escape_string($dbc, trim($_POST['lastname']));
        $gender = mysqli_real_escape_string($dbc, trim($_POST['gender']));
        $birthdate = mysqli_real_escape_string($dbc, trim($_POST['birthdate']));
        $city = mysqli_real_escape_string($dbc, trim($_POST['city']));
        $state = mysqli_real_escape_string($dbc, trim($_POST['state']));
        $old_picture = mysqli_real_escape_string($dbc, trim($_POST['old_picture']));
        $new_picture = mysqli_real_escape_string($dbc, trim($_FILES['new_picture']['name']));
        $error = false;

        // Validate and move the uploaded picture file if new image was uploaded
        if (!empty($new_picture)) {
            // Retrieve new profile image info
            $new_picture_type = $_FILES['new_picture']['type'];
            $new_picture_size = $_FILES['new_picture']['size'];

            if ($_FILES['new_picture']['error'] == 0) {
                if ((($new_picture_type == 'image/gif')
                        || ($new_picture_type == 'image/jpeg')
                        || ($new_picture_type == 'image/pjpeg')
                        || ($new_picture_type == 'image/png'))) {
                    
                    // Store and check profile image dimensions
                    $new_picture_temp_dir = $_FILES['new_picture']['tmp_name'];
                    list($new_picture_width, $new_picture_height) = getimagesize($new_picture_temp_dir);

                    if (($new_picture_width <= MM_MAXIMGWIDTH)
                            && ($new_picture_height <= MM_MAXIMGHEIGHT)) {

                        // Move the good image file to the target upload folder
                        $target = MM_UPLOADPATH . basename($new_picture);
                        if (move_uploaded_file($_FILES['new_picture']['tmp_name'], $target)) {
                            // Delete old profile picture if new one was moved
                            if (!empty($old_picture) && ($old_picture != $new_picture)) {
                                if (file_exists(MM_UPLOADPATH . $old_picture)) {
                                    unlink(MM_UPLOADPATH . $old_picture);
                                }
                            }
                        } else {
                            // Delete image if it could not be moved
                            if (file_exists($_FILES['new_picture']['tmp_name'])) {
                                unlink($_FILES['new_picture']['tmp_name']);
                            }
                            $error = true;
                            echo '<p class="error">Sorry, there was a problem '
                                    . 'uploading your picture.</p>';
                        }
                    } else {
                        // Image file exceeds maximum image dimensions
                        $error = true;
                        echo '<p class="error">Your picture must be '
                                . MM_MAXIMGWIDTH . 'x' . MM_MAXIMGHEIGHT
                                . ' pixels in size.</p>';
                    }
                } else {
                    // Bad file type uploaded
                    $error = true;
                    echo '<p class="error">Your picture must be a GIF, JPEG, or '
                    .'PNG image file.';
                }
            } else {
                if ($_FILES['new_picture']['error'] == 2) {
                    // File exceeds maximum upload size
                    $error = true;
                    echo '<p class="error">Your image file cannot be more'
                            . ' than ' . (MM_MAXFILESIZE / 1024) . ' KB in'
                            . ' file size.';
                } else {
                    // Other file upload error
                    $error = true;
                    echo '<p class="error">Sorry, there was a problem '
                            . 'uploading your picture.</p>';
                }
            }
        }

        // Update the profile data in the database if no errors have occurred
        if (!$error) {
            if (!empty($first_name) && !empty($last_name) && !empty($gender)
                    && !empty($birthdate) && !empty($city) && !empty($state)) {
                // Only set the picture column if there is a new picture
                if (!empty($new_picture)) {
                    $query = "UPDATE mismatch_user SET first_name = '$first_name'"
                            . ", last_name = '$last_name', gender = '$gender', "
                            . " birthdate = '$birthdate', city = '$city', "
                            . "state = '$state', picture = '$new_picture' "
                            . "WHERE user_id = '$user_id'";
                }
                else {
                    $query = "UPDATE mismatch_user SET first_name = '$first_name'"
                            . ", last_name = '$last_name', gender = '$gender', "
                            . " birthdate = '$birthdate', city = '$city', "
                            . "state = '$state' WHERE user_id = '$user_id'";
                }
                mysqli_query($dbc, $query)
                        or die("Error querying database.");

                // Confirm profile update success with the user
                echo '<p>Your profile has been successfully updated. Would you like to <a href="viewprofile.php">view your profile</a>?</p>';

                mysqli_close($dbc);
                exit();
            } else {
                echo '<p class="error">You must enter all of the profile data (the picture is optional).</p>';
            }
        }
    } else {
        // Retrieve original profile data from the database
        $query = "SELECT first_name, last_name, gender, birthdate, city, state, picture FROM mismatch_user WHERE user_id = '$user_id'";
        $data = mysqli_query($dbc, $query)
                or die("Error querying database.");
        $row = mysqli_fetch_array($data);

        // Store original profile data
        if ($row != NULL) {
            $first_name = $row['first_name'];
            $last_name = $row['last_name'];
            $gender = $row['gender'];
            $birthdate = $row['birthdate'];
            $city = $row['city'];
            $state = $row['state'];
            $old_picture = $row['picture'];
        }
        else {
            echo '<p class="error">There was a problem accessing your profile.</p>';
        }
    }

    mysqli_close($dbc);
?>

    <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM_MAXFILESIZE; ?>" />
        <fieldset>
            <legend>Personal Information</legend>
            <label for="firstname">First name:</label>
            <input type="text" id="firstname" name="firstname" value="<?php if (!empty($first_name)) echo $first_name; ?>" /><br />
            <label for="lastname">Last name:</label>
            <input type="text" id="lastname" name="lastname" value="<?php if (!empty($last_name)) echo $last_name; ?>" /><br />
            <label for="gender">Gender:</label>
            <select id="gender" name="gender">
                <option value="M" <?php if (!empty($gender) && $gender == 'M') echo 'selected = "selected"'; ?>>Male</option>
                <option value="F" <?php if (!empty($gender) && $gender == 'F') echo 'selected = "selected"'; ?>>Female</option>
            </select><br />
            <label for="birthdate">Birthdate:</label>
            <input type="text" id="birthdate" name="birthdate" value="<?php if (!empty($birthdate)) echo $birthdate; else echo 'YYYY-MM-DD'; ?>" /><br />
            <label for="city">City:</label>
            <input type="text" id="city" name="city" value="<?php if (!empty($city)) echo $city; ?>" /><br />
            <label for="state">State:</label>
            <input type="text" id="state" name="state" value="<?php if (!empty($state)) echo $state; ?>" /><br />
            <input type="hidden" name="old_picture" value="<?php if (!empty($old_picture)) echo $old_picture; ?>" />
            <label for="new_picture">Picture:</label>
            <input type="file" id="new_picture" name="new_picture" />
            <?php if (!empty($old_picture)) {
                echo '<br><img class="profile" src="' . MM_UPLOADPATH . $old_picture . '" alt="Profile Picture" />';
            } ?>
        </fieldset>
        <input type="submit" value="Save Profile" name="submit" />
    </form>
</body> 
</html>
