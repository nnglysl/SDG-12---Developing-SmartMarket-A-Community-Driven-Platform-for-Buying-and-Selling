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
    <link rel="stylesheet" href="addproduct.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body styles */
body {
    font-family: 'Arial', sans-serif;
    background: linear-gradient(to right, #f8e7f1, #e0c3fc); /* Soft gradient background */
    color: #333; /* Dark text for readability */
}

/* Main content styles */
.main-content {
    display: flex;
    justify-content: center; /* Center the content horizontally */
    align-items: center; /* Center the content vertically */
    height: 100vh; /* Full height of the viewport */
    padding: 30px;
}

/* Add product container styles */
.add-product-container {
    background-color: white;
    border-radius: 10px;
    padding: 40px; /* Increased padding for larger form */
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    transition: transform 0.3s ease; /* Add transition for hover effect */
    width: 900px; /* Fixed width for the form */
}

.add-product-container:hover {
    transform: translateY(-5px); /* Lift effect on hover */
}

/* Form group styles */
.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: #555; /* Darker label color */
}

input[type="text"],
input[type="number"],
textarea,
input[type="file"] {
    width: 100%;
    padding: 10px;
    border: 2px solid #ffb6c1; /* Soft pink border */
    border-radius: 5px;
    transition: border-color 0.3s ease; /* Add transition */
}

input[type="text"]:focus,
input[type="number"]:focus,
textarea:focus,
input[type="file"]:focus {
    border-color: #fc6a9a; /* Darker pink on focus */
    outline: none; /* Remove default outline */
}

/* Button styles */
.submit-button,
.cancel-button {
    background-color: #ffb6c1; /* Soft pink button */
    color: white;
    border: none;
    border-radius: 5px;
    padding: 10px 15px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease; /* Add transition */
    margin-right: 10px; /* Space between buttons */
}

.submit-button:hover {
    background-color: #fc6a9a; /* Darker pink on hover */
    transform: scale(1.05); /* Slightly enlarge on hover */
}

.cancel-button {
    background-color: #ccc; /* Grey button for cancel */
}

.cancel-button:hover {
    background-color: #bbb; /* Darker grey on hover */
}

/* Media queries for responsiveness */
@media (max-width: 768px) {
    .main-content {
        margin-left: 0; /* Remove margin for smaller screens */
        padding: 10px; /* Adjust padding */
    }

    .add-product-container {
        padding: 20px; /* Adjust padding */
        width: 90%; /* Make it responsive */
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
                    <input type="text" id="product-name" name="product-name" placeholder="Enter product name" required>
                </div>

                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="number" id="price" name="price" placeholder="Enter product price" required>
                </div>

                <div class="form-group">
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" placeholder="Enter product quantity" required>
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
                </div>
            </form>
        </div>
    </div>


</body>
</html>