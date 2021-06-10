<?php
    require_once("connectVars.php");
    require_once("Product.php");

    class Electronics extends Product {
        private $recyclable;
        
        // Stores the product's info into the database.
        public function storeInDatabase() {
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                    or die("Error connecting to database.");
            
            // Add product to database
            $query = "INSERT INTO product_info(title, description, price, shipper"
                    . ", weight, recyclable) VALUES('" . $this->title . "', '"
                    . $this->description . "', '" . $this->price . "', null, null, '"
                    . $this->recyclable . "')";

            mysqli_query($dbc, $query)
                    or die("Error querying database.");

            mysqli_close($dbc);
        }
        
        // Accessor Methods
        
        public function getRecyclable() {
            return $this->recyclable;
        }
        
        // Mutator Methods
        
        public function setRecyclable($recyclable) {
            $this->recyclable = $recyclable;
        }
    }
?>
