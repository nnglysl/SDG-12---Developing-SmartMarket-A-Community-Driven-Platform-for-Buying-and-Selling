<?php
require_once '../db/dbcon.php'; // Adjust the path as needed

class OrderManager {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }


    public function createOrder($itemName, $itemPrice, $itemQuantity, $totalAmount, $image) {
        $query = "INSERT INTO orders (item_name, item_price, item_quantity, total_amount, item_picture, order_status) VALUES (?, ?, ?, ?, ?, 'pending')";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sdids", $itemName, $itemPrice, $itemQuantity, $totalAmount, $image);
        return $stmt->execute();
    }

    public function markAsShipped($orderId) {
        $query = "UPDATE orders SET order_status = 'to receive' WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $orderId); 
        return $stmt->execute();
    }

    public function cancelOrder($orderId) {
        // First, retrieve the order details to be stored in cancelledorders
        $query = "SELECT item_name, quantity, item_price, item_picture FROM orders WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $order = $result->fetch_assoc();

            // Insert into cancelledorders
            $cancelQuery = "INSERT INTO cancelledorders (product_name, quantity, price, item_picture) VALUES (?, ?, ?, ?)";
            $cancelStmt = $this->conn->prepare($cancelQuery);
            $reason = "Order canceled by user";
            $cancelStmt->bind_param("ssid", $order['item_name'], $reason, $order['item_quantity'], $order['item_price']);
            $cancelStmt->execute();

            // Delete the order from orders table
            $deleteQuery = "DELETE FROM orders WHERE id = ?";
            $deleteStmt = $this->conn->prepare($deleteQuery);
            $deleteStmt->bind_param("i", $orderId);
            $deleteStmt->execute();

            // Close statements
            $cancelStmt->close();
            $deleteStmt->close();
            return true; 
        }

        return false; 
    }

    public function getOrders() {
        $query = "SELECT * FROM orders ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC); 
    }

    public function getReceivedOrder() {
        $query = "SELECT * FROM orders WHERE order_status = 'to receive' ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC); 
    }

    public function getCanceledOrders() {
        $stmt = $this->conn->prepare("SELECT * FROM orders WHERE order_status = 'cancel' ORDER BY created_at DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getDelieveredOrder() {
        $query = "SELECT * FROM orders WHERE order_status = 'delivered' ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC); 
    }

    public function closeConnection() {
        $this->conn->close();
    }
    
    public function calculateTotalAmount($itemPrice, $itemQuantity) {
        return $itemPrice * $itemQuantity;
    }
}
?>