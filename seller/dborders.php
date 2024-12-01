<?php
require_once '../db/dbcon.php'; // Adjust the path as needed

class OrderManager {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function markAsShipped($orderId) {
        $query = "UPDATE orders SET order_status = 'ship' WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $orderId); // "i" indicates the type is integer
        return $stmt->execute();
    }

    public function cancelOrder($orderId) {
        $query = "UPDATE orders SET order_status = 'cancel' WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $orderId); // "i" indicates the type is integer
        return $stmt->execute();
    }

    public function getOrders() {
        $query = "SELECT * FROM orders ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC); // Fetch all results as an associative array
    }

    public function getCanceledOrders() {
        $stmt = $this->conn->query("SELECT * FROM orders WHERE order_status = 'cancel' ORDER BY created_at DESC");
        return $stmt->fetch_all(MYSQLI_ASSOC);
    }

    public function closeConnection() {
        $this->conn->close();
    }
}
?>