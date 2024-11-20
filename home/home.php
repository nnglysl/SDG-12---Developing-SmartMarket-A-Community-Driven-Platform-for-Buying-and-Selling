<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Apparel Store</title>
    <link rel="stylesheet" href="home.css" />
    <link
      href="https://fonts.google.com/specimen/Nanum+Gothic"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://unpkg.com/boxicons@latest/css/boxicons.min.css"
    />
    <link rel="stylesheet" href="../css/nav.css" />
  </head>
  <body>
  <?php include('../header/header.php'); ?>

    <section id="home" class="banner">
      <h1>Preloved and</h1>
      <p>Brand New Items</p>

      <a href="/shop/school_supplies/school supplies.html" class="btn"
        >Shop Now <i class="bx bx-right-arrow-alt"></i
      ></a>
    </section>

    <section id="shop" class="shop-section">
      <div class="products">
        <!-- First Row of Products -->
        <div class="product">
          <a href="../items_uniforms/peunif/peunif.html">
            <img src="../imgs/uniforms/peunif.png" alt="PE Uniform" />
            <h3>PE Uniform Set</h3>
            <p>₱ 500.00-₱ 650.00</p>
          </a>
        </div>
        <div class="product">
          <a href="..items_uniforms/collarpin/collarpin.html">
            <img src="../imgs/uniforms/collarpin.jfif" alt="Collar Pin" />
            <h3>University Collar Pin</h3>
            <p>₱ 80.00</p>
          </a>
        </div>
        <div class="product">
          <a href="../items/calcu/calcu.html">
            <img src="../imgs/school supplies/calcu.png" alt="Calculator" />
            <h3>Casio Scientific Calculator</h3>
            <p>₱ 500.00</p>
          </a>
        </div>
        <div class="product">
          <a href="../items_deptshirt/cics/cics.html">
            <img
              src="../imgs/department shirts/deptshirt.png"
              alt="CICS Department Shirt"
            />
            <h3>CICS Department Shirt</h3>
            <p>₱ 500.00</p>
          </a>
        </div>
      </div>
    </section>
  </body>
</html>
