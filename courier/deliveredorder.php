<?php
require_once 'CourierOrders.php'; 

$orderManager = new Courier();
$orders = $orderManager->getCompleteOrders();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Courier Dashboard - Ship Orders</title>
    <link rel="stylesheet" href="../css/deliveredorder.css">

</head>
<body>
    <div class="sidebar">
        <?php include('couriersidebar.php'); ?>
    </div>
    <div class="main-content">
        <h1>Ship Orders for Courier to Receive</h1>
        <?php if (empty($orders)): ?>
            <p>No ship orders available.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Buyer ID</th>
                        <th>Buyer Name</th>
                        <th>Order ID</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['buyer_id']); ?></td>
                            <td><?php echo htmlspecialchars($order['buyer_name']); ?></td>
                            <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                            <td><?php echo htmlspecialchars($order['item_name']); ?></td>
                            <td><?php echo htmlspecialchars(number_format($order['item_price'], 2)); ?></td>
                            <td><?php echo htmlspecialchars($order['order_status']); ?></td>
                            <td>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
