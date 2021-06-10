<?php
    // Begin user session
    session_start();

    // Attempt to preload session variables with cookies if saved login exists
    if (!isset($_SESSION['userID'])) {
        if (isset($_COOKIE['userID'])) {
            $_SESSION['userID'] = $_COOKIE['userID'];
        }
    }
?>