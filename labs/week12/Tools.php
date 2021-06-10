<?php
    require_once("connectVars.php");
    require_once("Product.php");


    class Tools extends Product {
        private $shipper;
        private $weight;
        
        // Stores the product's info into the database.
        public function storeInDatabase() {
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                    or die("Error connecting to database.");
            
            // Add product to database
            $query = "INSERT INTO product_info(title, description, price, shipper"
                    . ", weight, recyclable) VALUES('" . $this->title . "', '"
                    . $this->description . "', '" . $this->price . "', '"
                    . $this->shipper . "', '" . $this->weight . "', null)";

            mysqli_query($dbc, $query)
                    or die("Error querying database.");

            mysqli_close($dbc);
        }
        
        // Accessor Methods
        
        public function getShipper() {
            return $this->shipper;
        }
        
        public function getWeight() {
            return $this->weight;
        }
        
        // Mutator Methods
        
        public function setShipper($shipper) {
            $this->shipper = $shipper;
        }
        
        public function setWeight($weight) {
            $this->weight = $weight;
        }
    }
?>
