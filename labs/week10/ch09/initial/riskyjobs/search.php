<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Risky Jobs - Search</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<img src="riskyjobs_title.gif" alt="Risky Jobs">
<img src="riskyjobs_fireman.jpg" alt="Risky Jobs" style="float:right">
<h3>Risky Jobs - Search Results</h3>

<?php
    // Function declarations and definitions first (for organization's sake)

    // Generates formatted HTML table header links to enable sorting table content
    function generate_sort_links($user_search, $sort) {
        $sort_links = '';

        switch ($sort) {
            // Sorted by ascending job title
            case 1:
                $sort_links .= '<td><a href="' . $_SERVER['PHP_SELF'] .  '?usersearch='
                        . $user_search . '&sort=2">Job Title</a></td><td>Description</td>';
                $sort_links .= '<td><a href="' . $_SERVER['PHP_SELF'] .  '?usersearch='
                        . $user_search . '&sort=3">State</a></td>';
                $sort_links .= '<td><a href="' . $_SERVER['PHP_SELF'] .  '?usersearch='
                        . $user_search . '&sort=5">Date Posted</a></td>';
                break;
            // Sorted by ascending state
            case 3:
                $sort_links .= '<td><a href="' . $_SERVER['PHP_SELF'] .  '?usersearch='
                        . $user_search . '&sort=1">Job Title</a></td><td>Description</td>';
                $sort_links .= '<td><a href="' . $_SERVER['PHP_SELF'] .  '?usersearch='
                        . $user_search . '&sort=4">State</a></td>';
                $sort_links .= '<td><a href="' . $_SERVER['PHP_SELF'] .  '?usersearch='
                        . $user_search . '&sort=5">Date Posted</a></td>';
                break;
            // Sorted by ascending date posted
            case 5:
                $sort_links .= '<td><a href="' . $_SERVER['PHP_SELF'] .  '?usersearch='
                        . $user_search . '&sort=1">Job Title</a></td><td>Description</td>';
                $sort_links .= '<td><a href="' . $_SERVER['PHP_SELF'] .  '?usersearch='
                        . $user_search . '&sort=3">State</a></td>';
                $sort_links .= '<td><a href="' . $_SERVER['PHP_SELF'] .  '?usersearch='
                        . $user_search . '&sort=6">Date Posted</a></td>';
                break;
            // Default sorting or some descending sorting selected
            default:
                $sort_links .= '<td><a href="' . $_SERVER['PHP_SELF'] .  '?usersearch='
                        . $user_search . '&sort=1">Job Title</a></td><td>Description</td>';
                $sort_links .= '<td><a href="' . $_SERVER['PHP_SELF'] .  '?usersearch='
                        . $user_search . '&sort=3">State</a></td>';
                $sort_links .= '<td><a href="' . $_SERVER['PHP_SELF'] .  '?usersearch='
                        . $user_search . '&sort=5">Date Posted</a></td>';
                break;
        }

        return $sort_links;
    }

    // Creates a query based off of what the user searches and what sort option
    function build_query($user_search, $sort) {
        // Generate search query
        $query = "SELECT * FROM riskyjobs";
        $where_list = array();

        // Replace commas in entered search phrase
        $user_search = str_replace(',', ' ', $user_search);

        $search_words = explode(' ', $user_search);
        $final_search_words = array();

        // Confirm that search words were entered
        if (count($search_words) > 0) {
            foreach ($search_words as $word) {
                if (!empty($word)) {
                    $final_search_words[] = $word;
                }
            }
        }

        // Generate where clause of search query if search words exist
        if (count($final_search_words) > 0) {
            foreach ($final_search_words as $word) {
                $where_list[] = "description LIKE '%$word%'";
            }
        }

        // Add OR keywords in-between where list
        $where_clause = implode(' OR ', $where_list);

        // Combine where clause with rest of search query
        if (!empty($where_clause)) {
            $query .= " WHERE $where_clause";
        }

        // Append sorting to query based on sort mode
        switch ($sort) {
            // Ascending job title
            case 1:
                $query .= ' ORDER BY title';
                break;
            // Descending job title
            case 2:
                $query .= ' ORDER BY title DESC';
                break;
            // Ascending state
            case 3:
                $query .= ' ORDER BY state';
                break;
            // Descending state
            case 4:
                $query .= ' ORDER BY state DESC';
                break;
            // Ascending date posted
            case 5:
                $query .= ' ORDER BY date_posted';
                break;
            // Descending date posted
            case 6:
                $query .= ' ORDER BY date_posted DESC';
                break;
            // No sorting mode selected
            default:
                break;
        }

        return $query;
    }

    // Generates links for navigation between search results pages
    function generate_page_links($user_search, $sort, $cur_page, $num_pages) {
        $page_links = '<p>';

        // Generate "previous page" link if page is not the first page
        if ($cur_page > 1) {
            // Generate back arrow as an HTML link
            $page_links .= '<a href="' . $_SERVER['PHP_SELF']
                    . '?usersearch=' . $user_search . '&sort=' . $sort
                    . '&page=' . ($cur_page - 1) . '"><-</a> ';
        } else {
            // Generate back arrow as a non-HTML link
            $page_links .= '<- ';
        }

        // Generate page links for each individual page
        for ($index = 1; $index <= $num_pages; $index++) {
            // Generate clickable link if page is not current page
            if ($index == $cur_page) {
                $page_links .= ' ' . $index;
            } else {
                $page_links .= '<a href="' . $_SERVER['PHP_SELF']
                        . '?usersearch=' . $user_search . '&sort=' . $sort
                        . '&page=' . $index . '"> ' . $index . '</a> ';
            }
        }

        // Generate clickable link if current page is not the last page
        if ($cur_page < $num_pages) {
            // Generate back arrow as an HTML link
            $page_links .= '<a href="' . $_SERVER['PHP_SELF']
                    . '?usersearch=' . $user_search . '&sort=' . $sort
                    . '&page=' . ($cur_page + 1) . '"> -></a> ';
        } else {
            // Generate back arrow as a non-HTML link
            $page_links .= ' ->';
        }

        $page_links .= '</p>';

        return $page_links;
    }

    // End of function declarations

    // Grab the sort setting and search keywords from the URL using GET
    $sort = '';
    $user_search = $_GET['usersearch'];
    // Retrieve sort type if provided
    if (isset($_GET['sort'])) {
        $sort = $_GET['sort'];
    }

    // Validate and retrieve current page or set to default if no page is set
    if (isset($_GET['page']) && $_GET['page'] > 0) {
        $cur_page = $_GET['page'];
    } else {
        $cur_page = 1;
    }

    $results_per_page = 5;
    // Calculate first search result to start limiting from
    $skip = ($cur_page - 1) * $results_per_page;

    // Start generating the table of results
    echo '<table border="0" cellpadding="2">';

    // Generate the search result headings
    echo '<tr class="heading">';
    $sort_links = generate_sort_links($user_search, $sort);
    echo $sort_links;
    echo '</tr>';

    // Connect to the database
    require_once('connectvars.php');
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die("Error connecting to database.");

    // Generate search query from user search
    $query = build_query($user_search, $sort);
    $result = mysqli_query($dbc, $query)
            or die("Error querying database.");

    $total_results = mysqli_num_rows($result);
    // Calculate the minimum number of pages needed
    $num_pages = ceil($total_results / $results_per_page);

    // Validate that current page is not beyond number of pages
    if ($cur_page > $num_pages) {
        // Redirect to first page if invalid page number
        $pageURL = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']
                . "?usersearch=$user_search";
        header('Location: ' . $pageURL);
    }

    // Query database again to limit search results on each page
    $query .= " LIMIT $skip, $results_per_page;";
    $result = mysqli_query($dbc, $query)
            or die("Error querying database.");

    // Display results of search as formatted HTML table
    while ($row = mysqli_fetch_array($result)) {
        echo '<tr class="results">';
        echo '<td valign="top" width="20%">' . $row['title'] . '</td>';
        echo '<td valign="top" width="50%">' . substr($row['description'], 0, 100)
                . '...</td>';
        echo '<td valign="top" width="10%">' . $row['state'] . '</td>';
        echo '<td valign="top" width="20%">' . substr($row['date_posted'], 0, 10)
                . '</td>';
        echo '</tr>';
    }
    echo '</table>';

    mysqli_close($dbc);

    if ($num_pages > 1) {
        echo generate_page_links($user_search, $sort, $cur_page, $num_pages);
    }
?>

</body>
</html>
