<?php
include '../../db/dbcon.php';
include '../../php/search_bar.php';

$database = new Database();
$conn = $database->getConnection();

$product_id = 3; 
$query = "SELECT variation_value, stock, variation_type FROM product_variations WHERE product_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

$variations = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();

session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the product details from the form
  $product_id = $_POST['product_id'];
  $product_name = $_POST['product_name'];
  $product_price = $_POST['product_price'];
  $selected_size = $_POST['selected_size'];
  $quantity = intval($_POST['quantity']);
  $product_image = $_POST['product_image']; 
  require_once '../../seller/dbcart.php';
  $cart = new ShoppingCart();

  $cart->addItem($product_name, $product_price, $quantity, $selected_size, $product_image);

  header('Location: /final/seller/cart.php'); 
  exit();
}

$database->closeConnection();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CABE Product Page</title>
  <link rel="stylesheet" href="/final/items_deptshirt/cabe/cabe.css" />
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

        <!-- Search Bar -->
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
            <a href="../profile/profile.php"><i class="bx bx-user"></i></a>
            <a href="../seller/cart.php"><i class="bx bx-cart"></i></a>
            <a href="../logout/logout.php"><i class="bx bx-log-out"></i></a>
        </div>
        
        </header>
  <main class="product-page">
    <div class="center-container">
      <!-- Product Details -->
      <section class="product-details">
        <div class="product-image-gallery">
          <div class="main-image">
            <img id="mainImage1" class="slider-image active" src="/final/imgs/department shirts/cabe.png"
              alt="Product Image" />
          </div>
        </div>

        <div class="product-info">
          <h1 class="product-title">CABE Department Shirt</h1>
          <p class="product-price">₱ 500</p>

          
          <form id="addToCartForm" method="POST" action="">
            <input type="hidden" name="product_id" value="<?= $product_id; ?>">
            <input type="hidden" name="product_name" value="CABE Department Shirt">
            <input type="hidden" name="product_price" value="500">
            <input type="hidden" name="product_image" value="/final/imgs/department shirts/cabe.png">
            <input type="hidden" id="selectedSizeInput" name="selected_size" value="">
            <input type="hidden" id="quantityInput" name="quantity" value="1">

            <!-- Size Options -->
            <div class="product-options">
              <h3>Sizes</h3>
              <div class="size-options">
                <?php foreach ($variations as $variation): ?>
                  <?php if ($variation['variation_type'] == 'size'): ?>
                    <button type="button" class="size-option" 
                            data-size="<?= htmlspecialchars($variation['variation_value']) ?>" 
                            data-stock="<?= htmlspecialchars($variation['stock']) ?>">
                      <?= htmlspecialchars($variation['variation_value']) ?>
                    </button>
                  <?php endif; ?>
                <?php endforeach; ?>
              </div>
            </div>

            <div class="quantity-selector">
              <h4>Quantity</h4>
              <div class="buttons">
                <button type="button" id="decrease">-</button>
                <input type="number" id="quantity" value="1" min="1" />
                <button type="button" id="increase">+</button>
              </div>
              <p id="stock-info">Please select a size.</p> <!-- To show available stock -->
            </div>

            <div class="product-buttons">
              <button type="submit" class="add-to-cart">Add to Cart</button>
              <button class="buy-now">Buy Now</button>
            </div>
          </form>

          <!-- JavaScript for quantity adjustment and size selection -->
          <script>
            const stockData = <?php echo json_encode($variations); ?>;
            let selectedSize = null;

            // Update quantity limits based on selected size
            function updateQuantityLimits() {
              const quantityInput = document.getElementById("quantity");
              const stockInfo = document.getElementById("stock-info");
              const maxStock = stockData.find(item => item.variation_value === selectedSize)?.stock;

              if (maxStock) {
                quantityInput.max = maxStock;
                stockInfo.textContent = 'Available stock: ' + maxStock;

                // Disable or enable increase/decrease buttons
                document.getElementById("increase").disabled = quantityInput.value >= maxStock;
                document.getElementById("decrease").disabled = quantityInput.value <= 1;

                // Ensure the quantity doesn't exceed the stock
                if (parseInt(quantityInput.value) > maxStock) {
                  quantityInput.value = maxStock;
                }
              } else {
                stockInfo.textContent = 'Please select a size.';
              }
            }

            // Size button event listener
            document.querySelectorAll('.size-options button').forEach(button => {
              button.addEventListener('click', function () {
                document.querySelectorAll('.size-options button').forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                // Get the selected size and stock
                selectedSize = this.getAttribute('data-size');
                const stock = this.getAttribute('data-stock');

                // Update the hidden input value
                document.getElementById('selectedSizeInput').value = selectedSize;

                // Update quantity limits
                updateQuantityLimits();
              });
            });

            // Increase/decrease quantity buttons
            document.getElementById("increase").addEventListener("click", function () {
              const quantityInput = document.getElementById("quantity");
              if (selectedSize && parseInt(quantityInput.value) < stockData.find(item => item.variation_value === selectedSize)?.stock) {
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

            // Update the quantity input value before form submission
            document.getElementById('addToCartForm').addEventListener('submit', function() {
              document.getElementById('quantityInput').value = document.getElementById('quantity').value;
            });
          </script>

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
        <p>
          CABE Department Shirt<br>
          Small - W:14 L:26<br>
          Medium - W:20 L:27<br>
          Large - W:21 L:28<br>
        </p>
      </section>
    </div>
  </main>
  <footer>
        <p>&copy; 2024 SmartMarket. All rights reserved.</p>
  </footer>
</body>
</html>