<?php
   require_once '../db/dbseller.php';
if (isset($_GET['buyer_id'])) {
    // Retrieve the buyer ID from the URL
    $buyerId = $_GET['buyer_id'];
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $store_name = $_POST['store_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    $registration = new SellerRegistration();
    $response = $registration->register($store_name, $email, $password, $confirmPassword,$buyerId);
    echo $response;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Seller Account</title>
    <link rel="stylesheet" href="sellerRegister.css">
</head>
<body>
    <div class="container">
        <h2>Create Seller Account</h2>
        <form method="POST" action=" ">

            <label for="store_name">Store Name:</label>
            <input type="text" id="store_name" name="store_name" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>


            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <label for="confirmPassword">Confirm Password:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required>
            
            <button type="submit">Create Account</button>
            <button type="submit">Back</button>
        </form>
    </div>
</body>
</html>