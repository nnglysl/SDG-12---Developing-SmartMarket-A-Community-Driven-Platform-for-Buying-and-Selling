<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Information Form</title>
    <link rel="stylesheet" href="createShop.css">
</head>
<body>
    <div class="form-container">
        <h2>Shop Information</h2>
        <div class="form-group">
            <label for="shop-name">Shop Name </label>
            <input type="text" id="shop-name" name="shop-name" required>
        </div>
        <div class="form-group">
            <label for="pickup-address">Pickup Address</label>
            <select id="pickup-address" name="pickup-address">
                <option value="">Select a pickup address</option>
                <option value="address1">Alangilan</option>
                <option value="address2">Pablo Borbon</option>
                <option value="address3">Lipa</option>
                <option value="address4">Rosario</option>
                <option value="address5">Nasugbu</option>
                <option value="address5">Malvar</option>
                <option value="address5">Lemery</option>
                <option value="address5">Lobo</option>
            </select>
        </div>
        <div class="form-group">
            <label for="email">Email </label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="phone-number">Phone Number </label>
            <input type="tel" id="phone-number" name="phone-number" required>
        </div>
        <div class="form-buttons">
            <a href="profile.html" class="back-button" >Back</a>
            <button class="next-button">Next</button>
        </div>
    </div>
</body>
</html>