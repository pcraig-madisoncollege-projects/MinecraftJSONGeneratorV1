<?php
    require_once('startSession.php');

    // Force login cookies to expire
    if (isset($_SESSION['userID'])) {
        // Empty the session array
        $_SESSION = array();

        // Clear session cookies if they exist
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600);
        }

        // End the user session
        session_destroy();
    }

    // Force expiration of login information cookies
    setcookie('userID', '', time() - 3600);

    // Redirect to the home page
    $homeURL = 'http://' . $_SERVER['HTTP_HOST']
            . dirname($_SERVER['PHP_SELF']) . '/index.php';
    header('Location: ' . $homeURL);
?>
