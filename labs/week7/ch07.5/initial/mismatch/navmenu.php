<?php
    echo '<hr />';
    // Display the HTML navigation menu based on user's sign-in state
    if (isset($_SESSION['username'])) {
        echo '<a href="index.php">Home</a> &#10084; ';
        echo '<a href="viewprofile.php">View Profile</a> &#10084; ';
        echo '<a href="editprofile.php">Edit Profile</a> &#10084; ';
        echo '<a href="logout.php">Log Out (' . $_SESSION['username'] . ')</a>';
    }
    else {
        echo '<a href="index.php">Home</a> &#10084; ';
        echo '<a href="login.php">Log In</a> &#10084; ';
        echo '<a href="signup.php">Sign Up</a>';
    }
    echo '<hr />';
?>
