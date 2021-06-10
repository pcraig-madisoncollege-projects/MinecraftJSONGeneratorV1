<?php
    // Display each sort bar variant and modify query to include intended results
    switch ($sort) {
        case 0: // Newest to oldest
?>
<p class="centered">
    &bull;<a href="?sort=1">Sort by Oldest</a>&bull;
    <a href="?sort=2">Sort by Ascending Title</a>&bull;
    <a href="?sort=4">Sort by Ascending Post Length</a>&bull;
</p>
<?php
            $query = "SELECT * FROM blog_post ORDER BY date DESC";
            break;
        case 1: // Oldest to newest
?>
<p class="centered">
    &bull;<a href="?sort=0">Sort by Newest</a>&bull;
    <a href="?sort=2">Sort by Ascending Title</a>&bull;
    <a href="?sort=4">Sort by Ascending Post Length</a>&bull;
</p>
<?php
            $query = "SELECT * FROM blog_post ORDER BY date";
            break;
        case 2: // Ascending alphabetical title
?>
<p class="centered">
    &bull;<a href="?sort=0">Sort by Newest</a>&bull;
    <a href="?sort=3">Sort by Descending Title</a>&bull;
    <a href="?sort=4">Sort by Ascending Post Length</a>&bull;
</p>
<?php
            $query = "SELECT * FROM blog_post ORDER BY title";
            break;
        case 3: // Descending alphabetical title
?>
<p class="centered">
    &bull;<a href="?sort=0">Sort by Newest</a>&bull;
    <a href="?sort=2">Sort by Ascending Title</a>&bull;
    <a href="?sort=4">Sort by Ascending Post Length</a>&bull;
</p>
<?php
            $query = "SELECT * FROM blog_post ORDER BY title DESC";
            break;
        case 4: // Ascending post length
?>
<p class="centered">
    &bull;<a href="?sort=0">Sort by Newest</a>&bull;
    <a href="?sort=2">Sort by Ascending Title</a>&bull;
    <a href="?sort=5">Sort by Descending Post Length</a>&bull;
</p>
<?php
            $query = "SELECT id, title, date, post, LENGTH(post) AS postLength FROM "
                    . "blog_post ORDER BY postLength";
            break;
        case 5: // Descending post length
?>
<p class="centered">
    &bull;<a href="?sort=0">Sort by Newest</a>&bull;
    <a href="?sort=2">Sort by Ascending Title</a>&bull;
    <a href="?sort=4">Sort by Ascending Post Length</a>&bull;
</p>
<?php
            $query = "SELECT id, title, date, post, LENGTH(post) AS postLength FROM "
                    . "blog_post ORDER BY postLength DESC";
            break;
        default: // Default to newest to oldest sort
?>
<p class="centered">
    &bull;<a href="?sort=1">Sort by Oldest</a>&bull;
    <a href="?sort=2">Sort by Ascending Title</a>&bull;
    <a href="?sort=4">Sort by Ascending Post Length</a>&bull;
</p>
<?php
            $query = "SELECT * FROM blog_post ORDER BY date DESC";
            break;
    }
?>

<hr>
