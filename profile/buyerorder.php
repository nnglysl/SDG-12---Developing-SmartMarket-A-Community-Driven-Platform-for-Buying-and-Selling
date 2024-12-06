<?php
require_once '../db/dbcon.php'; // Update the path as necessary

class BuyerOrder {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function getShipOrder($buyer_id) {
        $sql = "SELECT * FROM orders WHERE order_status = 'to ship' AND buyer_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $buyer_id); // Assuming buyer_id is an integer
        $stmt->execute();
        $result = $stmt->get_result();

        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }

        $stmt->close();
        return $orders;
    }
    public function getReceivedOrder($buyer_id) {
        $sql = "SELECT * FROM orders WHERE order_status = 'to receive' AND buyer_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $buyer_id); // Assuming buyer_id is an integer
        $stmt->execute();
        $result = $stmt->get_result();

        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }

        $stmt->close();
        return $orders;
    }
    public function getDeliveredOrder($buyer_id) {
        $sql = "SELECT * FROM orders WHERE order_status = 'to receive' AND buyer_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $buyer_id); // Assuming buyer_id is an integer
        $stmt->execute();
        $result = $stmt->get_result();

        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }

        $stmt->close();
        return $orders;
    }

    public function countShipOrders($buyer_id) {
        $count = 0;

        $sql = "SELECT COUNT(*) as count FROM orders WHERE order_status = 'to ship' AND buyer_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $buyer_id);
        $stmt->execute();
        $stmt->bind_result($count);
        
        // Fetch the result
        if ($stmt->fetch()) {
            // The count will be assigned to $count
        } else {
            $count = 0; // Default to 0 if no results found
        }
        
        $stmt->close();
        return $count;
    }
    
    public function countReceivedOrders($buyer_id) {
        $count = 0;
        $sql = "SELECT COUNT(*) as count FROM orders WHERE order_status ='to receive' AND buyer_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $buyer_id);
        $stmt->execute();
        $stmt->bind_result($count);
        
        // Fetch the result
        if ($stmt->fetch()) {
            // The count will be assigned to $count
        } else {
            $count = 0; // Default to 0 if no results found
        }
        
        $stmt->close();
        return $count;
    }
    
    public function countDeliveredOrders($buyer_id) {
        $count = 0;
        
        $sql = "SELECT COUNT(*) as count FROM orders WHERE order_status = 'delivered' AND buyer_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $buyer_id);
        $stmt->execute();
        $stmt->bind_result($count);
        
        // Fetch the result
        if ($stmt->fetch()) {
            // The count will be assigned to $count
        } else {
            $count = 0; // Default to 0 if no results found
        }
        
        $stmt->close();
        return $count;
    }

    public function updateOrderStatus($order_id, $status) {
        global $conn; // Ensure you have access to the database connection

        $query = "UPDATE orders SET order_status = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $status, $order_id); // "si" means string and integer

        if ($stmt->execute()) {
            return true; // Successfully updated
        } else {
            return false; // Failed to update
        }
    }

    public function cancelOrder($order_id) {
        return $this->updateOrderStatus($order_id, 'cancel');
    }
}
?>