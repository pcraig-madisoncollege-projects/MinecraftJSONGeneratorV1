<?php
    require_once("authorize.php");
    $pageTitle = "Delete Blog Post";
    require_once("header.php");
    require_once("adminNavigationBar.php");
    require_once("connectVars.php");
    
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                    or die("Error connecting to database.");

    // Delete blog post if form has been submitted
    if (isset($_POST['submit'])) {
        $id = mysqli_real_escape_string($dbc, trim($_POST['id']));
        // Confirm that id is a valid id
        if (!empty($id) && is_numeric($id) && round($id) == $id && $id > 0) {
            $query = "DELETE FROM blog_post WHERE id = '$id'";
            $result = mysqli_query($dbc, $query)
                    or die("Error querying database.");
            // Display deletion success
            echo "<h2>Successfully deleted blog post!</h2>";
            require_once("footer.php");
            mysqli_close($dbc);
            exit();
        } else {
            // Display error message if post is invalid
            echo "<h2>Invalid Blog Post</h2>";
            require_once("footer.php");
            mysqli_close($dbc);
            exit();
        }
    } else {
        // Display blog post if GET value exists
        if (isset($_GET['id'])) {
            // Retrieve blog post from id if valid
            $id = mysqli_real_escape_string($dbc, trim($_GET['id']));
            
            // Confirm that id is a valid id
            if (!empty($id) && is_numeric($id) && round($id) == $id && $id > 0) {
                // Retrieve blog post from database
                $query = "SELECT title, date, post FROM blog_post WHERE id = '$id'"
                        . " LIMIT 1;";
                $result = mysqli_query($dbc, $query)
                        or die("Error querying database.");
                $result = mysqli_fetch_array($result);
                
                $title = $result['title'];
                $date = $result['date'];
                $post = $result['post'];
                
                // Display blog post and generic HTML content on page
?>
    <h2>Are you sure you want to delete this blog post?</h2>
    <h3><?php echo $title; ?></h3>
    <h4>Posted on <?php echo $date; ?></h4>
    <p><?php echo $post; ?></p>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="submit" name="submit" value="Delete Blog Post">
    </form>
<?php
                require_once("footer.php");
                mysqli_close($dbc);
                exit();
            }
        }
        // Display invalid page by default
        $pageTitle = "Delete Blog Post";
        require_once("header.php");
        require_once("navigationBar.php");
        echo "<h2>Unknown Blog Post</h2>";
        echo "<p>Unable to find the blog post.</p>";
        require_once("footer.php");
    }
    
    mysqli_close($dbc);
?>
