<?php
require_once '../db/Seller.php'; 

$orderManager = new Market();
$orders = $orderManager->getShip(); 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    $orderIds = $_POST['order_id'] ?? []; // Get selected order IDs

    // Process the action
    if (!empty($orderIds)) {
        if ($_POST['action'] == 'ship') {
            foreach ($orderIds as $orderId) {
                $orderManager->markOrderAsShipped($orderId); 
            }
        } elseif ($_POST['action'] == 'cancel') {
            foreach ($orderIds as $orderId) {
                $orderManager->cancelOrder($orderId); 
            }
        }
    }

    // Redirect to the same page to avoid form resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$orderManager->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
    <link rel="stylesheet" href="../css/toship.css"/>
</head>
<body>
<?php include('../sidebar/sidebar.php'); ?>
    <div class="cart-container">
        <div class="cart-title">Order To Ship</div>
        <form method="POST" action="">
            <?php foreach ($orders as $order): ?>
                <div class="cart-item">
                    <input type="checkbox" class="select-check" name="order_id[]" value="<?php echo htmlspecialchars($order['id']); ?>">
                    <img src="<?php echo htmlspecialchars($order['item_picture']); ?>" alt="Product Image">
                    <div class="item-details">
                        <h4><?php echo htmlspecialchars($order['item_name']); ?></h4>
                        <p>Price: ₱<?php echo htmlspecialchars(number_format($order['item_price'], 2)); ?></p>
                        <div class="item-quantity">
                            <label for="quantity_<?php echo $order['id']; ?>">Quantity:</label>
                            <input type="number" id="quantity_<?php echo $order['id']; ?>" name="quantity[]" value="<?php echo htmlspecialchars($order['quantity']); ?>" min="1" readonly>
                        </div>
                    </div>
                    <div class="item-price">₱<?php echo htmlspecialchars(number_format($orderManager->calculateTotalAmount($order['item_price'], $order['quantity']), 2)); ?></div>
                </div>
            <?php endforeach; ?>

            <div class="cart-summary">
                <div class="summary-item">
                    <span>Subtotal</span>
                    <span>₱<?php echo htmlspecialchars(number_format(array_sum(array_map(function($order) use ($orderManager) {
                        return $orderManager->calculateTotalAmount($order['item_price'], $order['quantity']);
                    }, $orders)), 2)); ?></span>
                </div>
                <div class="summary-item">
                    <span>Shipping Method</span>
                    <span>COD</span>
                </div>
                <div class="summary-item" style="font-weight: bold;">
                    <span>Total</span>
                    <span>₱<?php echo htmlspecialchars(number_format(array_sum(array_map(function($order) use ($orderManager) {
                        return $orderManager->calculateTotalAmount($order['item_price'], $order['quantity']);
                    }, $orders)), 2)); ?></span>
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