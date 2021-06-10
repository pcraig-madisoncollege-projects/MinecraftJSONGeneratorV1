<?php
    $pageTitle = "Generate a Command";
    require_once("header.php");
    require_once("connectVars.php");
    
    // Attempt to save command if save button has been pressed
    if (isset($_POST['save'])) {
        if (isset($_SESSION['userID'])) {
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                    or die("Error connecting to database.");
            
            // Retrieve entered name and command
            $name = mysqli_real_escape_string($dbc, trim($_POST['name']));
            $command = $_POST['command'];
            $cleanCommand = mysqli_real_escape_string($dbc, trim($command));
            $userID = $_SESSION['userID'];

            // Failed to generate a command
            if (empty($command)) {
                echo '<p class="alert">Failed to save command!</p>';
                require_once("footer.php");
                mysqli_close($dbc);
                exit();
            } else {
                // Default the command name to untitled if none is provided
                if (empty($name)) {
                    $name = "Untitled";
                }
                
                $query = "INSERT INTO tellraw_commands (name, command, datesaved, userID)"
                        . " VALUES('$name', '$cleanCommand', NOW(), $userID)";
                mysqli_query($dbc, $query)
                        or die("Error querying database.");
                        
                mysqli_close($dbc);
                
                echo '<div class="container"><h2>Successfully saved your command!</h2>';
                echo "<h3>$name</h3>";
                echo "<textarea class='form-control' readonly cols=\"150\" rows=\"6\">$command</textarea>";
                echo "</div>";
                require_once("footer.php");
                exit();
            }
        } else {
            echo '<p class="alert">You cannot save unless you are logged in</p>';
        }
    } else {
?>

<section class="container">
    <h2>Enter Your Tellraw Message Below</h2>
    <form id="tellrawForm" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<?php
    // Allow users to save a name to their command if logged in
    if (isset($_SESSION['userID'])) {
?>
        <div class="form-group">
            <label for="name">Name to Save for this Command: </label>
            <input class="form-control" type="text" id="name" name="name">
        </div>
<?php
    }
?>
        <div class="form-group">
            <label for="targetSelector">Command Target Selector: </label>
            <select class="form-control" id="targetSelector">
                <option value="@a">@a</option>
                <option value="@p">@p</option>
                <option value="@e">@e</option>
                <option value="@s">@s</option>
            </select>
        </div>
        <div class="form-group">
            <label for="arguments">Command Target Selector Arguments: </label>
            <input class="form-control" type="text" id="arguments">
        </div>
        <fieldset>
            <input class="btn btn-primary" type="button" value="Add Text Element" onclick="addElement('text');">
            <input class="btn btn-primary" type="button" value="Add Linebreak" onclick="addElement('linebreak');">
            <input class="btn btn-primary" type="button" value="Add Selector Element" onclick="addElement('selector');">
            <input class="btn btn-primary" type="button" value="Add Score Element" onclick="addElement('score');">
            <input class="btn btn-primary" type="button" value="Add Keybind Element" onclick="addElement('keybind');">
            <input class="btn btn-primary"type="button" value="Add Translate Element" onclick="addElement('translate');">
            <hr>
            <legend>Tellraw Elements</legend>
            <div id="tellrawElements">
                <p>No tellraw elements have been added.</p>
            </div>
            <hr>
        </fieldset>
        <label for="commandOutput">Command:</label>
        <br>
        <div class="form-group">
            <textarea class="form-control" id="commandOutput" name="command" readonly cols="150" rows="6"></textarea>
        </div>
        <input class="btn btn-primary" type="button" name="generate" value="Generate Command" onclick="generateCommand();">
<?php
    if (isset($_SESSION['userID'])) {
?>
        <input class="btn btn-primary" type="submit" name="save" value="Save Command" onclick="generateCommand();">
        <p>
            *Once you have saved your command, you can no longer make changes
            to this particular command.
        </p>
<?php
    } else {
        echo '<p>*You cannot save your command unless you login.</p>';
    }
?>
    </form>
</section>

<?php
    }
    
    require_once("footer.php");
?>