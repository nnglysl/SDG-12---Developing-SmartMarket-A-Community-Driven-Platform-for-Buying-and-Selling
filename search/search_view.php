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
        <div class="navicon">
            <a href="/final/profile/profile.php"><i class="bx bx-user"></i></a>
            <a href="#"><i class="bx bx-cart"></i></a>
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

                <div class="filter-item price-range-container">
                    <h4>Price Range</h4>
                    <div class="price-range-inputs">
                        <div class="price-input">
                            <label for="min-price">Min</label>
                            <input type="number" name="min_price" id="min-price" placeholder="Min Price"
                                value="<?php echo htmlspecialchars($min_price); ?>">
                        </div>
                        <span>–</span>
                        <div class="price-input">
                            <label for="max-price">Max</label>
                            <input type="number" name="max_price" id="max-price" placeholder="Max Price"
                                value="<?php echo htmlspecialchars($max_price); ?>">
                        </div>
                    </div>
                    <input type="range" id="price-slider" min="0" max="10000" step="100" value="5000" />
                </div>

                <div class="filter-buttons">
                    <button type="submit" class="btn-apply">Apply</button>
                    <button type="button" class="btn-clear-all" onclick="clearAllFilter()">Clear All</button>
                </div>
            </div>
        </form>


        <div class="result-container">
            <?php if (!empty($results)) { ?>
                <?php foreach ($results as $product) { ?>
                    <div class="product">
                        <a href="<?php echo htmlspecialchars($product['item_path']); ?>"><img
                                src="<?php echo htmlspecialchars($product['image_path']); ?>" alt="Product Image"></a>
                        <h4><?php echo htmlspecialchars($product['product_name']); ?></h4>
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
        const minInput = document.getElementById("min-price");
        const maxInput = document.getElementById("max-price");
        const slider = document.getElementById("price-slider");

        slider.addEventListener("input", () => {
            const value = parseInt(slider.value, 10);
            minInput.value = Math.max(value - 2000, 0);
            maxInput.value = value;
        });

        [minInput, maxInput].forEach(input => {
            input.addEventListener("input", () => {
                const min = parseInt(minInput.value, 10) || 0;
                const max = parseInt(maxInput.value, 10) || 0;
                if (min < max) {
                    slider.value = max;
                }
            });
        });

        function clearAllFilter() {
            document.getElementById('sort').value = 'best-match';
            document.getElementById('condition').value = 'new';
            document.getElementById('min-price').value = '';
            document.getElementById('max-price').value = '';
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.delete('sort');
            urlParams.delete('min_price');
            urlParams.delete('max_price');
            window.location.href = window.location.pathname;
        }
    </script>

</body>

</html>