<?php
session_start(); // Start the session to access session variables
require_once('../dbconnection/dbcon.php'); // Include your database connection file

// Check if user is logged in
if (!isset($_SESSION['buyer_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Fetch user data from the database
$buyer_id = $_SESSION['buyer_id']; // Get user ID from session
$sql = $conn->prepare("SELECT * FROM buyer WHERE buyer_id = ?"); // Adjust table and column names as necessary
$sql->bind_param("i", $buyer_id);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows > 0) {
    $buyer = $result->fetch_assoc(); // Fetch user data
} else {
    // Handle case where user is not found
    echo "User  not found.";
    exit();
}

// Close the statement and connection
$sql->close();
$conn->close();
?>
