<?php
require_once 'CourierOrders.php'; 

$orderManager = new Courier();
$orders = $orderManager->getShipOrders(); 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $order_id = intval($_POST['order_id']); 
    if ($orderManager->approveOrder($order_id)){
        echo "<p style='color: green;'>Order #$order_id has been approved successfully.</p>";
    } else {
        echo "<p style='color: red;'>Failed to approve order #$order_id. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Courier Dashboard - Ship Orders</title>
    <link rel="stylesheet" href="styles.css">

    <style>
        /* General body styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex; /* Use flexbox for layout */
        }

        /* Sidebar styles */
        .sidebar {
            width: 250px; /* Fixed width for sidebar */
            background-color: #007BFF; /* Sidebar background color */
            padding: 15px;
            color: white;
            height: 100vh; /* Full height */
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1); /* Optional shadow for sidebar */
        }

        /* Main content styles */
        .main-content {
            flex: 1; /* Take the remaining space */
            padding: 20px;
            max-width: 900px; /* Maximum width for the main content */
            margin: 40px auto; /* Center the content with auto margins */
        }

        /* Header styles */
        h1 {
            text-align: center;
            color: #333;
        }

        /* Table styles */
        table {
            width: 100%; /* Full width */
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        /* Header cell styles */
        th {
            background-color: #007BFF;
            color: white;
        }

        /* Row hover effect */
        tr:hover {
            background-color: #f1f1f1;
        }

        /* Button styles */
        button {
            background-color: #28a745; /* Green */
            color: white;
            border: none;
            padding: 10px 15px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #218838; /* Darker green */
        }

        /* Message styles */
        p {
            text-align: center;
            color: #666;
        }
    </style>
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
                        <th>Action</th>
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
                                <form action="" method="POST">
                                    <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                    <button type="submit">Approve Delivery</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>