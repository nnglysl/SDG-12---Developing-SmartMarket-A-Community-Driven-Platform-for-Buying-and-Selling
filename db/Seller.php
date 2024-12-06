<?php
require_once __DIR__ . '/dbcon.php'; // Adjust the path as necessary

class DatabaseConnection {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getConnection() {
        return $this->conn;
    }

    public function close() {
        $this->conn->close();
    }
}

class Earnings {
    private $conn;

    public function __construct(DatabaseConnection $dbConnection) {
        $this->conn = $dbConnection->getConnection();
    }

    public function getEarningsData() {
        $sqlDelivered = "SELECT created_at, item_price, order_status FROM orders WHERE order_status = 'delivered'";
        $resultDelivered = $this->conn->query($sqlDelivered);

        $earningsData = [];
        $totalEarnings = 0;
        $pendingPayouts = 0;

        if ($resultDelivered->num_rows > 0) {
            while ($row = $resultDelivered->fetch_assoc()) {
                $earningsData[] = $row;
                $totalEarnings += $row['item_price'];
                if ($row['order_status'] === 'to ship') {
                    $pendingPayouts += $row['item_price'];
                }
            }
        }

        return [
            'earningsData' => $earningsData,
            'totalEarnings' => $totalEarnings,
            'pendingPayouts' => $pendingPayouts,
        ];
    }

    public function getPendingData() {
        $sqlPending = "SELECT created_at, item_price, order_status FROM orders WHERE order_status = 'to ship' OR order_status = 'to receive'";
        $resultPending = $this->conn->query($sqlPending);

        $pendingData = [];
        $totalPending = 0;

        if ($resultPending->num_rows > 0) {
            while ($row = $resultPending->fetch_assoc()) {
                $pendingData[] = $row;
                $totalPending += $row['item_price'];
            }
        }

        return [
            'pendingData' => $pendingData,
            'totalPending' => $totalPending,
        ];
    }
}

class Seller {
    private $conn;

    public function __construct(DatabaseConnection $dbConnection) {
        $this->conn = $dbConnection->getConnection();
    }

    public function getSellerInfo($sellerId) {
        $stmt = $this->conn->prepare("SELECT shop_name, email FROM seller WHERE seller_id = ?");
        $stmt->bind_param("i", $sellerId);
        $stmt->execute();
        $result = $stmt->get_result();
        $sellerInfo = $result->fetch_assoc();
        $stmt->close();
        return $sellerInfo;
    }

    public function getSellerProducts($sellerId) {
        $stmt = $this->conn->prepare("SELECT product_id, product_name, price, image_path FROM products WHERE seller_id = ?");
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

    public function getProductById($productId, $sellerId) {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE id = ? AND seller_id = ?");
        if ($stmt) {
            $stmt->bind_param("ii", $productId, $sellerId);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        } else {
            echo "Error preparing statement: " . $this->conn->connection->error;
            return false;
        }
    }

    public function updateProduct($productId, $productName, $price, $imagePath) {
        $stmt = $this->conn->prepare("UPDATE products SET product_name = ?, price = ?, image_path = ? WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("sdsi", $productName, $price, $imagePath, $productId);
            return $stmt->execute();
        } else {
            echo "Error preparing statement: " . $this->conn->connection->error;
            return false;
        }
    }

    public function deleteProduct($productId, $sellerId) {
        $stmt = $this->conn->prepare("DELETE FROM products WHERE id = ? AND seller_id = ?");
        if ($stmt) {
            $stmt->bind_param("ii", $productId, $sellerId);
            return $stmt->execute();
        } else {
            echo "Error preparing statement: " . $this->conn->connection->error;
            return false;
        }
    }
}

class OrderManager {
    private $conn;

    public function __construct(DatabaseConnection $dbConnection) {
        $this->conn = $dbConnection->getConnection();
    }

    public function createOrder($itemName, $itemQuantity, $itemPrice, $buyerId, $image) {
        $query = "INSERT INTO orders (item_name, quantity, item_price, order_status, buyer_id, item_picture, created_at) VALUES (?, ?, ?, 'to ship', ?, ?, NOW())";
        $stmt = $this->conn->prepare($query);
    
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->conn->error));
        }
    
        $stmt->bind_param("sidis", $itemName, $itemQuantity, $itemPrice, $buyerId, $image);
    
        if ($stmt->execute()) {
            $orderId = $stmt->insert_id;
            $stmt->close();
            return $orderId;
        } else {
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

            $cancelQuery = "INSERT INTO cancelledorders (product_name, quantity, price, item_picture) VALUES (?, ?, ?, ?)";
            $cancelStmt = $this->conn->prepare($cancelQuery);
            $reason = "Order canceled by user";
            $cancelStmt->bind_param("ssid", $order['item_name'], $reason, $order['quantity'], $order['item_price']);
            $cancelStmt->execute();

            $deleteQuery = "DELETE FROM orders WHERE id = ?";
            $deleteStmt = $this->conn->prepare($deleteQuery);
            $deleteStmt->bind_param("i", $orderId);
            $deleteStmt->execute();

            $cancelStmt->close();
            $deleteStmt->close();
            return true; 
        }

        return false; 
    }


    public function getShipOrder() {
        $query = "SELECT * FROM orders WHERE order_status = 'to ship' ORDER BY created_at DESC";
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

    public function getDeliveredOrder() {
        $query = "SELECT * FROM orders WHERE order_status = 'delivered' ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC); 
    }

    public function closeConnection() {
        $this->conn->close();
    }
    
}

class Market {
    private $databaseConnection;
    private $marketplace;
    private $seller;
    private $orderManager;

    public function __construct() {
        $this->databaseConnection = new DatabaseConnection();
        $this->marketplace = new Earnings($this->databaseConnection);
        $this->seller = new Seller($this->databaseConnection);
        $this->orderManager = new OrderManager($this->databaseConnection);
    }

    public function getEarnings() {
        return $this->marketplace->getEarningsData();
    }

    public function getEarningsPending() {
        return $this->marketplace->getPendingData();
    }

    public function updateProduct($productId, $productName, $price, $imagePath) {
        return $this->seller->updateProduct($productId, $productName, $price, $imagePath);
    }

    public function deleteProduct($productId, $sellerId) {
        return $this->seller->deleteProduct($productId, $sellerId);
    }
    
    public function getSellerInfo($sellerId) {
        return $this->seller->getSellerInfo($sellerId);
    }

    public function getProductId($productId, $sellerId) {
        return $this->seller->getProductById($productId, $sellerId);
    }

    public function getSellerProducts($sellerId) {
        return $this->seller->getSellerProducts($sellerId);
    }

    public function createOrder($itemName, $itemQuantity, $itemPrice, $buyerId, $image) {
        return $this->orderManager->createOrder($itemName, $itemQuantity, $itemPrice, $buyerId, $image);
    }

    public function markOrderAsShipped($orderId) {
        return $this->orderManager->markAsShipped($orderId);
    }

    public function getShip() {
        return $this->orderManager->getShipOrder();
    }

    public function getReceive() {
        return $this->orderManager->getReceivedOrder();
    }

    public function getDelivered() {
        return $this->orderManager->getDeliveredOrder();
    }

    public function getCanceledOrders() {
        return $this->orderManager->getCanceledOrders();
    }

    public function cancelOrder($orderId) {
        return $this->orderManager->cancelOrder($orderId);
    }

    public function close() {
        $this->databaseConnection->close();
    }

    public function calculateTotalAmount($itemPrice, $itemQuantity) {
        return $itemPrice * $itemQuantity;
    }

}
?>