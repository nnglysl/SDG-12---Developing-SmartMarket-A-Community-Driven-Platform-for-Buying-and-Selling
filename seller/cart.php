<?php
require_once 'dbcart.php';
require_once 'dborders.php'; 

$cart = new ShoppingCart();
$orderManager = new OrderManager(); 

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'add') {
        $cart->addItem($_POST['name'], $_POST['price'], $_POST['quantity'], $_POST['image']);
    } elseif ($action === 'update') {
        $id = intval($_POST['id']);
        $quantity = intval($_POST['quantity']);
        $cart->updateItem($id, $quantity);
    } elseif ($action === 'delete') {
        $id = intval($_POST['id']);
        $cart->deleteItem($id);
    } elseif ($action === 'checkout') {
        $items = $cart->getCart();
        $total = $cart->calculateTotal();
        
        foreach ($items as $item) {
            
            $orderManager->createOrder($item['name'], $item['price'], $item['quantity'], $item['price'] * $item['quantity'], $item['image']);
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
    <style>
      body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        
        .cart-container {
            width: 70%;
            margin: 200px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .cart-title {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }

        .cart-item {
            display: flex;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .cart-item img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-right: 20px;
        }

        .item-details {
            flex: 1;
        }

        .item-details h4 {
            margin: 0;
            font-size: 18px;
            color: #555;
        }

        .item-details p {
            margin: 5px 0;
            color: #777;
        }

        .item-quantity {
            margin-top: 10px;
        }

        .item-price {
            font-size: 18px;
            color: #333;
            margin-left: 20px;
            min-width: 100px;
        }

        .delete-btn, .checkout-btn {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .delete-btn:hover, .checkout-btn:hover {
            background-color: #ff1a1a;
        }

        .cart-summary {
            margin-top: 20px;
            padding: 10px;
            border-top: 2px solid #ddd;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
        }

        .summary-item span {
            font-size: 16px;
            color: #333;
        }

        .summary-item:last-child {
            font-weight: bold;
            font-size: 18px;
        }
    </style>
</head>
<body>
<?php include('../header/header.php'); ?>
<div class="cart-container">
        <div class="cart-title">My Cart</div>
        <?php foreach ($items as $item): ?>
            <div class="cart-item">
                <input type="checkbox" class="select-check">
                <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="Product Image">
                <div class="item-details">
                    <h4><?php echo htmlspecialchars($item['name']); ?></h4>
                    <p>Price: ₱<?php echo htmlspecialchars($item['price']); ?></p>
                    <div class="item-quantity">
                        <label for="quantity">Quantity:</label>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                            <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" required>
                            <button type="submit" class="delete-btn">Update</button>
                        </form>
                    </div>
                </div>
                <div class="item-price">₱<?php echo number_format($item['price'] * $item['quantity'], 2); ?></div>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                    <button type="submit" class="delete-btn">Delete</button>
                </form>
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

        <form method="POST">
            <input type="hidden" name="action" value="checkout">
            <button type="submit" class="checkout-btn">Checkout</button>
        </form>
    </div>
</body>
</html>