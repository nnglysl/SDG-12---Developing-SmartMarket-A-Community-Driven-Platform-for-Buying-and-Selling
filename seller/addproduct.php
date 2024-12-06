<?php
require_once '../db/dbaddproduct.php';
session_start();

if (!isset($_SESSION['seller_id'])) {
    die("Seller ID not set in session.");
}

$sellerId = $_SESSION['seller_id']; 

// Check if the seller ID exists in the database
$connection = new Database();
$conn = $connection->getConnection();
$sellerCheckQuery = "SELECT * FROM seller WHERE seller_id = ?";
$sellerCheckStmt = $conn->prepare($sellerCheckQuery);
$sellerCheckStmt->bind_param("i", $sellerId);
$sellerCheckStmt->execute();
$sellerCheckResult = $sellerCheckStmt->get_result();

if ($sellerCheckResult->num_rows === 0) {
    die("Invalid seller ID.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productName = $_POST['product-name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $condition = $_POST['condition'];
    $image = $_FILES['image'];

    // Handle variations if needed
    $variations = [];
    if (isset($_POST['variation_type'])) {
        $variationTypes = $_POST['variation_type']; 
        $variationValues = $_POST['variation_value']; 
        $variationPrices = $_POST['variation_price']; 
        $variationStocks = $_POST['variation_stock']; 

        for ($i = 0; $i < count($variationTypes); $i++) {
            $variations[] = [
                'type' => $variationTypes[$i],
                'value' => $variationValues[$i],
                'price' => $variationPrices[$i],
                'stock' => $variationStocks[$i],
            ];
        }
    }

    $productManager = new ProductManager();
    // Pass parameters in the correct order
    $result = $productManager->addProduct($productName, $price, $description, $image, $condition, null, $sellerId, $variations);

    echo $result;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    <link rel="stylesheet" href="../css/addproduct.css"/>
</head>
<body>
    <?php include('../sidebar/sidebar.php'); ?>
    <div class="main-content">
        <div class="add-product-container">
            <h1>Add Product</h1>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="product-name">Product Name:</label>
                    <input 
                        type="text" 
                        id="product-name" 
                        name="product-name" 
                        placeholder="Enter product name" 
                        minlength="2" 
                        required>
                </div>

                <div class="form-group">
                    <label for="price">Price:</label>
                    <input 
                        type="number" 
                        id="price" 
                        name="price" 
                        placeholder="" 
                        min="10" 
                        max="10000" 
                        required 
                        oninput="this.value = Math.min(Math.max(this.value, 1), 10000);">
                </div>

                <div class="form-group">
                    <label for="variation">Variation:</label>
                    <input 
                        type="text" 
                        id="variation" 
                        name="variation_type" 
                        placeholder="Enter variation type" 
                        required>
                    <input 
                        type="text" 
                        name="variation_value" 
                        placeholder="Enter variation value" 
                        required>
                    <input 
                        type="number" 
                        name="variation_price" 
                        placeholder="Enter variation price" 
                        min="0" 
                        required>
                    <input 
                        type="number" 
                        name="variation_stock" 
                        placeholder="Enter variation stock" 
                        min="1" 
                        required>
                </div>
                <div class="form-group">
                    <label for="condition">Condition:</label>
                    <select id="condition" name="condition" required>
                        <option value="" disabled selected>Select condition</option>
                        <option value="new">New</option>
                        <option value="like-new">Like-new</option>
                        <option value="lightly-used">Lightly-used</option>
                        <option value="heavily-used">Heavily-used</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" rows="4" placeholder="Enter product description" required></textarea>
                </div>

                <div class="form-group">
                    <label for="image">Upload Product Image:</label>
                    <input type="file" id="image" name="image" accept="image/*" required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="submit-button">Add Product</button>
                    <button type="reset" class="cancel-button">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>