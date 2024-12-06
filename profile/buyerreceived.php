<?php
// Include the OrderManager class
require_once '../profile/buyerorder.php';

$orderManager = new BuyerOrder();

session_start();
$buyer_id = $_SESSION['buyer_id']; 

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the action is to cancel orders
    if (isset($_POST['action']) && $_POST['action'] === 'cancel' && isset($_POST['order_ids'])) {
        // Get the selected order IDs
        $order_ids = $_POST['order_ids'];
        
        // Cancel each selected order
        foreach ($order_ids as $order_id) {
            $orderManager->cancelOrder($order_id); // Ensure this method exists in your class
        }
    }

    // Check if the action is to mark orders as delivered
    if (isset($_POST['single_order_id'])) {
        $order_id = $_POST['single_order_id'];
        $orderManager->updateOrderStatus($order_id, 'delivered'); // Ensure this method exists in your class
    }
}

// Fetch the orders for the buyer
$orders = $orderManager->getReceivedOrders($buyer_id);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
    <link rel="stylesheet" href="../css/buyertoreceive.css">
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
                        <p>Price: ₱<?php echo htmlspecialchars(number_format($order['item_price'], 2)); ?></p>
                        <div class="item-quantity">
                            <label for="quantity_<?php echo $order['id']; ?>">Quantity:</label>
                            <input type="number" id="quantity_<?php echo $order['id']; ?>" name="quantity[]" value="<?php echo htmlspecialchars($order['quantity']); ?>" min="1" readonly>
                        </div>
                    </div>
                    <div class="action-buttons">
                        <button type="submit" name="single_order_id" value="<?php echo htmlspecialchars($order['id']); ?>" class="ship-btn">Mark as Delivered</button>
                        <button type="button" class="cancel-btn">Cancel</button>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="cart-summary">
                <div class="summary-item">
                    <span>Subtotal</span>
                    <span>₱<?php echo htmlspecialchars(number_format(array_sum(array_column($orders, 'item_price')), 2)); ?></span>
                </div>
            </div>
        </form>
    </div>
</body>
</html>