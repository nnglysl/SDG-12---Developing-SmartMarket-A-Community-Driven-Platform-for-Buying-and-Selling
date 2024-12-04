
<?php 
require_once 'dborders.php';

$orderManager = new OrderManager();
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
$orderManager->closeConnection();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
    <link rel="stylesheet" href="cancel.css">
    <style>
        /* Reset styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body styles */
body {
    font-family: 'Arial', sans-serif;
    background: linear-gradient(to right, #f8e7f1, #e0c3fc); /* Soft gradient background */
    color: #333; /* Dark text for readability */
}

/* Cart container styles */
.cart-container {
    max-width: 800px; /* Set a max width for the container */
    margin: 50px auto; /* Center the container */
    background-color: white; /* White background for the container */
    border-radius: 10px; /* Rounded corners */
    padding: 30px; /* Padding inside the container */
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Subtle shadow */
}

/* Title styles */
.cart-title {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px; /* Space below the title */
    text-align: center; /* Center the title */
    color: #ff6f61; /* Color for the title */
}

/* Cart item styles */
.cart-item {
    display: flex; /* Flex layout for items */
    align-items: center; /* Center items vertically */
    margin-bottom: 15px; /* Space between items */
    padding: 10px; /* Padding around each item */
    border: 1px solid #ffb6c1; /* Soft pink border */
    border-radius: 5px; /* Rounded corners */
    transition: transform 0.2s; /* Transition for hover effect */
}

.cart-item:hover {
    transform: scale(1.02); /* Slightly enlarge on hover */
}

/* Item image styles */
.cart-item img {
    width: 80px;
    height: 80px;
    margin-right: 15px;
    border-radius: 5px; /* Rounded corners for images */
}

/* Item details styles */
.item-details {
    flex: 1; /* Take up remaining space */
}

.item-details h4 {
    margin-bottom: 5px; /* Space below item name */
    color: #333; /* Darker color for item name */
}

.item-details p {
    margin-bottom: 5px; /* Space below reason */
    color: #666; /* Lighter color for reason */
}

/* Item price styles */
.item-price {
    font-weight: bold; /* Bold for price */
    color: #ff6f61; /* Color for price */
}

/* Quantity input styles */
.item-quantity {
    display: flex;
    align-items: center; /* Center vertically */
}

.item-quantity label {
    margin-right: 10px; /* Space between label and input */
}

/* Cart summary styles */
.cart-summary {
    margin-top: 20px; /* Space above summary */
    border-top: 2px solid #ffb6c1; /* Soft pink border on top */
    padding-top: 10px; /* Padding above summary */
}

.summary-item {
    display: flex; /* Flex layout for summary items */
    justify-content: space-between; /* Space between label and value */
    margin: 10px 0; /* Space between summary items */
}

.summary-item span {
    font-size: 16px; /* Font size for summary */
}

/* Action buttons styles */
.approve-btn {
    background-color: #ffb6c1; /* Soft pink button */
    color: white;
    border: none;
    border-radius: 5px;
    padding: 10px 15px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease; /* Add transition */
    margin-left: 10px; /* Space between button and checkbox */
}

.approve-btn:hover {
    background-color: #fc6a9a; /* Darker pink on hover */
    transform: scale(1.05); /* Slightly enlarge on hover */
}

.approve {
    background-color: #ff6f61; /* Approve button color */
    color: white;
    border: none;
    border-radius: 5px;
    padding: 10px 15px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease; /* Add transition */
    margin-top: 20px; /* Space above button */
    width: 100%; /* Full width */
}

/* Media queries for responsiveness */
@media (max-width: 768px) 
{
    .cart-container {
        padding: 20px; /* Adjust padding for smaller screens */
        width: 90%; /* Make it responsive */
    }

    .cart-item {
        flex-direction: column; /* Stack items vertically on small screens */
        align-items: flex-start; /* Align items to the start */
    }

    .item-price {
        margin-top: 10px; /* Space above price */
    }

    .approve-btn {
        margin-left: 0; /* Remove left margin for stacked layout */
        margin-top: 10px; /* Space above button */
    }
}
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
