<?php
include '../../db/dbcon.php';
include '../../php/search_bar.php';

// Database connection to fetch product variations
$database = new Database();
$conn = $database->getConnection();

// Fetch product details and variations from the database
$product_id = 7; // For example, the binder product ID is 7
$query = "SELECT * FROM product_variations WHERE product_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$variations = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Close connection
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
    <title>Binder Product Page</title>
    <link rel="stylesheet" href="/final/items/binder/binder.css" />
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
                        <img id="mainImage1" class="slider-image active" src="/final/imgs/school supplies/binder.jpg"
                            alt="Product Image" />
                    </div>
                </div>

                <div class="product-info">
                    <h1 class="product-title">B5 Binder Notebook</h1>
                    <p class="product-price" id="productPrice">₱ 70.00</p>

                    <!-- Color Options -->
                    <div class="product-options">
                        <h3>Colors</h3>
                        <div class="color-options">
                            <?php foreach ($variations as $variation): ?>
                                <?php if ($variation['variation_type'] == 'color'): ?>
                                    <button class="color-option" 
                                            data-color="<?= htmlspecialchars($variation['variation_value']) ?>" 
                                            data-image="/final/imgs/school supplies/<?= strtolower($variation['variation_value']) ?>-binder.jpg"
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
                            <button id="decrease">-</button>
                            <input type="number" id="quantity" name="quantity" value="1" min="1" />
                            <button id="increase">+</button>
                        </div>
                        <p id="stock-info"></p> <!-- To show available stock -->
                    </div>

                    <div class="product-buttons">
                        <form method="POST" action="">
                            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_id); ?>">
                            <input type="hidden" name="product_name" value="B5 Binder Notebook">
                            <input type="hidden" name="product_price" value="70.00">
                            <input type="hidden" name="product_image" value="/final/imgs/school supplies/binder.jpg">
                            <input type="hidden" name="selected_size" value="B5"> <!-- Adjust as necessary -->
                            <button type="submit" class="add-to-cart">Add to Cart</button>
                            <button type="button" class="buy-now">Buy Now</button>
                        </form>
                    </div>
                </div>
            </section>

            <!-- Seller Info -->
            <section class="seller-info-section">
                <div class="seller-info">
                    <img src="/final/imgs/sellerpics/deptshirt.avif" alt="Seller Profile Pic" class="seller-logo" />
                    <div class="seller-details">
                        <h2 class="seller-name">Colleen Perez</h2>
                        <div class="seller-buttons">
                            <a href="/final/contact/contact_colleen.php"><button class="chat-now">Contact us</button></a>
                            <a href="/final/view_shop/view_shop_colleen.php" class="view-shop">View Shop</a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Product Description -->
            <section class="product-description">
                <h2>Product Description</h2>
                <p>26 holes</p>
                <p>Product Size: B5(275*215mm)</p>
                <p>Number of Sheets: 60 Sheets</p>
            </section>
        </div>
    </main>

    <!-- JavaScript for Color Selection and Quantity -->
    <script>
        const colorButtons = document.querySelectorAll('.color-option');
        const mainImage = document.getElementById('mainImage1');
        const quantityInput = document.getElementById('quantity');
        const stockInfo = document.getElementById('stock-info');
        const selectedSizeInput = document.querySelector('input[name="selected_size"]');
        const productImageInput = document.querySelector('input[name="product_image"]');

        colorButtons.forEach(button => {
            button.addEventListener('click', function () {
                const selectedImage = this.getAttribute('data-image');
                const selectedStock = this.getAttribute('data-stock');
                mainImage.src = selectedImage;
                quantityInput.max = selectedStock;
                stockInfo.textContent = 'Available stock: ' + selectedStock;

                // Optional: Add a class to highlight the selected button
                colorButtons.forEach(btn => btn.classList.remove('selected'));
                this.classList.add('selected');

        // Reset the quantity to 1 when changing color
        quantityInput.value = 1;
      });
    });
  </script>
</body>

</html>