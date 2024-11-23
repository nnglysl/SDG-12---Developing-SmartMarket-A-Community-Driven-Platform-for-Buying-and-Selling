<?php

include '../php/search_bar.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Apparel Store</title>
    <link rel="stylesheet" href="/final/search/search_view.css" />
    <link href="https://fonts.googleapis.com/css2?family=Nanum+Gothic:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" />
    <link rel="stylesheet" href="/final/css/nav.css">
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
    </header>

    <main>
        <h3>Search result for '<?php echo htmlspecialchars($search_query); ?>'</h3>

        <form method="get" action="/final/search/search_view.php">

            <input type="hidden" name="search" value="<?php echo htmlspecialchars($search_query); ?>">

            <div class="filter-bar">
                <div class="filter-item">
                    <label for="sort">Sort By:</label>
                    <select name="sort" id="sort">
                        <option value="price-high-low" <?php echo $sort == 'price-high-low' ? 'selected' : ''; ?>>Price:
                            High to Low</option>
                        <option value="price-low-high" <?php echo $sort == 'price-low-high' ? 'selected' : ''; ?>>Price:
                            Low to High</option>
                    </select>
                </div>

                <div class="filter-item">
                    <label for="condition">Condition:</label>
                    <select name="condition" id="condition">
                        <option value="all" <?php echo $condition == 'all' ? 'selected' : ''; ?>>All</option>
                        <option value="new" <?php echo $condition == 'new' ? 'selected' : ''; ?>>New</option>
                        <option value="like-new" <?php echo $condition == 'like-new' ? 'selected' : ''; ?>>Like-New
                        </option>
                        <option value="lightly-used" <?php echo $condition == 'lightly-used' ? 'selected' : ''; ?>>
                            Lightly-used</option>
                        <option value="heavily-used" <?php echo $condition == 'heavily-used' ? 'selected' : ''; ?>>
                            Heavily-used</option>
                    </select>
                </div>

                <div class="filter-item">
                    <label for="price-range">Price Range:</label>
                    <div>
                        <input type="number" name="min_price" id="min-price" placeholder="Min Price"
                            value="<?php echo htmlspecialchars($min_price); ?>">
                        <input type="number" name="max_price" id="max-price" placeholder="Max Price"
                            value="<?php echo htmlspecialchars($max_price); ?>">
                    </div>
                </div>
                <div class="filter-buttons">
                    <button type="submit" class="btn-apply">Apply Filters</button>
                    <button type="button" class="btn-clear-all" onclick="clearAllFilter()">Clear All</button>
                </div>
            </div>
        </form>


        <div class="result-container">
            <?php if (!empty($results)) { ?>
                <?php foreach ($results as $product) { ?>
                    <div class="product">
                        <img src="<?php echo htmlspecialchars($product['image_path']); ?>" alt="Product Image">
                        <h4><?php echo htmlspecialchars($product['product_name']); ?></h4>
                        <p><?php echo htmlspecialchars($product['description']); ?></p>
                        <p class="price">PHP <?php echo htmlspecialchars(number_format($product['price'], 2)); ?></p>
                        <p class="condition"><?php echo htmlspecialchars($product['condition']); ?></p>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p>No results found.</p>
            <?php } ?>
        </div>
    </main>

    <script>
        function clearAllFilter() {
            document.getElementById('sort').value = 'best-match';
            document.getElementById('condition').value = 'new';
            document.getElementById('min-price').value = '';
            document.getElementById('max-price').value = '';

            const url = new URL(window.location.href);
            url.searchParams.delete('sort');
            url.searchParams.delete('condition');
            url.searchParams.delete('min_price');
            url.searchParams.delete('max_price');

            // Preserve the search query
            const searchQuery = url.searchParams.get('search');
            window.location.href = `/final/search/search_view.php?search=${searchQuery}`;
        }

    </script>

</body>

</html>