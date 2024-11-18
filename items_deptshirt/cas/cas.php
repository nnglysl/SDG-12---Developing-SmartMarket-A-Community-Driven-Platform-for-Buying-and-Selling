<?php

include '../db/dbconn.php';

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CAS Product Page</title>
    <link rel="stylesheet" href="/final/items_deptshirt/cas/cas.css" />
    <link href="https://fonts.google.com/specimen/Nanum+Gothic" rel="stylesheet"/>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css"/>
    <link rel="stylesheet" href="/final/css/nav.css" />
  </head>
  <body>
    <header>
      <img src="/final/imgs/mainpagelogo.png" alt="Logo" class="logo" />
      <ul class="nav">
        <li><a href="/final/home/home.php">HOME</a></li>
        <li><a href="/final/shop/shop.php">SHOP</a></li>
      </ul>
      <!-- Search Bar Container -->
    <div class="search-container">
    <form method="post" action="/finalp/home/home.php">
        <label for="search">Search</label>
        <div class="search-bar-wrapper">
            <input type="text" name="search" class="search-bar" id="search" placeholder="Search" required>
            <button type="submit" name="submit" class="search-button">
                <i class="bx bx-search"></i>
            </button>
        </div>
    </form>
    <!-- Result Container -->
    <div class="result-container">
        <?php if (!empty($results)) { echo $results; } ?>
    </div>
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
                <img
                    id="mainImage1"
                    class="slider-image active"
                    src="/finalp/imgs/department shirts/cas.png"
                    alt="Product Image"
                />
                </div>
            </div>

          <div class="product-info">
            <h1 class="product-title">CAS Department Shirt</h1>
            <p class="product-price">₱ 500</p>

            <div class="product-options">
              <h3>Sizes</h3>
              <div class="size-options">
                <button>Small</button>
                <button>Medium</button>
                <button>Large</button>
              </div>
            </div>

            <div class="quantity-selector">
              <h4>Quantity</h4>
              <div class="buttons">
                <button id="decrease">-</button>
                <input type="number" id="quantity" value="1" min="1" />
                <button id="increase">+</button>
              </div>
            </div>

            <!-- js for quantity-->
            <script>
              document
                .getElementById("increase")
                .addEventListener("click", function () {
                  let quantityInput = document.getElementById("quantity");
                  quantityInput.value = parseInt(quantityInput.value) + 1;
                });

              document
                .getElementById("decrease")
                .addEventListener("click", function () {
                  let quantityInput = document.getElementById("quantity");
                  if (quantityInput.value > 1) {
                    quantityInput.value = parseInt(quantityInput.value) - 1;
                  }
                });
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
            <img
              src="/final/imgs/sellerpics/rgo.jfif"
              alt="Seller Profile Pic"
              class="seller-logo"
            />
            <div class="seller-details">
              <h2 class="seller-name">Resource Generation Office</h2>
              <div class="seller-buttons">
                <a href="/final/contact/contact_rgo.php"><button class="chat-now">Contact us</button></a>
                <a href="/final/view_shop/view_shop_rgo.php" class="view-shop"
                  >View Shop</a
                >
              </div>
            </div>
          </div>
        </section>


        <!-- Product Description -->
        <section class="product-description">
          <h2>Product Description</h2>
          <p>
          CAS Department Shirt 
          Small - W:14 L:26
          Medium - W:20 L:27 
          Large - W:21 L:28 
          </p>
        </section>
      </div>
    </main>
  </body>
</html>
