<?php
session_start();
require_once 'dbcart.php';
require_once 'dborders.php';
require_once '../db/dbcon.php';

$cart = new ShoppingCart();
$orderManager = new OrderManager();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'update') {
        $id = intval($_POST['id']);
        $quantity = intval($_POST['quantity']);
        $cart->updateItem($id, $quantity);
    } elseif ($action === 'delete') {
        $selected_items = $_POST['selected_items'] ?? []; 
        foreach ($selected_items as $id) {
            $cart->deleteItem(intval($id));
            echo "Item with ID $id has been deleted from the cart.<br>"; 
        }
    } elseif ($action === 'checkout') {

        $selected_item_ids = $_POST['selected_items'] ?? []; 
        $buyer_id = $_SESSION['buyer_id'] ?? null;
    
        // Check if any items were selected
        if (empty($selected_item_ids)) {
            echo "Please select at least one item for checkout.";
        } else {
            $cartItems = $cart->getCart(); 
            $orderCreated = true; 
    
            foreach ($selected_item_ids as $selected_item_id) {
                // Fetch the item details from the cart
                $item = null;
                foreach ($cartItems as $cartItem) {
                    if ($cartItem['id'] == $selected_item_id) {
                        $item = $cartItem; // Found the selected item
                        break;
                    }
                }
    
                if ($item === null) {
                    echo "Item with ID $selected_item_id not found in the cart.<br>";
                    $orderCreated = false; 
                    continue; 
                }
    
                $quantity = isset($_POST['quantity'][$selected_item_id]) ? intval($_POST['quantity'][$selected_item_id]) : 1;
    
                $itemOrderCreated = $orderManager->createOrder(
                    $item['product_name'], $quantity, $item['price'], $buyer_id, $item['product_picture']
                );
    
                if ($itemOrderCreated) {
                    echo "Order created successfully for item: " . htmlspecialchars($item['product_name']) . "<br>"; 
                    $cart->deleteItem(intval($item['id'])); 
                } else {
                    echo "Failed to create order for item: " . htmlspecialchars($item['product_name']) . "<br>";
                    $orderCreated = false; 
                }
            }
            if ($orderCreated) {
                echo "All selected orders have been created successfully.";
            } else {
                echo "Some orders could not be created.";
            }
        }

    }
}
// Calculate total
$total = $cart->calculateTotal();
$items = $cart->getCart();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="../css/nav.css"/>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" />
    <link rel="stylesheet" href="../seller/cart.css">
</head>
<body>
<header>
        <img src="../imgs/mainpagelogo.png" alt="Logo" class="logo" />

        <ul class="nav">
            <li><a href="../home/home.php">HOME</a></li>
            <li><a href="../shop/shop.php">SHOP</a></li>
        </ul>

        <div class="navicon">
            <a href="../profile/profile.php"><i class="bx bx-user"></i></a>
            <a href="../seller/cart.php"><i class="bx bx-cart"></i></a>
            <a href="../logout/logout.php"><i class="bx bx-log-out"></i></a>
        </div>
        
        </header>

<div class="cart-container">
    <div class="cart-title">My Cart</div>
    <form method="POST" id="cart-form">
    <?php foreach ($items as $item): ?>
        <div class="cart-item">
            <input type="checkbox" class="select-check" name="selected_items[]" value="<?php echo $item['id']; ?>">
            <img src="<?php echo htmlspecialchars($item['product_picture']); ?>" alt="Product Image">
            <div class="item-details">
                <h4><?php echo htmlspecialchars($item['product_name']); ?></h4>
                <p>Price: ₱<?php echo htmlspecialchars($item['price']); ?></p>
                <p>Size: <?php echo htmlspecialchars($item['size']); ?></p>
                <div class="item-quantity">
                    <label for="quantity_<?php echo $item['id']; ?>">Quantity:</label>
                    <input type="number" name="quantity[<?php echo $item['id']; ?>]" id="quantity_<?php echo $item['id']; ?>" value="1" min="1" required>
                </div>
            </div>
            <div class="item-price">₱<?php echo number_format($item['price'], 2); ?></div>
        </div>
    <?php endforeach; ?>

        <div class="cart-summary">
            <div class="summary-item">
                <span>Subtotal</span>
                <span>₱<?php echo number_format($total, 2); ?></span>
            </div>
            <div class="summary-item">
                <span>Shipping</span>
                <span>COD</span>
            </div>
            <div class="summary-item" style="font-weight: bold;">
                <span>Total</span>
                <span>₱<?php echo number_format($total, 2); ?></span>
            </div>
        </div>

        <div class="cart-actions">
        <button type="submit" name="action" value="delete" class="delete-btn">Delete Selected</button>
        <button type="submit" name="action" value="checkout" class="checkout-btn">Checkout Selected</button>
    </div>
    </form>
</div>
</body>
</html>