<?php
require_once 'dborders.php'; // Include the order manager class

$orderManager = new OrderManager();
$orders = $orderManager->getOrders(); // Fetch all orders

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    $orderIds = $_POST['order_ids'] ?? []; // Get selected order IDs

    // Process the action
    if (!empty($orderIds)) {
        if ($_POST['action'] == 'ship') {
            foreach ($orderIds as $orderId) {
                $orderManager->markAsShipped($orderId); // Mark each order as shipped
            }
        } elseif ($_POST['action'] == 'cancel') {
            foreach ($orderIds as $orderId) {
                $orderManager->cancelOrder($orderId); // Cancel each order
            }
        }
    }

    // Redirect to the same page to avoid form resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$orderManager->closeConnection();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
    <link rel="stylesheet" href="styles.css">
    <style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #ffe6f2; /* Super light pink background */
    color: #000; /* Black text color */
}

.cart-container {
    max-width: 800px;
    margin: 20px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.cart-title {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
    text-align: center;
}

.cart-item {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
    padding: 10px;
    border-bottom: 1px solid #ccc;
}

.cart-item img {
    width: 80px;
    height: 80px;
    margin-right: 15px;
    border-radius: 5px;
}

.cart-item .item-details {
    flex-grow: 1;
}

.cart-item h4 {
    margin: 0 0 5px;
    font-size: 18px;
}

.cart-item p {
    margin: 0;
    font-size: 14px;
    color: #555;
}

.cart-item .item-quantity {
    margin-top: 10px;
}

.cart-item input[type="number"] {
    width: 50px;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
    background-color: #f5f5f5;
    cursor: not-allowed;
}

.cart-summary {
    margin-top: 20px;
    padding: 10px;
    border-top: 2px solid #ccc;
    font-size: 16px;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    padding: 5px 0;
}

.action-buttons {
    margin-top: 20px;
    display: flex;
    justify-content: space-between;
}

.ship-btn, .cancel-btn {
    background-color: #000; /* Bootstrap primary color */
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    flex: 1; /* Allow buttons to take equal space */
    margin: 0 5px; /* Space between buttons */
}

.ship-btn:hover {
    background-color: #333; /* Darker shade on hover */
}

.cancel-btn:hover {
    background-color: #333; /* Darker shade on hover */
}

.checkout-btn:disabled {
    background-color: #ccc; /* Disabled button color */
    cursor: not-allowed; /* Not allowed cursor */
} </style>
</head>
<body>
    <div class="cart-container">
        <div class="cart-title">Order Management</div>
        <form method="POST" action="">
            <?php foreach ($orders as $order): ?>
                <div class="cart-item">
                    <input type="checkbox" class="select-check" name="order_ids[]" value="<?php echo htmlspecialchars($order['id']); ?>">
                    <img src="https://via.placeholder.com/80" alt="Product Image">
                    <div class="item-details">
                        <h4><?php echo htmlspecialchars($order['product_name']); ?></h4>
                        <p>Color: <?php echo htmlspecialchars($order['color']); ?></p>
                        <p>Size: <?php echo htmlspecialchars($order['size']); ?></p>
                        <div class="item-quantity">
                            <label for="quantity_<?php echo $order['id']; ?>">Quantity:</label>
                            <input type="number" id="quantity_<?php echo $order['id']; ?>" name="quantity[]" value="<?php echo htmlspecialchars($order['quantity']); ?>" min="1" readonly>
                        </div>
                    </div>
                    <div class="item-price">₱<?php echo htmlspecialchars(number_format($order['price'], 2)); ?></div>
                </div>
            <?php endforeach; ?>

            <div class="cart-summary">
                <div class="summary-item">
                    <span>Subtotal</span>
                    <span>₱<?php echo htmlspecialchars(number_format(array_sum(array_column($orders, 'price')), 2)); ?></span>
                </div>
                <div class="summary-item">
                    <span>Shipping Method</span>
                    <span>COD</span>
                </div>
                <div class="summary-item" style="font-weight: bold;">
                    <span>Total</span>
                    <span>₱<?php echo htmlspecialchars(number_format(array_sum(array_column($orders, 'price')), 2)); ?></span>
                </div>
            </div>

            <div class="action-buttons">
                <button type="submit" name="action" value="ship" class="ship-btn">Mark as Shipped</button>
                <button type="submit" name="action" value="cancel" class="cancel-btn">Cancel</button>
            </div>
        </form>
    </div>
</body>
</html>