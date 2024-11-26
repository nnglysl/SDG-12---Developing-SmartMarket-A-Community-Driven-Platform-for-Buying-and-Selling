<?php
$search_query = $_POST['search'] ?? '';
$sort = $_GET['sort'] ?? 'best-match';
$condition = $_GET['condition'] ?? 'new';
$min_price = $_GET['min_price'] ?? '';
$max_price = $_GET['max_price'] ?? '';

$results = fetchProducts($search_query, $sort, $condition, $min_price, $max_price);

function fetchProducts($search_query, $sort, $condition, $min_price, $max_price)
{
    $query = "SELECT * FROM products WHERE name LIKE '%$search_query%'";

    if ($condition != 'new') {
        $query .= " AND condition = '$condition'";
    }

    if ($min_price != '' && $max_price != '') {
        $query .= " AND price BETWEEN '$min_price' AND '$max_price'";
    }

    if ($sort == 'recent') {
        $query .= " ORDER BY created_at DESC";
    } elseif ($sort == 'price-high-low') {
        $query .= " ORDER BY price DESC";
    } elseif ($sort == 'price-low-high') {
        $query .= " ORDER BY price ASC";
    }

    return [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Apparel Store</title>
    <link rel="stylesheet" href="/final/search/search_view.css" />
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
            <a href="/profile/profile.php"><i class="bx bx-user"></i></a>
            <a href="#"><i class="bx bx-cart"></i></a>
        </div>
    </header>

    <h3>Search result for '<?php echo htmlspecialchars($search_query); ?>'</h3>

    <div class="filter-bar">
        <div class="filter-item">
            <select id="sort" onchange="applyFilters()">
                <option value="best-match" <?php echo $sort == 'best-match' ? 'selected' : ''; ?>>Sort: Best Match
                </option>
                <option value="recent" <?php echo $sort == 'recent' ? 'selected' : ''; ?>>Sort: Recent</option>
                <option value="price-high-low" <?php echo $sort == 'price-high-low' ? 'selected' : ''; ?>>Sort: Price -
                    High to Low</option>
                <option value="price-low-high" <?php echo $sort == 'price-low-high' ? 'selected' : ''; ?>>Sort: Price -
                    Low to High</option>
            </select>
        </div>

        <!-- Price Filter -->
        <div class="dropdown">
            <button class="dropdown-toggle" id="priceDropdown" data-toggle="dropdown">
                PHP 0 - PHP 0 <?php echo $min_price . ' - PHP ' . $max_price; ?>
            </button>
            <div class="dropdown-menu" aria-labelledby="priceDropdown">
                <div class="price-range">
                    <label for="min-price">Minimum</label>
                    <input type="number" id="min-price" value="<?php echo $min_price; ?>" placeholder="PHP 0">
                    <span>-</span>
                    <label for="max-price">Maximum</label>
                    <input type="number" id="max-price" value="<?php echo $max_price; ?>" placeholder="PHP 0">
                </div>
                <button class="btn-apply" onclick="applyFilters()">Apply</button>
            </div>
        </div>

        <!-- Condition Filter and Clear All Button -->
        <div class="filter-item condition-container">
            <select id="condition" onchange="applyFilters()">
                <option value="new" <?php echo $condition == 'new' ? 'selected' : ''; ?>>Condition</option>
                <option value="new" <?php echo $condition == 'new' ? 'selected' : ''; ?>>Brand New</option>
                <option value="like-new" <?php echo $condition == 'like-new' ? 'selected' : ''; ?>>Like New</option>
                <option value="lightly-used" <?php echo $condition == 'lightly-used' ? 'selected' : ''; ?>>Lightly Used
                </option>
                <option value="heavily-used" <?php echo $condition == 'heavily-used' ? 'selected' : ''; ?>>Heavily Used
                </option>
            </select>
        </div>
        <div class="clear-btn">
            <button class="btn-clear-all" onclick="clearAllFilters()">Clear All</button>
        </div>
    </div>

    <script>
        function applyFilters() {
            var sort = document.getElementById('sort').value;
            var condition = document.getElementById('condition').value;
            var min_price = document.getElementById('min-price').value;
            var max_price = document.getElementById('max-price').value;
            var search = document.getElementById('search').value;

            var url = new URL(window.location.href);
            url.searchParams.set('search', search);
            url.searchParams.set('sort', sort);
            url.searchParams.set('condition', condition);
            url.searchParams.set('min_price', min_price);
            url.searchParams.set('max_price', max_price);

            window.location.href = url.toString(); // Redirect to the same page with updated filters
        }

        function clearAllFilters() {
            document.getElementById('sort').value = 'best-match';
            document.getElementById('condition').value = 'new';
            document.getElementById('min-price').value = '';
            document.getElementById('max-price').value = '';
            document.getElementById('search').value = '';

            var url = new URL(window.location.href);
            url.searchParams.delete('search');
            url.searchParams.delete('sort');
            url.searchParams.delete('condition');
            url.searchParams.delete('min_price');
            url.searchParams.delete('max_price');

            window.location.href = url.toString();
        }
    </script>

</body>

</html>