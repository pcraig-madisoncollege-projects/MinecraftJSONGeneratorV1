<!DOCTYPE html>
<html>
    <head>
        <title>Project 1</title>
        <link rel="stylesheet" type="text/css" href="project1.css">
    </head>
    <body>
        <h1>Project 1</h1>
        <h2>Enter Some Words</h2>
<?php

// Retrieve sticky input values if form has been submitted
if (isset($_POST["submit"]))
{
    $noun = $_POST['noun'];
    $verb = $_POST['verb'];
    $adverb = $_POST['adverb'];
    $adjective = $_POST['adjective'];
    $story = "You enter a $adjective classroom with lots of desks and chairs. "
            . "On one of the desks, you see a $noun that is $adverb "
            . " shuffling papers. The $noun slowly spins towards you as if"
            . " it is aware of your presence. The $noun comes to a halt to"
            . " face you. Creeped out, you $verb and get the heck out of"
            . " there.";
}
else
{
    $noun = "";
    $verb = "";
    $adverb = "";
    $adjective = "";
}
?>
        <form action="project1.php" method="post">
            <label for="noun">Enter a Noun</label>
            <input type="text" name="noun" id="noun" value="<?php echo $noun; ?>">
            <label for="verb">Enter a Verb</label>
            <input type="text" name="verb" id="verb" value="<?php echo $verb; ?>">
            <label for="adverb">Enter an Adverb</label>
            <input type="text" name="adverb" id="adverb" value="<?php echo $adverb; ?>">
            <label for="adjective">Enter an Adjective</label>
            <input type="text" name="adjective" id="adjective" value="<?php echo $adjective; ?>">
            <input type="submit" name="submit" value="Enter Words">
        </form>
        
        <h2>Output</h2>
        
        <p>
<?php

// Display output only if form has been submitted
if (!isset($_POST['submit']))
{
    echo "Enter some words to create a story.";
}
else
{
    // Retrieve entered words if they are not empty
    if (!empty($_POST['noun']) && !empty($_POST['verb'])
            && !empty($_POST['adverb']) && !empty($_POST['adjective']))
    {
        // Store entered words and story into madlibs table of projects database
        $dbc = mysqli_connect('localhost', 'student', 'student', 'projects')
                    or die('Error connecting to MySQL server.');
                    
        $query = "INSERT INTO madlibs (noun, verb, adverb, adjective, story)
                VALUES ('$noun', '$verb', '$adverb', '$adjective', '$story');";
                
        mysqli_query($dbc, $query)
                or die('Error querying database.');
                    
        // Retrieve all previously entered stories
        $query = "SELECT * FROM madlibs ORDER BY userID desc;";
        
        $result = mysqli_query($dbc, $query)
                    or die('Error querying database.');
        
        mysqli_close($dbc);
        
        // Display user entered madlibs story
        echo $story;
?>
        </p>

        <h2>Previously Entered Stories</h2>
        
        <p>

<?php
        
        // Display all previously entered stories from newest to oldest
        while ($row = mysqli_fetch_array($result))
        {
            $enteredStory = $row['story'];
            
            echo $enteredStory . "<br><br>";
        }
    }
    else
    {
        echo "You must enter all form fields to create a story.";
    }
}

?>
        </p>
        
    </body>
    
</html>
