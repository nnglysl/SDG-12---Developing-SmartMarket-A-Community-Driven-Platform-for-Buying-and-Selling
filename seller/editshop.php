<?php
session_start();
require_once '../db/Seller.php';

if (isset($_SESSION['seller_id'])) {
    $sellerId = $_SESSION['seller_id'];
    $productId = $_GET['id']; // Get the product ID from the URL

    $seller = new Market();

    // Fetch product information
    $product = $seller->getProductId($productId, $sellerId); // Assuming you have this method

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Handle form submission
        $productName = $_POST['product_name'];
        $price = $_POST['price'];
        $imagePath = $_POST['image_path']; // You may want to handle file uploads separately

        if ($seller->updateProduct($productId, $productName, $price, $imagePath)) {
            echo "Product updated successfully.";
            header("Location: sellerdashboard.php"); // Redirect back to the dashboard
            exit();
        } else {
            echo "Failed to update product.";
        }
    }
} else {
    die("Error: seller_id not specified in session.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="../css/received.css">

</head>
<body>
    <div class="container">
        <h1>Edit Product</h1>
        <?php if (isset($message) && !empty($message)): ?>
            <div class="message <?php echo isset($success) ? 'success' : 'error'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="product_name">Product Name:</label>
            <input type="text" id="product_name" name="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>

            <label for="image_path">Image Path:</label>
            <input type="text" id="image_path" name="image_path" value="<?php echo htmlspecialchars($product['image_path']); ?>">

            <input type="submit" value="Update Product">
        </form>
    </div>
</body>
</html>