<?php
    require_once("Product.php");
    require_once("Tools.php");
    require_once("Electronics.php");
    /*
    * This file stores all functions used in the add product lab page
    */

    // Creates a new product based off of the type and provided instance variable
    // values and stores it into the database.
    function createAndStoreProduct($mode, $values) {
        // Validate parameter types before continuing
        if (gettype($mode) == 'string' && gettype($values) == 'array') {
            $mode = strtolower(trim($mode));
            
            // Retrieve default product fields
            if (count($values) >= 3) {
                $title = trim($values[0]);
                $description = trim($values[1]);
                $price = trim($values[2]);
            } else {
                exit('Not enough input elements provided to use '
                        . 'createAndStoreProduct function.');
            }
            
            // Validate number of input values provided for each product type
            switch ($mode) {
                case 'tool':
                    if (count($values) != 5) {
                        exit("Invalid number of inputs provided for "
                                . "createAndStoreProduct function input values.");
                    } else {
                        $shipper = trim($values[3]);
                        $weight = trim($values[4]);
                    }
                    break;
                case 'electronic':
                    if (count($values) != 4) {
                        exit("Invalid number of inputs provided for "
                                . "createAndStoreProduct function input values.");
                    } else {
                        $recyclable = trim($values[3]);
                    }
                    break;
            }
            
            // Create the new product
            if ($mode == 'product') {
                $product = new Product();
                $product->setTitle($title);
                $product->setDescription($description);
                $product->setPrice($price);
            } else if ($mode == 'tool') {
                $product = new Tools();
                $product->setTitle($title);
                $product->setDescription($description);
                $product->setPrice($price);
                $product->setShipper($shipper);
                $product->setWeight($weight);
            } else if ($mode == 'electronic') {
                $product = new Electronics();
                $product->setTitle($title);
                $product->setDescription($description);
                $product->setPrice($price);
                $product->setRecyclable($recyclable);
            } else {
                exit('Invalid mode provided for createAndStoreProduct function.');
            }
            
            // Store the new product into the database.
            $product->storeInDatabase();
        } else {
            exit('Invalid parameter types provided for createAndStoreProduct function.');
        }
    }

    // Generates product mode selection bar
    function generateProductSelectionBar($mode) {
        // Validate parameter type for mode before continuing
        if (gettype($mode) == 'string') {
            $mode = strtolower(trim($mode));
            $output = '';
            
            // Assign default mode of product if invalid mode is given
            if ($mode != 'product' && $mode != 'tool' && $mode != 'electronic') {
                $mode = 'product';
            }
            
            // Add respective HTML link or text based on current mode
            if ($mode == 'product') {
                $output .= '<strong>Product</strong> ';
            } else {
                $output .= '<a href="addProduct.php?mode=product">Product</a> ';
            }
            if ($mode == 'tool') {
                $output .= '<strong>Tool</strong> ';
            } else {
                $output .= '<a href="addProduct.php?mode=tool">Tool</a> ';
            }
            if ($mode == 'electronic') {
                $output .= '<strong>Electronic</strong>';
            } else {
                $output .= '<a href="addProduct.php?mode=electronic">Electronic</a>';
            }
            
            return $output;
        } else {
            exit('Invalid parameter type for generateProductSelectionBar function.');
        }
    }

    // Generates HTML form inputs with a specified product mode and a string array
    // of default/sticky values for that product entry mode.
    function generateFormInputs($mode, $values) {
        // Validate parameter types before continuing
        if (gettype($mode) == 'string' && gettype($values) == 'array') {
            $mode = strtolower(trim($mode));
            
            // Retrieve default product fields
            if (count($values) >= 3) {
                $title = trim($values[0]);
                $description = trim($values[1]);
                $price = trim($values[2]);
            } else {
                exit('Not enough input elements provided to use generateFormInputs function.');
            }
            
            // Validate number of input values provided for each product type
            switch ($mode) {
                case 'tool':
                    if (count($values) != 5) {
                        exit("Invalid number of inputs provided for "
                                . "generateFormInputs function input values.");
                    } else {
                        $shipper = trim($values[3]);
                        $weight = trim($values[4]);
                    }
                    break;
                case 'electronic':
                    if (count($values) != 5) {
                        exit("Invalid number of inputs provided for "
                                . "generateFormInputs function input values.");
                    } else {
                        $recyclable = trim($values[3]);
                        $notRecyclable = trim($values[4]);
                    }
                    break;
            }
            
            // Generate generic product inputs
            $output = "<br><br><label for=\"title\">Title </label>"
                    . "<input type=\"text\" id=\"title\" name=\"title\" value=\"$title\">"
                    . "<br><label for=\"description\">Description </label>"
                    . "<input type=\"text\" id=\"description\" name=\"description\""
                    . "value=\"$description\"><br><label for=\"price\">Price </label>"
                    . "<input type=\"text\" id=\"price\" name=\"price\" "
                    . "value=\"$price\"><br>";
            
            // Append specific product inputs
            if ($mode == 'tool') {
                $output .= "<label for=\"shipper\">Shipper </label><input "
                        . "type=\"text\" id=\"shipper\" name=\"shipper\" "
                        . "value=\"$shipper\"><br><label for=\"weight\">Weight </label>"
                        . "<input type=\"text\" id=\"weight\" name=\"weight\" "
                        . "value=\"$weight\">lbs<br>";
            } else if ($mode == 'electronic') {
                $output .= "<label for=\"recyclable\">Recyclable </label>"
                        . "<select id=\"recyclable\" name=\"recyclable\">"
                        . "<option value=\"1\" $recyclable>Yes</option>"
                        . "<option value=\"0\" $notRecyclable>No"
                        . "</option></select><br>";
            }
            
            // Generate finishing input values
            $output .= "<br><br><input type=\"hidden\" name=\"mode\" "
                    . "value=\"$mode\"><input type=\"submit\" name=\"submit\">";
            
            return $output;
        } else {
            exit('Error: generateFormInputs function requires a string and array '
                    . 'passed in as parameters.');
        }
    }
?>
