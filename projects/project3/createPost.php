<?php
    $pageTitle = "New Blog Post";
    require_once("header.php");
    require_once("navigationBar.php");
    require_once("connectVars.php");
    
    // Default to not display the blog input form
    $displayForm = false;
    
    // Display blog creation form if it has not been submitted
    if (!isset($_POST['submit'])) {
        $displayForm = true;
        
        $title = "";
        $post = "";
    } else {
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                or die("Error connecting to database.");
        
        // Retrieve entered post fields
        $title = mysqli_real_escape_string($dbc, trim($_POST['title']));
        // Retain line breaks in blog post by replacing them with HTML line breaks
        $post = str_replace("\r\n", "<br>", trim($_POST['post']));
        $post = mysqli_real_escape_string($dbc, $post);
        
        // Confirm valid form entries before submitting
        if (empty($title) || empty($post)) {
            $displayForm = true;

            echo '<p class="error">You must enter a title and post content '
                    . 'before submitting.</p>';
        } else if (strlen($title) > 50) {
            $displayForm = true;

            // Display error if title is too long
            echo '<p class="error">The blog title cannot be more than 50 '
                    . 'characters long.</p>';
        } else {
            // Add the new blog to the database
            $query = "INSERT INTO blog_post (title, date, post) "
                    . "VALUES ('$title', NOW(), '$post');";
            mysqli_query($dbc, $query)
                    or die("Error querying database.");
            
            // Display success message and the new post that was submitted
            echo '<h2 class="centered">Successfully saved new blog post!</h2>';
            echo "<h3>$title</h3>";
            echo "<p>$post</p>";
        }
        
        mysqli_close($dbc);
    }
    
    
    // Display the blog post form if necessary
    if ($displayForm) {
?>
        <section class="centered">
            <section class="cards">
                <article class="card">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="card-content">
                        <label for="title">Blog Post Title</label>
                        <input type="text" id="title" name="title" value="<?php echo $title; ?>">
                        <br><br>
                        <label for="post">Blog Post Content</label>
                        <textarea rows="50" cols="100" id="post" name="post"><?php echo $post; ?></textarea>
                        <br>
                        <input type="submit" name="submit" value="Create Blog Post">
                    </form>
                </article>
            </section>
        </section>

<?php
    }
    require_once("footer.php");
?>
