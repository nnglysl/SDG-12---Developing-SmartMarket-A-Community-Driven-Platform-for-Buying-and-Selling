<?php
require_once '../db/dbaddproduct.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productName = $_POST['product-name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity']; // Add quantity to the POST request
    $image = $_FILES['image'];

    $productManager = new ProductManager();
    $result = $productManager->addProduct($productName, $price, $description, $quantity, $image); // Pass quantity to the method

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
    <link rel = "stylesheet" href="../seller/addproduct.css"
 
</head>
<body>
    <?php include('../sidebar/sidebar.php'); ?>
    <div class="main-content">
        <div class="add-product-container">
            <h1>Add Product</h1>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <input 
                        type="text" 
                        id="product-name" 
                        name="product-name" 
                        placeholder="Enter product name" 
                        minlength="2" 
                        required >
                
                </div>

                <div class="form-group">
                    <input 
                        type="number" 
                        id="quantity" 
                        name="quantity" 
                        placeholder="Price" 
                        min="10" 
                        max="10000" 
                        required 
                        oninput="this.value = Math.min(Math.max(this.value, 1), 10000);">

                    <div class="form-group">
                        <input 
                            type="text" 
                            id="condition" 
                            name="condition" 
                            placeholder="Variation (e.g., size, color, etc.)" 
                            required>
                    </div>
                
                <div class="form-group">
                    <input 
                        type="number" 
                        id="quantity" 
                        name="quantity" 
                        placeholder="Stock" 
                        min="1" 
                        max="50" 
                        required 
                        oninput="this.value = Math.min(Math.max(this.value, 1), 50);">
                </div>

                <div class="form-group">
                    <select id="condition" name="condition" required>
                        <option value="" disabled selected>Select condition</option>
                        <option value="new">New</option>
                        <option value="like-new">Like-new</option>
                        <option value="lightly-used">Lightly-used</option>
                        <option value="heavily-used">Heavily-used</option>
                    </select>
                </div>


                <div class="form-group">
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