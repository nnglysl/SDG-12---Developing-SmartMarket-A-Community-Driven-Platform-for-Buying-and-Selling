<?php

include('../header/header.php');
include('../db/dbshop.php'); 

$dbInstance = new Database();
$conn = $dbInstance->getConnection();

$productInstance = new Product($conn);

$products = $productInstance->getAllProducts();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Shop</title>
  <link rel="stylesheet" href="/final/shop/shop.css" />
  <link href="https://fonts.google.com/specimen/Nanum+Gothic" rel="stylesheet" />
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" />
  <link rel="stylesheet" href="/final/css/nav.css" />
</head>

<body>

  <!-- Shop Section -->
  <section id="shop" class="shop-section-first" aria-labelledby="shop-heading">
    <div class="products">
      <?php if ($products && mysqli_num_rows($products) > 0) { ?>
        <?php while ($product = mysqli_fetch_assoc($products)) { ?>
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
