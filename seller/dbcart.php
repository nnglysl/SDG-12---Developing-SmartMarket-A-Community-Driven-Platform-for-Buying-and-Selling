<?php
require_once __DIR__ .'../../db/dbcon.php';

class ShoppingCart {
    private $db;
    private $items = [];

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }
    
    public function addItem($name, $price, $quantity, $size, $image) {
        $stmt = $this->db->prepare("INSERT INTO cart (product_name, price, quantity, size, product_picture) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sdiss", $name, $price, $quantity, $size, $image);
        $stmt->execute();
        $stmt->close();
    }

    public function updateItem($id, $quantity) {
        $stmt = $this->db->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
        $stmt->bind_param("ii", $quantity, $id);
        $stmt->execute();
        $stmt->close();
    }

    public function deleteItem($id) {
        $stmt = $this->db->prepare("DELETE FROM cart WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

    public function getCart() {
        $result = $this->db->query("SELECT * FROM cart");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function calculateTotal() {
        $total = 0;
        $result = $this->db->query("SELECT price, quantity FROM cart");
        while ($item = $result->fetch_assoc()) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    public function clearCart() {
        $stmt = $this->db->prepare("DELETE FROM cart");
        $stmt->execute();
        $stmt->close();
    }

    public function __destruct() {
        $this->db->close();
    }
}
?>