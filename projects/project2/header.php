<?php error_reporting(E_ALL); ?>
<!DOCTYPE html>
<!--
    Author: Peter Craig
    Date: 4/3/2020
-->
<html lang="en">

<head>
    <title>Fitness Advanced - <?php echo $pageTitle; ?></title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="stylesheets/main.css">
</head>

    <body>

        <header>
            <h1><?php echo "$pageTitle"; ?></h1>
            <hr>
            <?php require_once("navigationBar.php"); ?>
            <hr>
        </header>

        <main>

<?php
    $headerDisplayed = true;
?>
