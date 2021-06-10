<html>
 <head>
  <title>Personalized Hello World</title>
 </head>
 <body>
  <?php
      //Retrieve user input if it exists and ouput message
      if(!empty($_POST['name'])) {
          echo "Greetings, {$_POST['name']}, and welcome.";
      }
  ?>
  <form action="<?php $PHP_SELF; ?>" method="post">
      Enter your name: <input type="text" name="name" />
    <input type="submit" />
  </form>
  <?php echo date("m-d-Y");?>
 </body>
</html>
