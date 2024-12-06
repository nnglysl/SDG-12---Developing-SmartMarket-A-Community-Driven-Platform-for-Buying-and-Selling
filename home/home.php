<?php
require_once '../db/dbcon.php';
require_once '../db/dbhome.php';

// Create a new database connection
$database = new Database();
$conn = $database->getConnection();

// Use the Home class to fetch products
$home = new Home($conn);
$products = $home->getRandomProducts();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Apparel Store</title>
    <link rel="stylesheet" href="home.css" />
    <link href="https://fonts.google.com/specimen/Nanum+Gothic" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" />
    <link rel="stylesheet" href="../css/nav.css" />
</head>

<body>
    <?php include('../header/header.php'); ?>
    <section id="home" class="banner">
        <h1>Preloved and</h1>
        <p>Brand New Items</p>

        <a href="../shop/shop.php" class="btn">Shop Now <i class="bx bx-right-arrow-alt"></i></a>
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
                            <p><?php echo htmlspecialchars($product['condition']); ?></p>
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