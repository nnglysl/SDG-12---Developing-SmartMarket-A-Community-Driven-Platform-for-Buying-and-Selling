<?php 
require_once 'db.php'; // Include your database class

class Seller {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Method to get seller's product by ID
    public function getProductById($productId, $sellerId) {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ? AND seller_id = ?");
        if ($stmt) {
            $stmt->bind_param("ii", $productId, $sellerId);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        } else {
            echo "Error preparing statement: " . $this->db->connection->error;
            return false;
        }
    }

    // Method to update product
    public function updateProduct($productId, $productName, $price, $imagePath) {
        $stmt = $this->db->prepare("UPDATE products SET product_name = ?, price = ?, image_path = ? WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("sdsi", $productName, $price, $imagePath, $productId);
            return $stmt->execute();
        } else {
            echo "Error preparing statement: " . $this->db->connection->error;
            return false;
        }
    }

    // Method to delete product
    public function deleteProduct($productId, $sellerId) {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ? AND seller_id = ?");
        if ($stmt) {
            $stmt->bind_param("ii", $productId, $sellerId);
            return $stmt->execute();
        } else {
            echo "Error preparing statement: " . $this->db->connection->error;
            return false;
        }
    }
}
?>