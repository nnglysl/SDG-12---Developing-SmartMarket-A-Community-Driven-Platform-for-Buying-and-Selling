<?php
require_once __DIR__ . '/dbcon.php'; // Adjust the path as necessary

class Earnings {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getEarningsData() {
        // Fetch total earnings from orders table where order_status is 'delivered'
        $sqlDelivered = "SELECT created_at, item_price, order_status FROM orders WHERE order_status = 'delivered'";
        $resultDelivered = $this->conn->query($sqlDelivered);

        $earningsData = [];
        $totalEarnings = 0;
        $pendingPayouts = 0;

        if ($resultDelivered->num_rows > 0) {
            while ($row = $resultDelivered->fetch_assoc()) {
                $earningsData[] = $row;
                $totalEarnings += $row['amount'];
                if ($row['status'] === 'to ship') {
                    $pendingPayouts += $row['amount'];
                }
            }
        }

        return [
            'earningsData' => $earningsData,
            'totalEarnings' => $totalEarnings,
            'pendingPayouts' => $pendingPayouts,
        ];
    }
}
?>