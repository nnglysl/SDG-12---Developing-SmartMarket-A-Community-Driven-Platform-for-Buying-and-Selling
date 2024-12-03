<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>This is header</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    <link rel="stylesheet" href="../css/nav.css" />
</head>
<body>
<header>
        <img src="../imgs/mainpagelogo.png" alt="Logo" class="logo" />

        <ul class="nav">
            <li><a href="/final/home/home.php">HOME</a></li>
            <li><a href="/final/shop/shop.php">SHOP</a></li>
        </ul>

        <!-- Search Bar -->
        <div class="search-container">
            <input
            type="text"
            id="product-search"
            class="search-bar"
            name="query"
            placeholder="Search..."
            />
            <button type="submit" class="search-button">
            <i class="bx bx-search"></i>
            </button>
            <ul id="dropdown-results" class="dropdown-results"></ul>
        </div>
        <div class="result-container">
            <ul id="results"></ul>
        </div>
        <script src="/javascript/searchbar.js"></script>

        <div class="navicon">
            <a href="../profile/profile.php"><i class="bx bx-user"></i></a>
            <a href="#"><i class="bx bx-cart"></i></a>
        </div>
        </header>
</body>
</html>