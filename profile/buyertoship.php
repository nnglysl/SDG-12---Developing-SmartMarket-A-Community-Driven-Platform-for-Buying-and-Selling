<?php
// Include the OrderManager class
require_once '../profile/buyerorder.php';


$orderManager = new BuyerOrder();

session_start();
$buyer_id = $_SESSION['buyer_id']; 
$orders = $orderManager->getShipOrder($buyer_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
    <link rel="stylesheet" href="styles.css">
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
    margin: 150px auto; /* Center the container */
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
    margin-bottom: 5px; /* Space below price */
    color: #666; /* Lighter color for price */
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
.action-buttons {
    display: flex; /* Flex layout for buttons */
    justify-content: space-between; /* Space between buttons */
    margin-top: 20px; /* Space above buttons */
}

.ship-btn, .cancel-btn {
    background-color: #ffb6c1; /* Soft pink button */
    color: white;
    border: none;
    border-radius: 5px;
    padding: 10px 15px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease; /* Add transition */
    flex: 1; /* Take up equal space */
    margin: 0 5px; /* Space between buttons */
}

.ship-btn:hover {
    background-color: #fc6a9a; /* Darker pink on hover */
    transform: scale(1.05); /* Slightly enlarge on hover */
}

.cancel-btn {
    background-color: #ccc; /* Grey button for cancel */
}

.cancel-btn:hover {
    background-color: #bbb; /* Darker grey on hover */
}

/* Media queries for responsiveness */
@media (max-width: 768px) {
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

    .action-buttons {
        flex-direction: column; /* Stack buttons vertically */
    }

    .ship-btn, .cancel-btn {
        margin: 5px 0; /* Space between stacked buttons */
    }
} </style>
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
                            <input type="number" id="quantity_<?php echo $order['id']; ?>" name="quantity[]" value="<?php echo htmlspecialchars($order['item_quantity']); ?>" min="1" readonly>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="cart-summary">
                <div class="summary-item">
                    <span>Subtotal</span>
                    <span>₱<?php echo htmlspecialchars(number_format(array_sum(array_map(function($order) use ($orderManager) {
                    }, $orders)), 2)); ?></span>
                </div>
                <div class="summary-item">
                    <span>Shipping Method</span>
                    <span>COD</span>
                </div>
            </div>
        </form>
    </div>
</body>
</html>