<?php
    $pageTitle = "Home";
    require_once("header.php");
    require_once("toolBar.php");
    
    // Set default sort mode if none is selected or retrieve sort mode
    if (!isset($_GET['sort'])) {
        $sort = 0;
    } else {
        $sort = $_GET['sort'];
    }

    require_once("sortBar.php");
    require_once("connectVars.php");
    
    // Retrieve previously entered blog posts
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die("Error connecting to database.");
    
    $result = mysqli_query($dbc, $query)
            or die("Error querying database.");
    
    mysqli_close($dbc);

    // Display each blog post and link to full post on the page
    echo '<section class="centered"><section class="cards">';
    while ($row = mysqli_fetch_array($result)) {
        $id = $row['id'];
        $title = $row['title'];
        $date = $row['date'];
        $post = $row['post'];
        
        echo generateBlogPostSection($id, $title, $date, $post);
        
    }
    echo "</section></section>";
    
    require_once("footer.php");
    
    
    // Returns a formatted HTML blog post section
    function generateBlogPostSection($id, $title, $date, $post) {
        // Truncate the post to show 100 characters
        $post = substr($post, 0, 150) . "...";

        // Generate the HTML section
        $output = "<a href=\"viewPost.php?id=$id\"><article class=\"card\">"
                . "<div class=\"card-content\"><h2>$title</h2><h3>Posted on $date</h3>"
                . "<p>$post</p></div></article></a>";

        return $output;
    }
?>
