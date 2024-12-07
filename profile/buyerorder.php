<?php
require_once '../db/dbcon.php'; // Update the path as necessary

class BuyerOrder {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    // Fetch orders based on status
    private function fetchOrdersByStatus($buyer_id, $status) {
        $sql = "SELECT * FROM orders WHERE order_status = ? AND buyer_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $status, $buyer_id);
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
        $sql = "SELECT * FROM orders WHERE order_status = 'received' AND buyer_id = ?";
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

    public function getDeliveredOrders($buyer_id) {
        return $this->fetchOrdersByStatus($buyer_id, 'delivered');
    }

    // Count orders based on status
    private function countOrdersByStatus($buyer_id, $status) {
        $count = '';
        $sql = "SELECT COUNT(*) as count FROM orders WHERE order_status = ? AND buyer_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $status, $buyer_id);
        $stmt->execute();
        $stmt->bind_result($count);
        
        // Fetch the result
        $stmt->fetch();
        $stmt->close();
        
        return $count ?: 0; // Return 0 if no results found
    }

    // Public methods to count orders by status
    public function countShipOrders($buyer_id) {
        return $this->countOrdersByStatus($buyer_id, 'to ship');
    }

    public function countReceivedOrders($buyer_id) {
        return $this->countOrdersByStatus($buyer_id, 'to receive');
    }

    public function countDeliveredOrders($buyer_id) {
        return $this->countOrdersByStatus($buyer_id, 'delivered');
    }

    // Update order status
    public function updateOrderStatus($order_id, $status) {
        $query = "UPDATE orders SET order_status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $status, $order_id);

        return $stmt->execute(); // Return true on success, false on failure
    }

    // Cancel order
    public function cancelOrder($order_id) {
        return $this->updateOrderStatus($order_id, 'cancel');
    }
}
?>