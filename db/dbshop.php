<?php
class Product {
    private $conn;

    // Constructor to initialize the database connection
    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    // Function to fetch all products from the database
    public function getAllProducts() {
        $query = "SELECT * FROM products";
        
        // Execute the query
        $result = mysqli_query($this->conn, $query);
        
        // Check for query execution errors
        if (!$result) {
            die("Query failed: " . mysqli_error($this->conn));
        }

        // Return the result
        return $result;
    }

    public function __destruct() {
        if ($this->conn) {
            mysqli_close($this->conn); 
            $this->conn = null; 
        }
    }
}
?>
