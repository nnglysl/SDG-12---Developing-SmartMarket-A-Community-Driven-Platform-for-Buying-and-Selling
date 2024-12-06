<?php

class HomeShop {
    private $conn; 

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

     // get random products
     public function getRandomProducts() {
        $query = "SELECT * FROM products ORDER BY RAND() LIMIT 3";
        $result = mysqli_query($this->conn, $query);

        if ($result) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            error_log("Database query failed: " . mysqli_error($this->conn), 3, "../logs/error.log");
            return [];
        }
    }

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
}
?>