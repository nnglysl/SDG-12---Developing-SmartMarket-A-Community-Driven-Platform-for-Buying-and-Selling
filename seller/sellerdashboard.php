<?php
session_start();
require_once '../db/dbdashboard.php';

if (isset($_SESSION['seller_id'])) {
    $sellerId = $_SESSION['seller_id']; 
    
    $seller = new Seller();
    
    // Fetch seller information and products
    $sellerInfo = $seller->getSellerInfo($sellerId);
    $sellerProducts = $seller->getSellerProducts($sellerId);
} else {
    // Handle the case where seller_id is not provided in the session
    die("Error: seller_id not specified in session.");
}

// Return data as JSON if needed for AJAX or just include it in HTML
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard</title>
    <link rel="stylesheet" href="sellerdashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    
    <?php include('../sidebar/sidebar.php'); ?>
    <div class="container">
    <div class="header">
        <div class="header-right">
            <form action="switchtobuyer.php" method="post">
                <button type="submit" class="btn switch-account" id="switch-account">
                    <span class="icon">&#x1F464;</span> Switch Account
                </button>
            </form>
        </div>
    </div>
        
        <div class="content">
            <div class="profile-card">
                <h3>Shop Name: <span id="seller-name"><?php echo htmlspecialchars($sellerInfo['shop_name']); ?></span></h3>
                <br>     
                <p>Email: <span id="seller-email"><?php echo htmlspecialchars($sellerInfo['email']); ?></span></p>
                <p>Ratings: <span id="seller-rating"><?php echo htmlspecialchars($sellerInfo['rating']); ?></span> ⭐</p>
            </div>
            <div class="shop-management">
                <h2>Shop Management</h2>
                <?php if (!empty($sellerProducts)): ?>
                    <?php foreach ($sellerProducts as $product): ?>
                        <div class="product-card">
                            <img src="<?php echo htmlspecialchars($product['image_path']); ?>" alt="Product Image">
                            <div>
                                <h4><?php echo htmlspecialchars($product['product_name']); ?></h4>
                                <p>Price: $<span><?php echo htmlspecialchars($product['price']); ?></span></p>
                            </div>
                            <div>
                                <button class="btn">Edit</button>
                                <button class="btn">Delete</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No products found for this seller.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>