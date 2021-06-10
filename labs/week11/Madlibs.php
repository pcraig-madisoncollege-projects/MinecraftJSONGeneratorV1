<?php
    require_once("connectVars.php");
    
    class Madlibs
    {
        private $noun;
        private $verb;
        private $adjective;
        private $adverb;
        private $story;
        
        // Inserts this instance's properties into the database
        public function addStoryToDatabase()
        {
            $dbc = mysqli_connect('localhost', 'student', 'student', 'projects')
                    or die('Error connecting to MySQL server.');
            
            // Retrieve instance variables
            $noun = $this->noun;
            $verb = $this->verb;
            $adjective = $this->adjective;
            $adverb = $this->adverb;
            $story = $this->story;
            
            // Store a new story
            $query = "INSERT INTO madlibs (noun, verb, adverb, adjective, story)
                    VALUES ('$noun', '$verb', '$adverb', '$adjective', '$story');";
                    
            mysqli_query($dbc, $query)
                    or die('Error querying database.');
            
            mysqli_close($dbc);
        }
        
        // Retrieves previously entered stories in order of most recently as a query result
        public function retrieveNewestStories()
        {
            $dbc = mysqli_connect('localhost', 'student', 'student', 'projects')
                    or die('Error connecting to MySQL server.');
            
            // Retrieve all previously entered stories
            $query = "SELECT * FROM madlibs ORDER BY userID DESC;";
            
            $result = mysqli_query($dbc, $query)
                        or die('Error querying database.');
            
            mysqli_close($dbc);
            
            return $result;
        }
        
        // Formats stories query results into an HTML table and returns the HTML
        public function formatStoriesResult($result)
        {
            $htmlOutput = "<table>";
            while ($row = mysqli_fetch_array($result))
            {
                $story = $row['story'];
                $htmlOutput .= "<tr><td>$story</td></tr>";
            }
            $htmlOutput .= "</table>";
            
            return $htmlOutput;
        }
        
        // Accessor Methods

        public function getNoun()
        {
            return $this->noun;
        }
        
        public function getVerb()
        {
            return $this->verb;
        }
        
        public function getAdjective()
        {
            return $this->adjective;
        }
        
        public function getAdverb()
        {
            return $this->adverb;
        }
        
        public function getStory()
        {
            return $this->story;
        }
        
        // Mutator Methods

        public function setNoun($noun)
        {
            $this->noun = $noun;
        }
        
        public function setVerb($verb)
        {
            $this->verb = $verb;
        }
        
        public function setAdjective($adjective)
        {
            $this->adjective = $adjective;
        }
        
        public function setAdverb($adverb)
        {
            $this->adverb = $adverb;
        }
        
        public function setStory($story)
        {
            $this->story = $story;
        }
    }
?>
