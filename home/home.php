<?php

require_once '../db/dbcon.php';
include '../php/search_bar.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Apparel Store</title>
    <link rel="stylesheet" href="../home/home.css" />
    <link href="https://fonts.google.com/specimen/Nanum+Gothic" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" />
    <link rel="stylesheet" href="../css/nav.css" />
</head>

<body>
    <header>
        <img src="../imgs/mainpagelogo.png" alt="Logo" class="logo" />

        <ul class="nav">
            <li><a href="../home/home.php">HOME</a></li>
            <li><a href="../shop/shop.php">SHOP</a></li>
        </ul>

        <div class="search-container">
            <form method="post" action="/final/search/search_view.php">
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
            <a href="../profile/profile.php"><i class="bx bx-user"></i></a>
            <a href="#"><i class="bx bx-cart"></i></a>
        </div>
    </header>

    <section id="home" class="banner">
        <h1>Preloved and</h1>
        <p>Brand New Items</p>

        <a href="../shop/shop.php" class="btn">Shop Now <i class="bx bx-right-arrow-alt"></i></a>
    </section>

    <section id="shop" class="shop-section">
        <div class="products">
            <!-- First Row of Products -->
            <div class="product">
                <a href="../items_uniforms/peunif/peunif.php">
                    <img src="../imgs/uniforms/peunif.png" alt="PE Uniform" />
                    <h3>Preloved PE Uniform Set</h3>
                    <p>₱ 400.00</p>
                </a>
            </div>
            <div class="product">
                <a href="../items_uniforms/collarpin/collarpin.php">
                    <img src="../imgs/uniforms/collarpin.jfif" alt="Collar Pin" />
                    <h3>University Collar Pin</h3>
                    <p>₱ 50.00</p>
                </a>
            </div>
            <div class="product">
                <a href="../items/calcu/calcu.php">
                    <img src="../imgs/school supplies/calcu.png" alt="Calculator" />
                    <h3>Second hand Casio Scientific Calculator</h3>
                    <p>₱ 500.00</p>
                </a>
            </div>
            <div class="product">
                <a href="../items_deptshirt/cics/cics.php">
                    <img src="../imgs/department shirts/cics.png" alt="CICS Department Shirt" />
                    <h3>CICS Department Shirt</h3>
                    <p>₱ 500.00</p>
                </a>
            </div>
        </div>
    </section>
</body>

</html>