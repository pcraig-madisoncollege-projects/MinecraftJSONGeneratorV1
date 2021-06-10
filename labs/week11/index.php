<!DOCTYPE html>
<html>
    <head>
        <title>Madlibs Revived</title>
        <link rel="stylesheet" type="text/css" href="main.css">
    </head>
    <body>
        <h1>Madlibs Revived</h1>
        <h2>Enter Some Words</h2>
<?php

    // Include Madlibs class in program
    require_once("Madlibs.php");
    
    // Retrieve clean input values if form has been submitted
    if (isset($_POST['submit']))
    {
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                or die("Error connecting to database.");
        
        $noun = mysqli_real_escape_string($dbc, trim($_POST['noun']));
        $verb = mysqli_real_escape_string($dbc, trim($_POST['verb']));
        $adverb = mysqli_real_escape_string($dbc, trim($_POST['adverb']));
        $adjective = mysqli_real_escape_string($dbc, trim($_POST['adjective']));
        
        mysqli_close($dbc);
    }
    else
    {
        // Declare story variables and assign empty values
        $noun = "";
        $verb = "";
        $adverb = "";
        $adjective = "";
    }
?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
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
            // Create madlibs story from user input
            $story = "You enter a $adjective classroom with lots of desks and chairs. "
                . "On one of the desks, you see a $noun that is $adverb "
                . " shuffling papers. The $noun slowly spins towards you as if"
                . " it is aware of your presence. The $noun comes to a halt to"
                . " face you. Creeped out, you $verb and get the heck out of"
                . " there.";

            // Store a new story into an Madlibs instance
            $madlibsStory = new Madlibs();
            $madlibsStory->setNoun($noun);
            $madlibsStory->setVerb($verb);
            $madlibsStory->setAdjective($adjective);
            $madlibsStory->setAdverb($adverb);
            $madlibsStory->setStory($story);

            $madlibsStory->addStoryToDatabase();

            // Retrieve all stories from newest to oldest as query result
            $stories = $madlibsStory->retrieveNewestStories();
            
            // Generate HTML table from results
            $table = $madlibsStory->formatStoriesResult($stories);
            
            // Display entered story
            echo $madlibsStory->getStory();
?>
        </p>

        <h2>Previously Entered Stories</h2>
        

<?php
            // Display formatted table of all existing stories
            echo $table;
        }
        else
        {
            echo "You must enter all words to create a story.";
        }
    }

?>
        
    </body>
    
</html>
