<?php
    require_once("connectVars.php");
    
    // Display blog post if GET value exists
    if (isset($_GET['id'])) {
        // Retrieve blog post from id if valid
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                or die("Error connecting to database.");

        $id = mysqli_real_escape_string($dbc, trim($_GET['id']));
        
        // Confirm that id is a valid id
        if (!empty($id) && is_numeric($id) && round($id) == $id && $id > 0) {
            // Retrieve blog post from database
            $query = "SELECT title, date, post FROM blog_post WHERE id = '$id'"
                    . " LIMIT 1;";
            $result = mysqli_query($dbc, $query)
                    or die("Error querying database.");
            $result = mysqli_fetch_array($result);
            
            $pageTitle = $result['title'];
            $date = $result['date'];
            $post = $result['post'];
            
            // Display blog post and generic HTML content on page
            require_once("header.php");
            require_once("navigationBar.php");
            echo "<h2>Posted on $date</h2>";
            echo "<p>$post</p>";
            require_once("footer.php");
            exit();
        }
        
        mysqli_close($dbc);
    }
    // Display invalid page by default
    $pageTitle = "View Blog Post";
    require_once("header.php");
    require_once("navigationBar.php");
    echo "<h2>Unknown Blog Post</h2>";
    echo "<p>Unable to find the blog post.</p>";
    require_once("footer.php");
?>
