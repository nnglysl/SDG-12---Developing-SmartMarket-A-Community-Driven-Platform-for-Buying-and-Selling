<?php
require_once '../db/dbcon.php'; // Include your database connection
require_once '../db/dbseller.php'; // Include the SellerAccount class

$database = new Database();
$dbConnection = $database->getConnection(); 

if (isset($_GET['buyer_id'])) {
    $buyerID = $_GET['buyer_id']; 
} else {
    header("Location: login.php"); 
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $store_name = $_POST['store_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if (isset($dbConnection)) {
        $sellerAccount = new SellerAccount($dbConnection);
        $result = $sellerAccount->createAccount($username, $email, $password, $confirmPassword, $store_name, $buyerID);
        if ($result === true) { // Assuming createAccount returns true on success
            header("Location: dashboard.php"); // Redirect to dashboard
            exit();
        } else {
            echo $result; // Display the error message
        }
    } else {
        echo "Database connection not established.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Seller Account</title>
    <link rel="stylesheet" href="../seller/sellerRegister.css"> 
</head>
<body>
    <img src="../imgs/mainpagelogo.png" alt="Logo" class="logo">
    <div class="container">
        <h2>Create Seller Account</h2>
        <form method="POST" action=" ">
            <input type="text" id="username" name="username" placeholder="Enter your username" required>

            <input type="text" id="store_name" name="store_name" placeholder="Enter your store name" required>
            
            <input type="email" id="email" name="email" placeholder="Enter your email address" required>
            
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
            
            <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required>
            
            <button type="submit">Create Account</button>
            <button type="submit" class="back">Back</button>
        </form>
    </div>
</body>
</html>
