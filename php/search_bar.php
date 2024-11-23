<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/final/db/dbcon.php';

$database = new Database();
$conn = $database->getConnection();

$search_query = $_GET['search'] ?? '';
$sort = $_GET['sort'] ?? 'best-match';
$condition = $_GET['condition'] ?? 'all';
$min_price = $_GET['min_price'] ?? '';
$max_price = $_GET['max_price'] ?? '';

$results = fetchProducts($conn, $search_query, $sort, $condition, $min_price, $max_price);

function fetchProducts($conn, $search_query, $sort, $condition, $min_price, $max_price)
{
    $query = "SELECT * FROM products WHERE product_name LIKE ?";

    if (!empty($condition) && $condition !== 'all') {
        $query .= " AND `condition` = ?";
    }

    if ($min_price != '' && $max_price != '') {
        $query .= " AND price BETWEEN ? AND ?";
    }

    if ($sort == 'price-high-low') {
        $query .= " ORDER BY price DESC";
    } elseif ($sort == 'price-low-high') {
        $query .= " ORDER BY price ASC";
    }

    $stmt = $conn->prepare($query);

    $search_query = '%' . $search_query . '%';

    if (!empty($condition) && $condition !== 'all' && $min_price !== '' && $max_price !== '') {
        $stmt->bind_param("ssdd", $search_query, $condition, $min_price, $max_price);
    } elseif (!empty($condition) && $condition !== 'all') {
        $stmt->bind_param("ss", $search_query, $condition);
    } elseif ($min_price !== '' && $max_price !== '') {
        $stmt->bind_param("sdd", $search_query, $min_price, $max_price);
    } else {
        $stmt->bind_param("s", $search_query);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    $stmt->close();

    return $products;
}
?>