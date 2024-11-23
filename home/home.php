<?php

<<<<<<< HEAD
include '../db/dbcon.php';
include '../php/search_bar.php';
=======
    include '../db/dbconn.php'; // Include your database connection
    include '../php/search_bar.php';
>>>>>>> d4b3911f02e1ce4b4ec13ff391a248cfa6225f7e

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Apparel Store</title>
    <link rel="stylesheet" href="/final/home/home.css" />
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
<<<<<<< HEAD
            <form method="get" action="/final/search/search_view.php">
                <div class="search-bar-wrapper">
                    <input type="text" name="search" class="search-bar" id="search" placeholder="Search"
                        value="<?php echo htmlspecialchars($search_query); ?>" required>
                    <button type="submit" class="search-button">
=======
            <form method="post" action="/final/home/home.php">
                <div class="search-bar-wrapper">
                    <input type="text" name="search" class="search-bar" id="search" placeholder="Search" required>
                    <button type="submit" name="submit" class="search-button">
>>>>>>> d4b3911f02e1ce4b4ec13ff391a248cfa6225f7e
                        <i class="bx bx-search"></i>
                    </button>
                </div>
            </form>
<<<<<<< HEAD
=======

            <!-- Result Container: Initially empty, shown only when there are results -->
            <?php if (!empty($results)) { ?>
                <div class="result-container">
                    <?php echo $results; ?>
                </div>
            <?php } ?>
>>>>>>> d4b3911f02e1ce4b4ec13ff391a248cfa6225f7e
        </div>

        <div class="navicon">
            <a href="/final/profile/profile.php"><i class="bx bx-user"></i></a>
            <a href="#"><i class="bx bx-cart"></i></a>
        </div>
    </header>

    <section id="home" class="banner">
        <h1>Preloved and</h1>
        <p>Brand New Items</p>

        <a href="/final/shop/shop.php" class="btn">Shop Now <i class="bx bx-right-arrow-alt"></i></a>
    </section>

    <section id="shop" class="shop-section">
        <div class="products">
            <!-- First Row of Products -->
            <div class="product">
                <a href="/final/items_uniforms/peunif/peunif.php">
                    <img src="/final/imgs/uniforms/peunif.png" alt="PE Uniform" />
                    <h3>Preloved PE Uniform Set</h3>
                    <p>₱ 400.00</p>
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
                <a href="/final/items/calcu/calcu.php">
                    <img src="/final/imgs/school supplies/calcu.png" alt="Calculator" />
                    <h3>Second hand Casio Scientific Calculator</h3>
                    <p>₱ 500.00</p>
                </a>
            </div>
            <div class="product">
                <a href="/final/items_deptshirt/cics/cics.php">
                    <img src="/final/imgs/department shirts/cics.png" alt="CICS Department Shirt" />
                    <h3>CICS Department Shirt</h3>
                    <p>₱ 500.00</p>
                </a>
            </div>
        </div>
    </section>
</body>

</html>