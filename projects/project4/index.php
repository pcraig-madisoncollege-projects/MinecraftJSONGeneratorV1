<?php
    $pageTitle = "Home";
    require_once("header.php");
?>

<section class="container">
    <h2>Minecraft Tellraw Generator</h2>
    <h3>About</h3>
    <p>
        Welcome to Peter Craig's tellraw generator for Minecraft. With this tool,
        you can easily generate complex tellraw commands that would otherwise
        require you to know JSON and how to format it for Minecraft. Anyone can
        use the tool, but logged-in users have the added ability to save their
        generated commands.
    </p>
    <h3>Features</h3>
    <p>
        This tellraw generator requires JavaScript in order to run, However,
        it supports the following tellraw components:
    </p>
    <ul>
        <li>Text Components</li>
        <li>Target Selector Components</li>
        <li>Scoreboard Objective Components</li>
        <li>Keybind Components</li>
        <li>Translation Components</li>
    </ul>
</section>

<?php
    require_once("footer.php");
?>