<?php 
require_once 'dbcancel.php';
require_once 'dborders.php'; // Include the OrderManager class

$orderManager = new OrderManager();
$canceledOrders = $orderManager->getCanceledOrders();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data from the POST request
    $product_name = $_POST['product_name'];
    $color = $_POST['color']; 
    $size = $_POST['size'];  
    $reason = $_POST['reason'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];


    $cancel = new Cancel();
    $cancel->createOrder($product_name, $color, $size, $reason, $quantity, $price);

    $cancel->closeConnection();
}

// Close the order manager connection
$orderManager->closeConnection();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
    <link rel="stylesheet" href="cancel.css">
</head>
<body>
    <div class="cart-container">
        <form action="" method="POST">
            <div class="cart-title">Cancelled Orders</div>
            <?php
            if (count($canceledOrders) > 0) {
                foreach ($canceledOrders as $order) {
                    echo "<div class='cart-item'>
                            <input type='checkbox' class='select-check'>
                            <img src='#' alt='Product Image'>
                            <div class='item-details'>
                                <h4>{$order['product_name']}</h4>
                                <p>Color: {$order['color']}</p>
                                <p>Size: {$order['size']}</p>
                                <p>Reason: {$order['reason']}</p>
                                <div class='item-quantity'>
                                    <label for='quantity'>Quantity:</label>
                                    <input type='number' id='quantity' name='quantity' value='{$order['quantity']}' min='1' readonly>
                                </div>
                            </div>
                            <div class='item-price'>₱{$order['price']}</div>
                            <button class='approve-btn'>Approve</button>
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
            <button class='approve'>Approve</button>
        </form>
    </div>
</body>
</html>