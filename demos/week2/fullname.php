<html>
<head>
  <title>Full Name</title>
</head>
<body>
  <h2>Full Name</h2>
  
<?php
    //Retrieve input values
    $first_name = $_POST['firstname'];
    $last_name  = $_POST['lastname'];
    
    //Open a connection to database
    $dbc = mysqli_connect('localhost', 'student', 'student', 'pjcraig')
        or die('Error connecting to MySQL server.');
      
    $query = "INSERT INTO fullname (first_name, last_name) " . 
           "VALUES ('$first_name', '$last_name')";
      
    //Add user input values into database
    $result = mysqli_query($dbc, $query)
        or die('Error querying database.');
      
    mysqli_close($dbc);
    
    //Display confirmation message of entered data
    echo "Hi " . $first_name . " " . $last_name . ". Thanks for submitting the form!";
?>
</body>
</html>
