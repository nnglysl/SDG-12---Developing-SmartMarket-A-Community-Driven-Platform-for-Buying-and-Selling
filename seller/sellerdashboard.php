<?php
session_start();
require_once '../db/Seller.php';

if (isset($_SESSION['seller_id'])) {
    $sellerId = $_SESSION['seller_id']; 
    
    $seller = new Market();
    
    $sellerInfo = $seller->getSellerInfo($sellerId);
    $sellerProducts = $seller->getSellerProducts($sellerId);
} else {
    die("Error: seller_id not specified in session.");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard</title>
    <link rel="stylesheet" href="../css/sellerdashboard.css">
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
                                
                                <form action="deleteproduct.php" method="post" style="display:inline;">
                                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['product_id']); ?>">
                                    <a href="editshop.php?id=<?php echo htmlspecialchars($product['product_id']); ?>"class="btn">Edit</a>
                                    <button type="submit" class="btn" onclick="return confirm('Are you sure you want to delete this product?');">Delete</button>
                                </form>
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