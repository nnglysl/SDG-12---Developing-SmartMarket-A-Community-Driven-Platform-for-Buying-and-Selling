<?php

require_once '../php/search_bar.php';

$query = "SELECT * FROM products ORDER BY RAND() LIMIT 3"; // Fetch random products
$result = mysqli_query($conn, $query);

?>
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
            <li><a href="../home/home.php">HOME</a></li>
            <li><a href="../shop/shop.php">SHOP</a></li>
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
</body>
</html>