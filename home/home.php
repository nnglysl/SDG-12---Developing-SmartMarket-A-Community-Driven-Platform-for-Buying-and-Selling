<?php

require_once '../db/dbcon.php'; 
require_once '../php/search_bar.php';
require_once '../db/dbhome.php';

$dbInstance = new Database(); 
$dbConnection = $dbInstance->getConnection(); 

if ($dbConnection->connect_error) {
    die("Failed to establish a database connection: " . $dbConnection->connect_error);
}

$homeInstance = new home($dbConnection);

$products = $homeInstance->getRandomProducts();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Apparel Store</title>
    <link rel="stylesheet" href="/final/home/home.css" />
    <link href="https://fonts.google.com/specimen/Nanum+Gothic" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" />
    <link rel="stylesheet" href="/final/css/nav.css" />
</head>

<body>
    <header>
        <img src="/final/imgs/mainpagelogo.png" alt="Logo" class="logo" />
        <ul class="nav">
            <li><a href="/final/home/home.php">HOME</a></li>
            <li><a href="/final/shop/shop.php">SHOP</a></li>
        </ul>
        <div class="search-container">
            <form method="get" action="/final/search/search_view.php">
                <div class="search-bar-wrapper">
                    <input type="text" name="search" class="search-bar" placeholder="Search"
                        value="<?php echo isset($search_query) ? htmlspecialchars($search_query) : ''; ?>" required />
                    <button type="submit" class="search-button">
                        <i class="bx bx-search"></i>
                    </button>
                </div>
            </form>
        </div>
        <div class="navicon">
            <a href="/final/profile/profile.php"><i class="bx bx-user"></i></a>
            <a href="#"><i class="bx bx-cart"></i></a>
        </div>
    </header>

    <section id="home" class="banner">
        <h1>Preloved and</h1>
        <p>Brand New Items</p>
        <a href="/final/shop/shop.php" class="btn">Shop Now <i class="bx bx-right-arrow-alt"></i></a>
    </section>

    <section id="shop" class="shop-section-first" aria-labelledby="shop-heading">
        <div class="products">
            <?php if (!empty($products)) { ?>
                <?php foreach ($products as $product) { ?>
                    <div class="product">
                        <a href="<?php echo htmlspecialchars($product['item_path']); ?>">
                            <img src="<?php echo htmlspecialchars($product['image_path']); ?>" alt="Product Image" />
                            <h3><?php echo htmlspecialchars($product['product_name']); ?></h3>
                            <p>₱ <?php echo htmlspecialchars(number_format($product['price'], 2)); ?></p>
                            <p class="condition"><?php echo htmlspecialchars($product['condition']); ?></p>
                        </a>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p>No products available.</p>
            <?php } ?>
        </div>
    </section>
</body>

</html>
