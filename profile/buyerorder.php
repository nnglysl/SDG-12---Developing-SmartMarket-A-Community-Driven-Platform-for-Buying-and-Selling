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
        $sql = "SELECT * FROM orders WHERE order_status = 'ship' AND buyer_id = ?";
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
    public function getDeliveredOrder($buyer_id) {
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

    public function countShipOrders($buyer_id) {
        // Prepare the SQL statement
        $sql = "SELECT COUNT(*) FROM orders WHERE order_status = 'ship' AND buyer_id = ?";
        $stmt = $this->conn->prepare($sql);
    
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->conn->error));
        }
    
        // Bind parameters
        $stmt->bind_param("i", $buyer_id);
        
        // Execute the statement
        if (!$stmt->execute()) {
            die('Execute failed: ' . htmlspecialchars($stmt->error));
        }
    
        // Bind the result to a variable
        $stmt->bind_result($orderCount);
    
        // Fetch the result
        if (!$stmt->fetch()) {
            // If fetch fails, initialize to 0
            $orderCount = 0;
        }
    
        // Close the statement
        $stmt->close();
        
        // Return the count
        return $orderCount;
    }
    
    public function countReceivedOrders($buyer_id) {
        // Prepare the SQL statement
        $sql = "SELECT COUNT(*) FROM orders WHERE order_status = 'received' AND buyer_id = ?";
        $stmt = $this->conn->prepare($sql);
    
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->conn->error));
        }
    
        // Bind parameters
        $stmt->bind_param("i", $buyer_id);
        
        // Execute the statement
        if (!$stmt->execute()) {
            die('Execute failed: ' . htmlspecialchars($stmt->error));
        }
    
        // Bind the result to a variable
        $stmt->bind_result($orderCount);
    
        // Fetch the result
        if (!$stmt->fetch()) {
            // If fetch fails, initialize to 0
            $orderCount = 0;
        }
    
        // Close the statement
        $stmt->close();
        
        // Return the count
        return $orderCount;
    }
    
    public function countDeliveredOrders($buyer_id) {
        // Prepare the SQL statement
        $sql = "SELECT COUNT(*) FROM orders WHERE order_status = 'completed' AND buyer_id = ?";
        $stmt = $this->conn->prepare($sql);
    
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->conn->error));
        }
    
        // Bind parameters
        $stmt->bind_param("i", $buyer_id);
        
        // Execute the statement
        if (!$stmt->execute()) {
            die('Execute failed: ' . htmlspecialchars($stmt->error));
        }
    
        // Bind the result to a variable
        $stmt->bind_result($orderCount);
    
        // Fetch the result
        if (!$stmt->fetch()) {
            // If fetch fails, initialize to 0
            $orderCount = 0;
        }
    
        // Close the statement
        $stmt->close();
        
        // Return the count
        return $orderCount;
    }
}
?>