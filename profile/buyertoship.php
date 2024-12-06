<?php
// Include the OrderManager class
require_once '../profile/buyerorder.php';

$orderManager = new BuyerOrder();

session_start();
$buyer_id = $_SESSION['buyer_id']; 
$orders = $orderManager->getShipOrder($buyer_id);

// Handle cancellation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'cancel') {
    $order_ids = $_POST['order_ids'] ?? [];
    foreach ($order_ids as $order_id) {
        // Call a method to cancel the order
        // $orderManager->cancelOrder($order_id); // Implement this method in your BuyerOrder class
    }
    $orders = $orderManager->getShipOrder($buyer_id);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="../profile/buyertoship.css">
</head>
<body>
<?php include('../header/header.php'); ?>
    <div class="cart-container">
        <div class="cart-title">Order Management</div>
        <form method="POST" action="">
            <?php foreach ($orders as $order): ?>
                <div class="cart-item">
                    <input type="checkbox" class="select-check" name="order_ids[]" value="<?php echo htmlspecialchars($order['id']); ?>">
                    <img src="<?php echo htmlspecialchars($order['item_picture']); ?>" alt="Product Image" style="width: 80px; height: 80px; margin-right: 15px; border-radius: 5px;">
                    <div class="item-details">
                        <h4><?php echo htmlspecialchars($order['item_name']); ?></h4>
                        <p>Order ID: <strong><?php echo htmlspecialchars($order['id']); ?></strong></p> <!-- Display Order ID -->
                        <p>Price: ₱<?php echo htmlspecialchars(number_format($order['item_price'], 2)); ?></p>
                        <div class="item-quantity">
                            <label for="quantity_<?php echo $order['id']; ?>">Quantity:</label>
                            <input type="number" id="quantity_<?php echo $order['id']; ?>" name="quantity[]" value="<?php echo htmlspecialchars($order['quantity']); ?>" min="1" readonly>
                        </div>
                    </div>
                </div>
                <div class="cart-summary">
                    <div class="summary-item">
                        <span>Subtotal</span>
                        <div class="item-price">₱<?php echo number_format($order['item_price'] * $order['quantity'], 2); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="action-buttons">
                <button type="submit" name="action" value="cancel" class="cancel-btn">Cancel</button>
            </div>
        </form>
    </div>
</body>
</html>