<?php
    require_once("authorize.php");
    
    // Display general page html
    $pageTitle = "Admin Delete Tellraw Command";
    require_once("header.php");

    require_once("connectVars.php");
    
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                or die("Error connecting to database.");
    
    // Check if valid commands exists
    if (isset($_GET['id'])) {
        // Retrieve commands id from GET
        $id = mysqli_real_escape_string($dbc, trim($_GET['id']));
        
        // Retrieve commands from database
        $query = "select name, command, datesaved, TU.username"
            . " from TELLRAW_USER AS TU"
            . " join TELLRAW_COMMANDS AS TC"
            . " on TU.id = TC.userID"
            . " where TC.id = '$id';";
        $result = mysqli_query($dbc, $query)
                or die("Error querying database.");
                
        // Display error if no commands are found, otherwise retrieve command data
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_array($result);
            $name = $row['name'];
            $command = $row['command'];
            $dateSaved = $row['datesaved'];
            $username = $row['username'];
        } else {
            echo '<p class="alert">Invalid command!</p>';
            require_once("footer.php");
            exit();
        }

        mysqli_close($dbc);
    } else if (isset($_POST['submit']) && isset($_POST['id'])) {
        // Retrieve hidden command id value
        $id = mysqli_real_escape_string($dbc, trim($_POST['id']));
        
        // Delete specified command
        $query = "DELETE FROM tellraw_commands WHERE id='$id';";
        $result = mysqli_query($dbc, $query);
        
        // Display failure to delete if unable to remove command
        if (!$result) {
            echo '<p class="alert">Unable to delete command.</p>';
        } else {
            echo '<div class="container"><h2>Successfully removed tellraw '
                    . 'command</h2><a href="admin.php">Return to Admin Control Page</a></div>';
        }
        
        mysqli_close($dbc);
        require_once("footer.php");
        exit();
    } else {
        echo '<p class="alert">No tellraw command to remove!</p>';
        require_once("footer.php");
        mysqli_close($dbc);
        exit();
    }
?>

<section class="container">
    <h2>Are you sure you wish to remove this tellraw command?</h2>
    <h3><?php echo $name ?>:</h3>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <h4>Saved on <?php echo "Saved by $username on $dateSaved"; ?></h4>
        <div class="form-group">
            <textarea class="form-control" readonly cols="150" rows="6"><?php echo $command; ?></textarea>
        </div>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="form-group">
            <input class="btn btn-primary" type="submit" name="submit" value="Delete Command">
        </div>
        <br>
        <a href="admin.php">Cancel</a>
    </form>
</section>

<?
    
    require_once("footer.php");
?>