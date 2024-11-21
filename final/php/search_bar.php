<?php
// Initialize results variable
$results = "";

// Check if the form has been submitted
if (isset($_POST['submit'])) {
    $searchTerm = trim($_POST['search']);
    $searchTerm = $conn->real_escape_string($searchTerm); // Sanitize user input

    // Query the database for matching results (search by name)
    $query = "SELECT * FROM products WHERE name LIKE '%$searchTerm%'";
    $result = $conn->query($query);

    // Check if there are results
    if ($result->num_rows > 0) {
        $results .= '<ul>';
        while ($row = $result->fetch_assoc()) {
            // Get the product page link from the database
            $productLink = htmlspecialchars($row['product_page_link']); // This retrieves the stored link
            $results .= '<li><a href="' . $productLink . '">' . htmlspecialchars($row['name']) . '</a></li>';
        }
        $results .= '</ul>';
    } else {
        $results .= '<p>No results found for "' . htmlspecialchars($searchTerm) . '"</p>';
    }
}

$conn->close(); // Close the database connection
?>