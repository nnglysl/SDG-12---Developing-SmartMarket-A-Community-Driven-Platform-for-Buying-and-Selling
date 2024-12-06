<?php
require_once 'dborders.php'; // Include the order manager class

$orderManager = new OrderManager();
$orders = $orderManager->getOrders(); // Fetch all orders

$orderManager->closeConnection();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
    <link rel="stylesheet" href="styles.css">
    <link rel = "stylesheet" href = "../seller/receive.css">
</head>
<body>
<?php include('../sidebar/sidebar.php'); ?>
    <div class="cart-container">
        <div class="cart-title">Order To Receive</div>
        <form method="POST" action="">
            <?php foreach ($orders as $order): ?>
                <div class="cart-item">
                    <input type="checkbox" class="select-check" name="order_ids[]" value="<?php echo htmlspecialchars($order['id']); ?>">
                    <img src="<?php echo htmlspecialchars($order['item_picture']); ?>" alt="Product Image" style="width: 80px; height: 80px; margin-right: 15px; border-radius: 5px;">
                    <div class="item-details">
                        <h4><?php echo htmlspecialchars($order['item_name']); ?></h4>
                        <p>Price: ₱<?php echo htmlspecialchars(number_format($order['item_price'], 2)); ?></p>
                        <div class="item-quantity">
                            <label for="quantity_<?php echo $order['id']; ?>">Quantity:</label>
                            <input type="number" id="quantity_<?php echo $order['id']; ?>" name="quantity[]" value="<?php echo htmlspecialchars($order['item_quantity']); ?>" min="1" readonly>
                        </div>
                    </div>
                    <div class="item-price">₱<?php echo htmlspecialchars(number_format($orderManager->calculateTotalAmount($order['item_price'], $order['item_quantity']), 2)); ?></div>
                </div>
            <?php endforeach; ?>

            <div class="cart-summary">
                <div class="summary-item">
                    <span>Subtotal</span>
                    <span>₱<?php echo htmlspecialchars(number_format(array_sum(array_map(function($order) use ($orderManager) {
                        return $orderManager->calculateTotalAmount($order['item_price'], $order['item_quantity']);
                    }, $orders)), 2)); ?></span>
                </div>
                <div class="summary-item">
                    <span>Shipping Method</span>
                    <span>COD</span>
                </div>
                <div class="summary-item" style="font-weight: bold;">
                    <span>Total</span>
                    <span>₱<?php echo htmlspecialchars(number_format(array_sum(array_map(function($order) use ($orderManager) {
                        return $orderManager->calculateTotalAmount($order['item_price'], $order['item_quantity']);
                    }, $orders)), 2)); ?></span>
                </div>
            </div>
        </form>
    </div>
</body>
</html>