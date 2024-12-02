<?php
require_once '../db/dbcon.php';

class Seller {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Method to get seller information
    public function getSellerInfo($sellerId) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT shop_name, email FROM seller WHERE seller_id = ?");
        $stmt->bind_param("i", $sellerId);
        $stmt->execute();
        $result = $stmt->get_result();
        $sellerInfo = $result->fetch_assoc();
        $stmt->close();
        return $sellerInfo;
    }

    // Method to get seller products
    public function getSellerProducts($sellerId) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT product_id, product_name, price, image_path FROM products WHERE seller_id = ?");
        $stmt->bind_param("i", $sellerId);
        $stmt->execute();
        $result = $stmt->get_result();
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        $stmt->close();
        return $products;
    }

    public function __destruct() {
        $this->db->closeConnection();
    }
}
?>