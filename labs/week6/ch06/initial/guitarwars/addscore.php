<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Guitar Wars - Add Your High Score</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
  <h2>Guitar Wars - Add Your High Score</h2>

<?php
    // Retrieve application constants
    require_once("appvars.php");
    
    // Retrieve database connection constants
    require_once("connectvars.php");
    
    if (isset($_POST['submit'])) {
        // Retrieve score data that was entered in form
        $name = trim($_POST['name']);
        $score = trim($_POST['score']);
        $screenshot = trim($_FILES['screenshot']['name']);
        $screenshot_size = $_FILES['screenshot']['size'];
        $screenshot_type = $_FILES['screenshot']['type'];

        // Validate that score data has been given values
        if (!empty($name) && is_numeric($score) && !empty($screenshot)) {
            
            // Validate file type and size of screenshot is correct
            if (($screenshot_type == "image/gif" || $screenshot_type == "image/jpeg"
                    || $screenshot_type == "image/pjpeg"
                    || $screenshot_type == "image/png")
                    && ($screenshot_size > 0 && $screenshot_size < GW_MAXFILESIZE)) {
            
                if ($_FILES['screenshot']['error'] == 0) {
                
                    // Move the file to the target upload folder
                    $target = GW_UPLOADPATH . $screenshot;
                    if (move_uploaded_file($_FILES['screenshot']['tmp_name'], $target)) {
                        
                        // Store user score in guitarwars database
                        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                                or die("Error connecting to database.");
                                
                        // Escape dangerous character codes
                        $name = mysqli_real_escape_string($dbc, $name);
                        $score = mysqli_real_escape_string($dbc, $score);
                        $screenshot = mysqli_real_escape_string($dbc, $screenshot);

                        $query = "INSERT INTO guitarwars (date, name, score, screenshot)
                                VALUES (NOW(), '$name', '$score', '$screenshot')";

                        mysqli_query($dbc, $query)
                                or die("Error querying database.");
                        
                        mysqli_close($dbc);

                        // Confirm addition of new score to user
                        echo '<p>Thanks for adding your new high score!</p>';
                        echo '<p><strong>Name:</strong> ' . $name . '<br />';
                        echo '<strong>Score:</strong> ' . $score . '</p>';
                        echo "<img src=\"$target\" alt=\"Score image\" />";
                        echo '<p><a href="index.php">&lt;&lt; Back to high scores</a></p>';

                        // Clear the score data to clear the sticky form values
                        $name = "";
                        $score = "";
                    }
                } else {
                    echo '<p class="error">Sorry, there was a problem uploading'
                            . 'your screenshot image.</p>';
                }
            } else {
                echo '<p class="error">The screenshot must be a GIF, JPEG, or '
                        . 'PNG image file no greater than '
                        . (GW_MAXFILESIZE / 1024) . ' KB in size.</p>';
            }
            
            // Delete the temporary screenshot image file if it exists
            if (file_exists($_FILES['screenshot']['tmp_name'])) {
                unlink($_FILES['screenshot']['tmp_name']);
            }
        }
        else {
            echo '<p class="error">Please enter all of the information to'
                    . ' add your high score.</p>';
        }
    }
?>

    <hr />
    <form enctype="multipart/form-data" method="post"
            action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo GW_MAXFILESIZE; ?>">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name"
                value="<?php if (!empty($name)) echo $name; ?>" /><br />
        <label for="score">Score:</label>
        <input type="text" id="score" name="score"
                value="<?php if (!empty($score)) echo $score; ?>" /><br />
        <label for="screenshot">Screenshot of Score:</label>
        <input type="file" id="screenshot" name="screenshot" />
        <hr />
        <input type="submit" value="Add" name="submit" />
    </form>
</body> 
</html>
