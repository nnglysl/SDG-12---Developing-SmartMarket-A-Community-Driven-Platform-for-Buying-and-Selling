<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/final/db/dbcon.php';

class ProductSearch
{
    private $conn;
    private $search_query;
    private $sort;
    private $condition;
    private $min_price;
    private $max_price;

    public function __construct($conn, $search_query = '', $sort = 'best-match', $condition = 'all', $min_price = '', $max_price = '')
    {
        $this->conn = $conn;
        $this->search_query = $search_query;
        $this->sort = $sort;
        $this->condition = $condition;
        $this->min_price = $min_price;
        $this->max_price = $max_price;
    }

    public function fetchProducts()
    {
        $query = "SELECT * FROM products WHERE product_name LIKE ?";

        if (!empty($this->condition) && $this->condition !== 'all') {
            $query .= " AND `condition` = ?";
        }

        if ($this->min_price != '' && $this->max_price != '') {
            $query .= " AND price BETWEEN ? AND ?";
        }

        if ($this->sort == 'price-high-low') {
            $query .= " ORDER BY price DESC";
        } elseif ($this->sort == 'price-low-high') {
            $query .= " ORDER BY price ASC";
        }

        $stmt = $this->conn->prepare($query);

        $search_query = '%' . $this->search_query . '%';

        if (!empty($this->condition) && $this->condition !== 'all' && $this->min_price !== '' && $this->max_price !== '') {
            $stmt->bind_param("ssdd", $search_query, $this->condition, $this->min_price, $this->max_price);
        } elseif (!empty($this->condition) && $this->condition !== 'all') {
            $stmt->bind_param("ss", $search_query, $this->condition);
        } elseif ($this->min_price !== '' && $this->max_price !== '') {
            $stmt->bind_param("sdd", $search_query, $this->min_price, $this->max_price);
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
}

$database = new Database();
$conn = $database->getConnection();

$search_query = $_GET['search'] ?? '';
$sort = $_GET['sort'] ?? 'best-match';
$condition = $_GET['condition'] ?? 'all';
$min_price = $_GET['min_price'] ?? '';
$max_price = $_GET['max_price'] ?? '';

$productSearch = new ProductSearch($conn, $search_query, $sort, $condition, $min_price, $max_price);
$results = $productSearch->fetchProducts();
?>
