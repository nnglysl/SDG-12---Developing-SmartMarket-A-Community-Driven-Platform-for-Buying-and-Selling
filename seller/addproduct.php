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
    <style>
        /* General Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    transition: background-color 0.3s ease, color 0.3s ease; 
}

/* Body Styles */
body {
    font-family: 'Arial', sans-serif;
    background-color: #fde4e4; 
    color: #333; 
}

/* Main Content */
.main-content {
    display: flex;
    justify-content: center; 
    align-items: center; 
    height: 100vh; 
    padding: 10px;
}

/* Add Product Container */
.add-product-container {
    background-color: white; 
    color: #333; 
    border-radius: 10px; 
    padding: 20px; 
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); 
    width: 100%;
    max-width: 450px; 
}


.form-group {
    margin-bottom: 15px; 
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px; 
    color: #444;
}

input, select, textarea {
    width: 100%;
    padding: 8px; 
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
}

/* Buttons */
.submit-button, .cancel-button {
    padding: 8px 16px; /* Reduced button padding */
    border: none;
    border-radius: 5px;
    font-size: 14px; /* Smaller font size for buttons */
    cursor: pointer;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.submit-button {
    background-color: #333; /* Dark button */
    color: white;
}

.submit-button:hover {
    background-color: #555;
}

.cancel-button {
    background-color: #ccc;
    color: #333;
    margin-left: 10px;
}

.cancel-button:hover {
    background-color: #aaa;
}

/* Textarea */
textarea {
    resize: none; 
}

/* File Upload */
input[type="file"] {
    padding: 5px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .add-product-container {
        padding: 15px; /* Further reduced padding for small screens */
    }

    .submit-button, .cancel-button {
        font-size: 12px; 
        padding: 6px 12px; 
    }
}
    </style>
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
                        required >
                
                </div>

                <div class="form-group">
                    <label for="price">Price:</label>
                    <input 
                        type="number" 
                        id="quantity" 
                        name="quantity" 
                        placeholder="" 
                        min="10" 
                        max="10000" 
                        required 
                        oninput="this.value = Math.min(Math.max(this.value, 1), 10000);">

                    <div class="form-group">
                        <label for="variation">Variation:</label>
                        <input 
                            type="text" 
                            id="condition" 
                            name="condition" 
                            placeholder="" 
                            required>
                    </div>
                    
                
                
                <div class="form-group">
                    <label for="quantity">Stock:</label>
                    <input 
                        type="number" 
                        id="quantity" 
                        name="quantity" 
                        placeholder="" 
                        min="1" 
                        max="50" 
                        required 
                        oninput="this.value = Math.min(Math.max(this.value, 1), 50);">
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