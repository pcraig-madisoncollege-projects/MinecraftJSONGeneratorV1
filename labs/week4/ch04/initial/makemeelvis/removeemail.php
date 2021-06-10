<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Make Me Elvis - Remove Email</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
    <img src="blankface.jpg" width="161" height="350" alt="" style="float:right" />
    <img name="elvislogo" src="elvislogo.gif" width="229" height="32" border="0" alt="Make Me Elvis" />
    <p>
    Please select the email addresssses to delete
    from the email list and click on Remove.
    </p>

<?php

    $dbc = mysqli_connect('localhost', 'student', 'student', 'elvis_store')
            or die('Error connecting to MySQL server.');

    // Remove all selected emails and display success
    if (isset($_POST['submit']) && isset($_POST['to_delete'])) {
        foreach($_POST['to_delete'] as $delete_id) {
            $query = "DELETE FROM email_list WHERE id = $delete_id;";
            
            mysqli_query($dbc, $query)
                    or die('Error querying database.');
        }
        
        echo 'Customer(s) removed.';
    }
    
    // Get all existing emails from DB
    $query = "SELECT * FROM email_list;";

    $result = mysqli_query($dbc, $query)
            or die('Error querying database.');
        
    mysqli_close($dbc);
    
    // Display form on webpage containing all existing customer info
?>
    <form action="removeemail.php" method="post">
<?php
    // Display all customer info and a checkbox associated with it
    while($row = mysqli_fetch_array($result)) {
        $id = $row['id'];
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $email = $row['email'];
        echo "<input type=\"checkbox\" value=\"$id\" name=\"to_delete[]\">";
        echo "$first_name $last_name $email<br>";
        
    }
?>
        <input type="submit" name="submit" value="Remove">
    </form>

</body>
</html>
