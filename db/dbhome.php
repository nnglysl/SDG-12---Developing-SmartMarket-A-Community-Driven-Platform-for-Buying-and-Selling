<?php

class HomeShop {
    private $conn; 

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

<<<<<<< HEAD
     // get random products
     public function getRandomProducts() {
=======
    public function getRandomProducts()
    {
>>>>>>> 8bf14460a71664f616a7904fa7502aa9173cb1a3
        $query = "SELECT * FROM products ORDER BY RAND() LIMIT 3";
        $result = mysqli_query($this->conn, $query);

        if ($result) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            error_log("Database query failed: " . mysqli_error($this->conn), 3, "../logs/error.log");
            return [];
        }
    }

<<<<<<< HEAD
    // fetch all products with their corresponding shop names
    public function getAllProductsWithShopNames() {
        $query = "SELECT p.product_name, p.price, p.image_path, p.description, s.shop_name 
                  FROM products p
                  JOIN seller s ON p.seller_id = s.seller_id";
        $result = mysqli_query($this->conn, $query);

        if ($result) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            error_log("Database query failed: " . mysqli_error($this->conn), 3, "../logs/error.log");
            return [];
        }
    }
=======
    public function __destruct()
    {
        if ($this->conn) {
            mysqli_close($this->conn); 
            $this->conn = null; 
        }
    } 
>>>>>>> 8bf14460a71664f616a7904fa7502aa9173cb1a3
}

?>
