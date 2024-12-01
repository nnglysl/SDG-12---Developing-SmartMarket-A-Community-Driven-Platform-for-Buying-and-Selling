<?php
include '../../db/dbcon.php';
include '../../php/search_bar.php';

$database = new Database();
$conn = $database->getConnection();

$product_id = 5; 

$query = "SELECT stock FROM product_variations WHERE product_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$stmt->bind_result($stock);
$stmt->fetch();

$stmt->close();
$database->closeConnection();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Idlace Product Page</title>
  <link rel="stylesheet" href="/final/items/idlace/idlace.css" />
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
          <input type="text" name="search" class="search-bar" id="search" placeholder="Search"
            value="<?php echo htmlspecialchars($search_query); ?>" required>
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

  <main class="product-page">
    <div class="center-container">
      <!-- Product Details -->
      <section class="product-details">
        <div class="product-image-gallery">
          <div class="main-image">
            <img id="mainImage1" class="slider-image active" src="/final/imgs/school supplies/idlace.jpg"
              alt="Product Image" />
          </div>
        </div>

        <div class="product-info">
          <h1 class="product-title">ID Lace</h1>
          <p class="product-price" id="productPrice">₱ 50.00</p>

          <div class="quantity-selector">
            <h4>Quantity</h4>
            <div class="buttons">
              <button id="decrease">-</button>
              <input type="number" id="quantity" value="1" min="1" />
              <button id="increase">+</button>
            </div>
            <p id="stock-info">Available stock: <?php echo $stock; ?></p>
          </div>

          <!-- JS for Quantity -->
          <script>
            const stock = <?php echo $stock; ?>; 

            // Update quantity limits based on stock
            function updateQuantityLimits() {
              const quantityInput = document.getElementById("quantity");
              const stockInfo = document.getElementById("stock-info");

              quantityInput.max = stock;
              stockInfo.textContent = 'Available stock: ' + stock;

              // Disable or enable buttons based on available stock
              document.getElementById("increase").disabled = quantityInput.value >= stock;
              document.getElementById("decrease").disabled = quantityInput.value <= 1;

              // Ensure the quantity doesn't exceed the stock
              if (parseInt(quantityInput.value) > stock) {
                quantityInput.value = stock;
              }
            }

            // Increase/decrease quantity buttons
            document.getElementById("increase").addEventListener("click", function () {
              const quantityInput = document.getElementById("quantity");
              if (parseInt(quantityInput.value) < stock) {
                quantityInput.value = parseInt(quantityInput.value) + 1;
                updateQuantityLimits();
              }
            });

            document.getElementById("decrease").addEventListener("click", function () {
              const quantityInput = document.getElementById("quantity");
              if (quantityInput.value > 1) {
                quantityInput.value = parseInt(quantityInput.value) - 1;
                updateQuantityLimits();
              }
            });

            updateQuantityLimits();
          </script>

          <div class="product-buttons">
            <button class="add-to-cart">Add to Cart</button>
            <button class="buy-now">Buy Now</button>
          </div>
        </div>
      </section>

      <!-- Seller Info -->
      <section class="seller-info-section">
        <div class="seller-info">
          <img src="/final/imgs/sellerpics/rgo.jfif" alt="Seller Profile Pic" class="seller-logo" />
          <div class="seller-details">
            <h2 class="seller-name">Resource Generation Office</h2>
            <div class="seller-buttons">
              <a href="/final/contact/contact_rgo.php"><button class="chat-now">Contact us</button></a>
              <a href="/final/view_shop/view_shop_rgo.php" class="view-shop">View Shop</a>
            </div>
          </div>
        </div>
      </section>

      <!-- Product Description -->
      <section class="product-description">
        <h2>Product Description</h2>
        <p>BSU ID Lace</p>
      </section>
    </div>
  </main>
</body>

</html>
