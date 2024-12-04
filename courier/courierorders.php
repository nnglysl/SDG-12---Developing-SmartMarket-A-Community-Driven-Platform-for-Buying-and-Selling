<?php
require_once '../db/dbcon.php'; // Include your Database class

class CourierManager
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getShipOrders($order_id)
    {
        $conn = $this->db->getConnection();
        $sql = "SELECT b.buyer_id, CONCAT(b.first_name, b.last_name) AS buyer_name, o.id, o.item_name, o.order_status 
                FROM orders o
                JOIN buyer b ON o.buyer_id = b.buyer_id
                WHERE o.id = ? AND o.order_status = 'ship'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }

        $stmt->close();
        return $orders;
    }

    public function getDeliveredOrder($order_id)
    {
        $conn = $this->db->getConnection();
        $sql = "SELECT b.buyer_id, CONCAT(b.first_name, b.last_name) AS buyer_name, o.id, o.item_name, o.order_status 
                FROM orders o
                JOIN buyer b ON o.buyer_id = b.buyer_id
                WHERE o.id = ? AND o.order_status = 'to receive'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }

        $stmt->close();
        return $orders;
    }

    public function approveOrder($order_id)
    {
        $conn = $this->db->getConnection();
        $sql = "UPDATE orders SET order_status = 'delivered' WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $order_id);

        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function __destruct()
    {
        $this->db->closeConnection(); // Close the database connection when done
    }
}
?>