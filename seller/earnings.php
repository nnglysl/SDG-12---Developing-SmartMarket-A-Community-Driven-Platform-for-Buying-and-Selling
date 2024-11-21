<?php
require_once 'dbearning.php'; // Adjust the path as needed

// Create an instance of the Earnings class
$earnings = new Earnings();
$data = $earnings->getEarningsData();

// Extract data from the returned array
$earningsData = $data['earningsData'];
$totalEarnings = $data['totalEarnings'];
$pendingPayouts = $data['pendingPayouts'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Earnings</title>
    <link rel="stylesheet" href="earning.css">
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</head>
<body>
    <div class="earning-container">
        <h1>Earnings Overview</h1>
        <div class="earning-summary">
            <div class="summary-item">
                <h2>Total Earnings</h2>
                <p>Php <?php echo number_format($totalEarnings, 2); ?></p>
            </div>
            <div class="summary-item">
                <h2>Pending Payouts</h2>
                <p>Php <?php echo number_format($pendingPayouts, 2); ?></p>
            </div>
        </div>
        <table class="earning-table" id="earningsTable">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($earningsData as $earning): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($earning['date']); ?></td>
                        <td><?php echo htmlspecialchars(number_format($earning['amount'], 2)); ?></td>
                        <td><?php echo htmlspecialchars($earning['status']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $('#earningsTable').DataTable(); // Initialize DataTable
        });
    </script>
</body>
</html>