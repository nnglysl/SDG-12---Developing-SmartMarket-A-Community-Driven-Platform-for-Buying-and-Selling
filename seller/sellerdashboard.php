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


/* Container styles */
.container {
    margin-left: 250px;
    padding: 20px;
}

/* Header styles */
.header {
    display: flex;
    justify-content: flex-end; /* Align content to the right */
    align-items: center;
    margin-bottom: 30px;
    padding: 10px;
}

/* Header right section (Switch Account button) */
.header-right {
    display: flex;
    justify-content: flex-end;
    width: 100%;
}

/* Switch Account button styles */
.switch-account {
    padding: 10px 15px;
    background-color: #fcfcfc; /* Light background */
    color: rgb(0, 0, 0);
    border: none;
    border-radius: 5px;
    cursor: pointer;
    display: flex;
    align-items: center;
    transition: background-color 0.3s ease, transform 0.2s ease; /* Add transition */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Add a shadow to the button */
}

.switch-account .icon {
    margin-right: 5px;
    font-size: 18px;
}

/* Button hover effect */
.switch-account:hover {
    background-color: #f546ac; /* Light pink background on hover */
    color: #000; /* Change text to black on hover */
    transform: scale(1.05); /* Slightly enlarge on hover */
}

.switch-account:active {
    background-color: #fa36a8; /* Light pink when pressed */
    color: #000;
}

/* Card styles */
.profile-card, .product-card {
    background-color: white;
    border-radius: 10px;
    padding: 50px;
    margin-bottom: 70px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Deeper shadow */
    transition: transform 0.3s ease; /* Add transition for hover effect */
}

.product-card:hover {
    transform: translateY(-5px); /* Lift effect on hover */
}

.product-card img {
    max-width: 100px;
    margin-right: 10px;
    border-radius: 10px; /* Add a border radius to the image */
}

/* Shop management styles */
.shop-management h2 {
    font-size: 22px;
    margin-bottom: 15px;
    color: #333; /* Change the color of the h2 text */
    font-weight: bold; /* Make the heading bold */
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1); /* Subtle text shadow */
}

.product-card h4 {
    font-size: 18px;
    font-weight: 600;
    color: #333; /* Change the color of the product title */
}

.product-card p {
    font-size: 14px;
    color: #666; /* Lighter color for product description */
}

/* Button styles */
.button {
    background-color: #ffb6c1; /* Soft pink button */
    color: white;
    border: none;
    border-radius: 5px;
    padding: 10px 15px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease; /* Add transition */
}

.button:hover {
    background-color: #fc6a9a; /* Darker pink on hover */
    transform: scale(1.05); /* Slightly enlarge on hover */
}

/* Footer styles */
.footer {
    text-align: center;
    padding: 20px;
    background-color: #222;
    color: white;
    position: relative;
    bottom: 0;
    width: 100%;
}

/* Media queries for responsiveness */
@media (max-width: 768px) {
    .sidebar {
        width: 200px; /* Adjust sidebar width for smaller screens */
    }

    .container {
        margin-left: 200px; /* Adjust container margin */
    }

    .header {
        flex-direction: column; /* Stack header items */
        align-items: flex-start; /* Align items to the start */
    }

    .header-right {
        width: 100%; /* Full width for header right section */
        justify-content: space-between; /* Space out items */
    }

    .product-card {
        flex-direction: column; /* Stack product card items */
    }
}
    </style>
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