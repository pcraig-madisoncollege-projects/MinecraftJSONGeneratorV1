<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Risky Jobs - Registration</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
    <img src="riskyjobs_title.gif" alt="Risky Jobs" />
    <img src="riskyjobs_fireman.jpg" alt="Risky Jobs" style="float:right" />
    <h3>Risky Jobs - Registration</h3>

<?php
    if (isset($_POST['submit'])) {
        $first_name = trim($_POST['firstname']);
        $last_name = trim($_POST['lastname']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $job = trim($_POST['job']);
        $resume = trim($_POST['resume']);
        $output_form = false;

        // Re-display form if no first name was entered
        if (empty($first_name)) {
            echo '<p class="error">You forgot to enter your first name.</p>';
            $output_form = true;
        }

        // Re-display form if no last name was entered
        if (empty($last_name)) {
            echo '<p class="error">You forgot to enter your last name.</p>';
            $output_form = true;
        }

        // Re-display form if no email was entered
        if (empty($email)) {
            echo '<p class="error">You forgot to enter your email address.</p>';
            $output_form = true;
        } else {
            // Validate the email address local name matches the regex pattern
            $local_name_pattern = "/^[a-zA-Z0-9][a-zA-Z0-9\._\-&!?=#]*@/";
            if (!preg_match($local_name_pattern, $email)) {
                echo '<p class="error">Your email address is invalid.</p>';
                $output_form = true;
            } else {
                // Retrieve domain from email address through regex
                $domain = preg_replace($local_name_pattern, '', $email);
                
                // Display error if domain name is not valid
                if (!checkdnsrr($domain)) {
                    echo '<p class="error">Your email address is invalid.</p>';
                    $output_form = true;
                }
            }
        }

        // Re-display form if no phone was entered
        if (empty($phone)) {
            echo '<p class="error">You forgot to enter your phone number.</p>';
            $output_form = true;
        } else {
            // Validate that the entered phone matches the regex pattern for a phone number
            $pattern = "/^\(?[2-9]\d{2}\)?[-\.\s]\d{3}[-\.\s]\d{4}$/";
            if (!preg_match($pattern, $phone)) {
                // Display error if phone number does not match the required pattern
                echo '<p class="error">Your phone number is invalid.</p>';
                $output_form = true;
            } else {
                // Remove extra characters from entered phone number
                $clean_pattern = "/[\(\)\-\.\s]/";
                $new_phone = preg_replace($clean_pattern, '', $phone);
            }
        }

        // Re-display form if no job was entered
        if (empty($job)) {
            echo '<p class="error">You forgot to enter your desired job.</p>';
            $output_form = true;
        }

        // Re-display form if no resume was entered
        if (empty($resume)) {
            echo '<p class="error">You forgot to enter your resume.</p>';
            $output_form = true;
        }
    }
    else {
        // Set default empty values if the form has not yet been submitted
        $first_name = '';
        $last_name = '';
        $email = '';
        $phone = '';
        $job = '';
        $resume = '';
        $output_form = true;
    }

    // Display form if first time or invalid form entry
    if ($output_form) {
?>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
     <p>Register with Risky Jobs, and post your resume.</p>
    <table>
        <tr>
            <td><label for="firstname">First Name:</label></td>
            <td><input id="firstname" name="firstname" type="text" value="<?php echo $first_name; ?>"/></td>
        </tr>
        <tr>
            <td><label for="lastname">Last Name:</label></td>
            <td><input id="lastname" name="lastname" type="text" value="<?php echo $last_name; ?>"/></td>
        </tr>
        <tr>
            <td><label for="email">Email:</label></td>
            <td><input id="email" name="email" type="text" value="<?php echo $email; ?>"/></td>
        </tr>
        <tr>
            <td><label for="phone">Phone:</label></td>
            <td><input id="phone" name="phone" type="text" value="<?php echo $phone; ?>"/></td>
        </tr>
        <tr>
            <td><label for="job">Desired Job:</label></td>
            <td><input id="job" name="job" type="text" value="<?php echo $job; ?>"/></td>
        </tr>
    </table>
    <p>
        <label for="resume">Paste your resume here:</label><br />
        <textarea id="resume" name="resume" rows="4" cols="40"><?php echo $resume; ?></textarea><br />
        <input type="submit" name="submit" value="Submit" />
    </p>
</form>

<?php
    }
    else {
        // Register data if form validates
        echo "<p>Thanks, $first_name $last_name, for registering with Risky Jobs!</p>";
        echo "<p>Your phone has been registered as $new_phone.</p>";

        // code to insert data into the RiskyJobs database...
    }
?>

</body>
</html>
