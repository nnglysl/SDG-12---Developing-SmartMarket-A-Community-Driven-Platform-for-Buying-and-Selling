
<?php 
require_once '../db/Seller.php';

$orderManager = new Market();
$canceledOrders = $orderManager->getCanceledOrders(); 


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel_selected'])) {
    // Loop through selected order IDs
    if (!empty($_POST['selected_orders'])) {
        foreach ($_POST['selected_orders'] as $orderId) {
            $orderManager->cancelOrder($orderId); 
        }
    }
}

// Close the order manager connection
$orderManager->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
    <link rel="stylesheet" href="../css/cancelorder.css">
    <style>
     
    </style>
</head>
<body>
    <?php include('../sidebar/sidebar.php');?>
    <div class="cart-container">
        <form action="" method="POST">
            <div class="cart-title">Cancelled Orders</div>
            <?php
            if (count($canceledOrders) > 0) {
                foreach ($canceledOrders as $order) {
                    echo "<div class='cart-item'>
                            <input type='checkbox' name='selected_orders[]' value='{$order['id']}' class='select-check'>
                            <img src='{$order['item_picture']}' alt='Product Image' style='width: 80px; height: 80px;'>
                            <div class='item-details'>
                                <h4>{$order['product_name']}</h4>
                                <p>Reason: {$order['reason']}</p>
                                <div class='item-quantity'>
                                    <label for='quantity'>Quantity:</label>
                                    <input type='number' id='quantity' name='quantity' value='{$order['quantity']}' min='1' readonly>
                                </div>
                            </div>
                            <div class='item-price'>₱{$order['price']}</div>
                            <button type='submit' name='approve' class='approve-btn'>Approve</button>
                            <input type='hidden' name='order_id' value='{$order['id']}'> <!-- Hidden input for order ID -->
                        </div>";
                }
                echo "<div class='cart-summary'>
                        <div class='summary-item'>
                            <span>Subtotal</span>
                            <span>₱" . array_sum(array_column($canceledOrders, 'price')) . "</span>
                        </div>
                        <div class='summary-item'>
                            <span>Shipping Method</span>
                            <span>COD</span>
                        </div>
                        <div class='summary-item' style='font-weight: bold;'>
                            <span>Total</span>
                            <span>₱" . array_sum(array_column($canceledOrders, 'price')) . "</span>
                        </div>
                    </div>";
            } else {
                echo "<p>No canceled orders found.</p>";
            }
            ?>
            <button type='submit' name='cancel_selected' class='approve'>Cancel Selected</button>
        </form>
    </div>
</body>
</html>
