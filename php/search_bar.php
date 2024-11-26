<?php

require_once '../db/dbcon.php';

$results = "";

// Create an instance of the Database class
$db = new Database();
$conn = $db->getConnection();


if (isset($_POST['submit'])) {

    $searchTerm = trim($_POST['search']);
    $searchTerm = $conn->real_escape_string($searchTerm);


    $query = "SELECT * FROM products WHERE name LIKE '%$searchTerm%'";
    $result = $conn->query($query);


    if ($result->num_rows > 0) {
        $results .= '<ul>';
        while ($row = $result->fetch_assoc()) {

            $productLink = htmlspecialchars($row['product_page_link']);
            $results .= '<li><a href="' . $productLink . '">' . htmlspecialchars($row['name']) . '</a></li>';
        }
        $results .= '</ul>';
    } else {
        $results .= '<p>No results found for "' . htmlspecialchars($searchTerm) . '"</p>';
    }
}


$conn->close();
?>