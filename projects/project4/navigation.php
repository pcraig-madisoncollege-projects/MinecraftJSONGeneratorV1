<?php
    require_once("startSession.php");
    
    if (isset($_SESSION['userID'])) {
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="collapse navbar-collapse" id="navbarColor01">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a href="index.php" class="nav-link">Home</a>
            </li>
            <li class="nav-item">
                <a href="generate.php" class="nav-link">Generate a Command</a>
            </li>
            <li class="nav-item">
                <a href="viewCommands.php" class="nav-link">View your Commands</a>
            </li>
            <li class="nav-item">
                <a href="logout.php" class="nav-link">Logout</a>
            </li>
        </ul>
    </div>
</nav>
<?php
    } else {
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="collapse navbar-collapse" id="navbarColor01">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a href="index.php" class="nav-link">Home</a>
            </li>
            <li class="nav-item">
                <a href="generate.php" class="nav-link">Generate a Command</a>
            </li>
            <li class="nav-item">
                <a href="login.php" class="nav-link">Login</a>
                </li>
            <li class="nav-item">
                <a href="createAccount.php" class="nav-link">Sign Up</a>
            </li>
        </ul>
    </div>
</nav>
<?php
    }
?>
