<?php
class Product {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    // Function to fetch all products from the database
    public function getAllProducts() {
        $query = "SELECT * FROM products";
        
        $result = mysqli_query($this->conn, $query);
        
        if (!$result) {
            die("Query failed: " . mysqli_error($this->conn));
        }

        return $result;
    }
}
?>
