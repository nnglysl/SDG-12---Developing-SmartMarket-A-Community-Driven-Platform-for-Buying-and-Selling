<?php
require_once '../dbconnection/dbcon.php'; // Include your database connection
require_once 'dbseller.php'; // Include the SellerAccount class

session_start();
$_SESSION['buyerID'] = $buyerID; 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $store_name = $_POST['store_name'];

    $sellerAccount = new SellerAccount($dbConnection);
    $result = $sellerAccount->createAccount($username, $email, $password, $confirmPasswor, $store_name, $buyerID);
    echo $result; // Display the result message
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Seller Account</title>
    <link rel="stylesheet" href="../signup/signup.css"> 
</head>
<body>
    <div class="container">
        <h2>Create Seller Account</h2>
        <form method="POST" action=" ">
            <label for="buyerID">Buyer ID:</label>
            <input type="number" id="buyerID" name="buyerID" required>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <label for="password">Confirm Password:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required>

            <label for="store_name">Store Name:</label>
            <input type="text" id="store_name" name="store_name" required>

            <button type="submit">Create Account</button>
        </form>
    </div>
</body>
</html>