<?php
    require_once('initializesession.php');

    // Force login cookies to expire
    if (isset($_SESSION['user_id'])) {
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
    setcookie('user_id', '', time() - 3600);
    setcookie('username', '', time() - 3600);

    // Redirect to the home page
    $home_url = 'http://' . $_SERVER['HTTP_HOST']
            . dirname($_SERVER['PHP_SELF']) . '/index.php';
    header('Location: ' . $home_url);
?>
