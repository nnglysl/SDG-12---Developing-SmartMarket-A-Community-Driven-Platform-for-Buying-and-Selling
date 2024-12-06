<?php
require_once '../db/dbcon.php'; 
require_once '../db/Account.php';

$database = new Database();
$dbConnection = $database->getConnection(); 

if (isset($_GET['buyer_id'])) {
    $buyerID = $_GET['buyer_id']; //get the buyer id from http
} else {
    header("Location: login.php"); 
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $store_name = $_POST['store_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if (isset($dbConnection)) {
        $sellerAccount = new SellerAccount($dbConnection);
        $result = $sellerAccount->createAccount($username, $email, $password, $confirmPassword, $store_name, $buyerID);
        if ($result === true) { 
            header("Location: dashboard.php"); // Redirect to dashboard
            exit();
        } else {
            echo $result; // error message
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
    <link rel="stylesheet" href="../css/sellerregister.css"/>
</head>
<body>
    <div class="container">
        <h2>Create Seller Account</h2>
        <form method="POST" action=" ">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

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