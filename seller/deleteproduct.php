<?php
session_start();
require_once '../db/dbdashboard.php';

if (isset($_SESSION['seller_id'])) {
    $sellerId = $_SESSION['seller_id'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
        $productId = $_POST['product_id'];

        $seller = new Seller();

        // Delete the product
        if ($seller->deleteProduct($productId, $sellerId)) {
            echo "Product deleted successfully.";
            header("Location: sellerdashboard.php"); // Redirect back to the dashboard
            exit();
        } else {
            echo "Failed to delete product.";
        }
    }
} else {
    die("Error: seller_id not specified in session.");
}
?>