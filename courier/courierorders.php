<?php
require_once '../db/dbcon.php'; // Include your Database class

class Courier
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getShipOrders()
    {
        return $this->fetchOrdersByStatus('to receive');
    }

    public function getCompleteOrders()
    {
        return $this->fetchOrdersByStatus('delivered');
    }

    public function approveOrder($order_id)
    {
        return $this->updateOrderStatus($order_id, 'delivered');
    }

    private function fetchOrdersByStatus($status)
    {
        $conn = $this->db->getConnection();
        $sql = "SELECT b.buyer_id, CONCAT(b.first_name, ' ', b.last_name) AS buyer_name, o.id AS order_id, o.item_name, o.item_price, o.order_status 
                FROM orders o
                JOIN buyer b ON o.buyer_id = b.buyer_id
                WHERE o.order_status = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $status);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $orders = $this->fetchAll($result);
        $stmt->close();
        return $orders;
    }

    private function updateOrderStatus($order_id, $status)
    {
        $conn = $this->db->getConnection();
        $sql = "UPDATE orders SET order_status = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $status, $order_id);

        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    private function fetchAll($result)
    {
        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
        return $orders;
    }

    public function __destruct()
    {
        $this->db->closeConnection(); // Close the database connection when done
    }
}
?>