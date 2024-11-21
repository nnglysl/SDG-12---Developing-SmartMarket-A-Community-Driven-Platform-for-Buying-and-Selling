<?php
require_once __DIR__ . '/../dbconnection/dbcon.php'; 

class ProductManager {
    private $conn;

    public function __construct() {
        $connection = new Database();
        $this->conn = $connection->getConnection();
    }

    public function addProduct($productName, $price, $description, $image) {
        $uploadDir = 'uploads/';
        $imagePath = $uploadDir . basename($image['name']);

        // Ensure the uploads directory exists
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (move_uploaded_file($image['tmp_name'], $imagePath)) {
            $query = "INSERT INTO products (product_name, price, description, image_path) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);

            if ($stmt) {
                $stmt->bind_param("sdss", $productName, $price, $description, $imagePath);
                if ($stmt->execute()) {
                    return "Product added successfully.";
                } else {
                    return "Database error: " . $stmt->error;
                }
                $stmt->close();
            } else {
                return "Error preparing query: " . $this->conn->error;
            }
        } else {
            return "Failed to upload the image.";
        }
    }
}

?>