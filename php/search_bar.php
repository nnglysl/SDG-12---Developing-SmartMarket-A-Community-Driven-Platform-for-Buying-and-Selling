<?php

// Database connection 
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'shop';

//Create connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form has been submitted
if (isset($_POST['submit'])) {
    $searchTerm = trim($_POST['search']);
    $searchTerm = $conn->real_escape_string($searchTerm); // Sanitize user input

    // Query the database for matching results
    $query = "SELECT * FROM products WHERE name LIKE '%$searchTerm%'";
    $result = $conn->query($query);

    // Check if there are results
    if ($result->num_rows > 0) {
        echo '<div class="result-container"><ul>';
        while ($row = $result->fetch_assoc()) {
            echo '<li>' . htmlspecialchars($row['name']) . '</li>'; // Display result
        }
        echo '</ul></div>';
    } else {
        echo '<div class="result-container"><p>No results found for "' . htmlspecialchars($searchTerm) . '"</p></div>';
    }
}
$conn->close();

