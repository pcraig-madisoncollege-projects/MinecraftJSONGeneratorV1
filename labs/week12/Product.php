<?php
    require_once("connectVars.php");

    class Product {
        protected $title;
        protected $description;
        protected $price;
        
        // Stores the product's info into the database.
        public function storeInDatabase() {
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                    or die("Error connecting to database.");
            
            // Add product to database
            $query = "INSERT INTO product_info(title, description, price, shipper"
                    . ", weight, recyclable) VALUES('" . $this->title . "', '"
                    . $this->description . "', '" . $this->price
                    . "', null, null, null)";

            mysqli_query($dbc, $query)
                    or die("Error querying database.");

            mysqli_close($dbc);
        }
        
        // Accessor Methods
        
        public function getTitle() {
            return $this->title;
        }
        
        public function getDescription() {
            return $this->description;
        }
        
        public function getPrice() {
            return $this->price;
        }
        
        // Mutator Methods
        
        public function setTitle($title) {
            $this->title = $title;
        }
        
        public function setDescription($description) {
            $this->description = $description;
        }
        
        public function setPrice($price) {
            $this->price = $price;
        }
    }
?>
