<?php
require_once '../db/dbcon.php'; // Adjust the path as needed

class OrderManager {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }


    public function createOrder($itemName, $itemQuantity, $itemPrice, $buyerId, $image) {
        // Prepare the SQL query
        $query = "INSERT INTO orders (item_name, quantity, item_price, order_status, buyer_id, item_picture, created_at) VALUES (?, ?, ?, 'to ship', ?, ?, NOW())";
        $stmt = $this->conn->prepare($query);
    
        // Check if the statement was prepared successfully
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->conn->error));
        }
    
        // Bind parameters
        $stmt->bind_param("sidis", $itemName, $itemQuantity, $itemPrice, $buyerId, $image);
    
        // Execute the statement
        if ($stmt->execute()) {
            // Optionally, you can return the last inserted ID
            $orderId = $stmt->insert_id;
            $stmt->close(); // Close the statement
            return $orderId; // Return the order ID
        } else {
            // Handle execution error
            die('Execute failed: ' . htmlspecialchars($stmt->error));
        }
    }

    public function markAsShipped($orderId) {
        $query = "UPDATE orders SET order_status = 'to receive' WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $orderId); 
        return $stmt->execute();
    }

    public function cancelOrder($orderId) {
        $query = "SELECT * FROM orders WHERE id = ?";
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