<?php
    require_once("connectVars.php");
    require_once("functions.php");

    // Set default entering mode
    $mode = 'product';
    
    // Retrieve entering product mode if it exists
    if (isset($_GET['mode'])) {
        $mode = trim(strtolower($_GET['mode']));
        
        // Confirm that a valid product type was selected
        if ($mode != 'product' && $mode != 'tool' && $mode != 'electronic') {
            $mode = 'product';
        }
    }
    
    // Retrieve clean form fields if submitted form or set to default empty value
    if (isset($_POST['submit'])) {
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die("Error connecting to database.");

        $mode = mysqli_real_escape_string($dbc, trim($_POST['mode']));
        $title = mysqli_real_escape_string($dbc, trim($_POST['title']));
        $description = mysqli_real_escape_string($dbc, trim($_POST['description']));
        $price = mysqli_real_escape_string($dbc, trim($_POST['price']));
        // Retrieve extra product fields dependent on the product type
        if ($mode == 'tool') {
            $shipper = mysqli_real_escape_string($dbc, trim($_POST['shipper']));
            $weight = mysqli_real_escape_string($dbc, trim($_POST['weight']));
        } else if ($mode == 'electronic') {
            // Store recyclable code value and determine recyclable state
            $recyclableCode = mysqli_real_escape_string($dbc, trim($_POST['recyclable']));
            $recyclable = ($recyclableCode == 1) ? true : false;
        }
        
        mysqli_close($dbc);
    } else {
        $title = "";
        $description = "";
        $price = "";
        $shipper = "";
        $weight = "";
        $recyclable = true;
    }
?>

<html lang="en">
<head>
    <title>Enter the <?php echo ucfirst($mode); ?></title>
</head>
<body>
    <h1>Enter the <?php echo ucfirst($mode); ?></h1>
    <p>Enter the product information below.</p>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] . "?mode=$mode"; ?>">
        <fieldset>
            <legend>New <?php echo ucfirst($mode); ?> Information:</legend>
            <p>Enter a new...</p>
<?php
    // Display clickable links to non-selected enter modes
    echo generateProductSelectionBar($mode);
    
    // Display different form inputs based on the product entry mode
    if ($mode == 'tool') {
        echo generateFormInputs($mode, array($title, $description, $price, $shipper, $weight));
    } else if ($mode == 'electronic') {
        if ($recyclable) {
            echo generateFormInputs($mode, array($title, $description, $price, 'selected', ''));
        } else {
            echo generateFormInputs($mode, array($title, $description, $price, '', 'selected'));
        }
    } else {
        echo generateFormInputs($mode, array($title, $description, $price));
    }
?>
        </fieldset>
    </form>
<?php
    // Attempt to store new product if form has been submitted
    if (isset($_POST['submit'])) {
        // Confirm that a valid product type was provided
        if (isset($_POST['mode']) && !empty($_POST['mode'])) {
            // Confirm that general product info fields were entered
            if (!empty($title) && !empty($description) && !empty($price)) {
                // Confirm that price entered is a number
                if (is_numeric($price)) {
                    // Validate length of title and descriptions provided
                    if (strlen($title) <= 35) {
                        if (strlen($description) <= 100) {
                            $price = (double) $price;
                            
                            // Retrieve extra fields if necessary and create new product
                            if ($mode == 'product') {
                                createAndStoreProduct($mode, array($title, $description, $price));
                                echo "Successfully created a new '$title' product!";
                            } else if ($mode == 'tool') {
                                // Confirm that shipper name is not too long
                                if (strlen($shipper) <= 35) {
                                    // Confirm that a valid weight was provided
                                    if (is_numeric($weight)) {
                                        $weight = (double) $weight;
                                        createAndStoreProduct($mode, array($title, $description, $price, $shipper, $weight));
                                        echo "Successfully created a new '$title' product!";
                                    } else {
                                        echo 'You must enter a valid number for '
                                                . 'the weight.';
                                    }
                                } else {
                                    echo 'Product shippers cannot contain more '
                                            . 'than 35 characters in length.';
                                }
                            } else if ($mode == 'electronic') {
                                createAndStoreProduct($mode, array($title, $description, $price, $recyclableCode));
                                echo "Successfully created a new '$title' product!";
                            } else {
                                echo 'Invalid product type!';
                            }
                        } else {
                            echo 'Product descriptions cannot contain more than'
                                    . ' 100 characters in length.';
                        }
                    } else {
                        echo 'Product titles cannot contain more than 35 '
                                . 'characters in length.';
                    }
                } else {
                    echo 'You must enter a valid number for the price.';
                }
            } else {
                echo 'You must enter all form fields.';
            }
        } else {
            echo 'Invalid product type!';
        }
    }
?>

</body>
</html>
