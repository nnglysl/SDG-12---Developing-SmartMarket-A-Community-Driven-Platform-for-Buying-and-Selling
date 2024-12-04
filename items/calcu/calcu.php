<?php
include '../../db/dbcon.php';
include '../../php/search_bar.php';

// Database connection to fetch product variations
$database = new Database();
$conn = $database->getConnection();

// Fetch product details and variations from the database
$product_id = 4; // For example, the calculator product ID is 4
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
    <title>Calcu Product Page</title>
    <link rel="stylesheet" href="/final/items/calcu/calcu.css" />
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
                        <img id="mainImage1" class="slider-image active" src="/final/imgs/school supplies/calcu.png"
                            alt="Product Image" />
                    </div>
                </div>

                <div class="product-info">
                    <h1 class="product-title">Second Hand Casio Scientific Calculator</h1>
                    <p class="product-price" id="productPrice">₱ 500.00</p>

                    <!-- Size Options -->
                    <div class="product-options">
                        <h3>Sizes</h3>
                        <div class="size-options">
                            <?php foreach ($variations as $variation): ?>
                                <?php if ($variation['variation_type'] == 'size'): ?>
                                    <button class="size-option" 
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
                            <button id="decrease">-</button>
                            <input type="number" id="quantity" name="quantity" value="1" min="1" />
                            <button id="increase">+</button>
                        </div>
                        <p id="stock-info">Please select a size.</p> <!-- To show available stock -->
                    </div>

                    <div class="product-buttons">
                        <form method="POST" action="">
                            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_id); ?>">
                            <input type="hidden" name="product_name" value="Second Hand Casio Scientific Calculator">
                            <input type="hidden" name="product_price" value="500">
                            <input type="hidden" name="product_image" value="/final/imgs/school supplies/calcu.png">
                            <input type="hidden" id="selectedSizeInput" name="selected_size" value="">
                            <input type="hidden" id="quantityInput" name="quantity" value="1">
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
                <p>Second Hand Scientific Calculator</p>
            </section>
        </div>
    </main>

    <!-- JavaScript for Size Selection and Quantity -->
    <script>
        const sizeButtons = document.querySelectorAll('.size-option');
        const quantityInput = document.getElementById('quantity');
        const stockInfo = document.getElementById('stock-info');
        const selectedSizeInput = document.getElementById('selectedSizeInput');

        sizeButtons.forEach(button => {
            button.addEventListener('click', function () {
                const selectedStock = this.getAttribute('data-stock');
                stockInfo.textContent = 'Available stock: ' + selectedStock;

                // Update the maximum quantity based on selected stock
                quantityInput.max = selectedStock;

                // Highlight the selected size button
                sizeButtons.forEach(btn => btn.classList.remove('selected'));
                this.classList.add('selected');

                // Set the selected size in the hidden input
                selectedSizeInput.value = this.getAttribute('data-size');

                // Reset quantity to 1 when changing size
                quantityInput.value = 1;
            });
        });

        document.getElementById("increase").addEventListener("click", function () {
            let maxStock = parseInt(quantityInput.max);
            if (parseInt(quantityInput.value) < maxStock) {
                quantityInput.value = parseInt(quantityInput.value) + 1;
            }
        });

        document.getElementById("decrease").addEventListener("click", function () {
            if (quantityInput.value > 1) {
                quantityInput.value = parseInt(quantityInput.value) - 1;
            }
        });
    </script>
</body>

</html>