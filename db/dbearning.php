<?php
require_once __DIR__ . '/../dbconnection/dbcon.php'; // Adjust the path as necessary

class Earnings {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getEarningsData() {
        $sql = "SELECT date, amount, status FROM earnings";
        $result = $this->conn->query($sql);

        $earningsData = [];
        $totalEarnings = 0;
        $pendingPayouts = 0;

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $earningsData[] = $row;
                $totalEarnings += $row['amount'];
                if ($row['status'] === 'Pending') {
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