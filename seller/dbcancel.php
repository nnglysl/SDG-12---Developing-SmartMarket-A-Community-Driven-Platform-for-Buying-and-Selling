<?php
require_once '../db/dbaddproduct.php';

class Cancel {
    private $conn;

    // Constructor to initialize the database connection
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Method to create a new order
    public function createOrder($product_name, $reason, $quantity, $price) {
        // Prepare and bind
        $stmt = $this->conn->prepare("INSERT INTO cancelledorders (product_name, reason, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssid", $product_name, $reason, $quantity, $price);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Cancel order recorded successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }

    // Method to close the database connection
    public function closeConnection() {
        $this->conn->close();
    }
}
?>