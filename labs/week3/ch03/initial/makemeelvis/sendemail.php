<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Make Me Elvis - Send Email</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>

<?php
    //Initialize variables
    $from = 'elmer@makemeelvis.com';
    $subject = $_POST['subject'];
    $text = $_POST['elvismail'];

    //Connect to database
    $dbc = mysqli_connect('localhost', 'student', 'student', 'elvis_store')
        or die('Error connecting to MySQL server.');

    //Initialize query to retrieve all customers from email_list table
    $query = "SELECT * FROM email_list";
    $result = mysqli_query($dbc, $query)
        or die('Error querying database.');

    //Display email message with subject since mail function doesn't work
    echo "Email contents:<br>";
    echo "from: $from<br>";
    echo "subject: $subject<br>";
    echo "message: $text<br><br>";

    //Send an email to every customer in the email_list table
    while ($row = mysqli_fetch_array($result)){
        $to = $row['email'];
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $msg = "Dear $first_name $last_name,\n$text";
        //Mail function doesn't work
        //mail($to, $subject, $msg, 'From:' . $from);

        //Display confirmation of email being sent
        echo 'Email sent to: ' . $to . '<br />';
    }

    mysqli_close($dbc);
?>

</body>
</html>
