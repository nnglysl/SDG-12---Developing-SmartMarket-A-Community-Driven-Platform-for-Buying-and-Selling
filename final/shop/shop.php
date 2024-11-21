<?php

  include '../db/dbconn.php'; // Include your database connection
  include '../php/search_bar.php';

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>About us</title>
    <link rel="stylesheet" href="/final/shop/shop.css" />
    <link
      href="https://fonts.google.com/specimen/Nanum+Gothic"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://unpkg.com/boxicons@latest/css/boxicons.min.css"
    />
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
      <form method="post" action="/final/home/home.php">
        <div class="search-bar-wrapper">
          <input type="text" name="search" class="search-bar" id="search" placeholder="Search" required>
          <button type="submit" name="submit" class="search-button">
            <i class="bx bx-search"></i>
          </button>
        </div>
      </form>

      <!-- Result Container: Initially empty, shown only when there are results -->
      <?php if (!empty($results)) { ?>
        <div class="result-container">
          <?php echo $results; ?>
        </div>
      <?php } ?>
    </div>

      <div class="navicon">
        <a href="/final/profile/profile.php"><i class="bx bx-user"></i></a>
        <a href="#"><i class="bx bx-cart"></i></a>
      </div>
    </header>

    <!-- Shop Section -->
    <section id="shop" class="shop-section-first" aria-labelledby="shop-heading">
      <div class="products">
        <!-- First Row of Products -->
        <div class="product">
          <a href="/final/items_deptshirt/cics/cics.php">
            <img
              src="/final/imgs/department shirts/cics.png"
              alt="CICS Department Shirt"
            />
            <h3>CICS Department Shirt</h3>
            <p>₱ 500.00</p>
          </a>
        </div>
        <div class="product">
          <a href="/final/items_uniforms/collarpin/collarpin.php">
            <img src="/final/imgs/uniforms/collarpin.jfif" alt="Collar Pin" />
            <h3>University Collar Pin</h3>
            <p>₱ 50.00</p>
          </a>
        </div>
        <div class="product">
          <a href="/final/items_deptshirt/cas/cas.php">
            <img
              src="/final/imgs/department shirts/cas.png"
              alt="CAS Department Shirt"
            />
            <h3>CAS Department Shirt</h3>
            <p>₱ 500.00</p>
          </a>
        </div>
        
      </div>
    </section>

    <section id="shop" class="shop-section" aria-labelledby="shop-heading">
      <div class="products">
        <!-- Second Row of Products -->
        <div class="product">
          <a href="/final/items/calcu/calcu.php">
            <img src="/final/imgs/school supplies/calcu.png" alt="Calculator" />
            <h3>Second hand Casio Scientific Calculator</h3>
            <p>₱ 500.00</p>
          </a>
        </div>
        <div class="product">
          <a href="/final/items/idlace/idlace.php">
            <img src="/final/imgs/school supplies/idlace.jpg" alt="ID Lace" />
            <h3>ID Lace</h3>
            <p>₱ 50.00</p>
          </a>
        </div>
       
        <div class="product">
          <a href="/final/items/binder/binder.php">
            <img src="/final/imgs/school supplies/binder.jpg" alt="Binder" />
            <h3>B5 Binder Notebook</h3>
            <p>₱ 70.00</p>
          </a>
        </div>
      </div>
    </section>

    <section id="shop" class="shop-section" aria-labelledby="shop-heading">
      <div class="products">
        <!-- Third Row of Products -->
        <div class="product">
          <a href="/final/items_uniforms/peunif/peunif.php">
            <img src="/final/imgs/uniforms/peunif.png" alt="PE Uniform" />
            <h3>Preloved PE Uniform Set</h3>
            <p>₱ 400.00</p>
          </a>
        </div>
        <div class="product">
          <a href="/final/items_uniforms/blouse/blouse.php">
            <img src="/final/imgs/uniforms/blouse.jpg" alt="Blouse" />
            <h3>Preloved College Blouse</h3>
            <p>₱ 250.00</p>
          </a>
        </div>
        <div class="product">
          <a href="/final/items_deptshirt/cabe/cabe.php">
            <img
              src="/final/imgs/department shirts/cabe.png" alt="CABE Department Shirt"/>
            <h3>CABE Department Shirt</h3>
            <p>₱ 500.00</p>
          </a>
        </div>
      </div>
    </section>
  </body>
</html>
