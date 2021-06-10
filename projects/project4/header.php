<!DOCTYPE html>
<html lang="en">
<head>
    <title>MC Tellraw Generator - <?php echo $pageTitle; ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="stylesheets/main.css">
    <script src="scripts/tellrawGenerator.js"></script>
    <script src="scripts/tellrawElements.js"></script>
</head>
<body>

    <header class="col-lg-12">
        <h1><?php echo $pageTitle; ?></h1>
<?php
    require_once("navigation.php");
?>
        <hr>
    </header>

    <main>

<?php
    $headerDisplayed = true;
?>
