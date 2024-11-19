<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="addproduct.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
</head>
<body>
    <!-- Back Button -->
    <div class="back-button">
        <a href="javascript:history.back()"><i class="fas fa-arrow-left"></i> Back</a>
    </div>


    <div class="add-product-container">
        <h1>Add Product</h1>
        <form class="add-product-form">
            <div class="form-group">
                <label for="product-name">Product Name:</label>
                <input type="text" id="product-name" name="product-name" placeholder="Enter product name" required>
            </div>


            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" placeholder="Enter product price" required>
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
</body>
</html>




