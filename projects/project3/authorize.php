<?php
    $username = 'admin';
    $password = 'admin';
    
    // Retrieve username and password if entered
    if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])
                || $_SERVER['PHP_AUTH_USER'] != $username
                || $_SERVER['PHP_AUTH_PW'] != $password) {
        // Deny access to webpage if password is incorrect
        header('HTTP/1.1 401 Unauthorized');
        header('WWW-Authenticate: Basic realm: "Good Reads"');
        
        // Display error page
        $pageTitle = "Access Denied";
        require_once("header.php");
        require_once("navigationBar.php");
        echo '<section class="centered"><h2>Invalid Username or Password</h2>';
        echo '<p class="error">Sorry, you must enter a valid username and '
                . 'password to access this page.</p></section>';
        require_once("footer.php");

        exit();
    }
?>
