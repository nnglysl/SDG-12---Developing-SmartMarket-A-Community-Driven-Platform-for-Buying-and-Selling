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
    <link rel="stylesheet" href="../signup/signup.css"> 
    <style>
         @import url('https://fonts.google.com/specimen/Nanum+Gothic');
*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Poppins", sans-serif;
}
body{
    background-image: url(/final/imgs/bg1.jpg);
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
}
.logo {
    width: 160px; 
    padding-left: 10px;
    padding-top: 10px;
}
.signup{
    width: 400px;
    padding: 30px;
    margin: 100px auto;
    background-color: white;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 20px 35px rgba(0, 0, 0, 0.8);
    margin-top: 20px;
}
h1{
    font-size: 30px;
    color: black;
    margin-bottom: 40px;
}
form input{
    width: 92%;
    outline: none;
    border: 1px solid #fff;
    padding: 12px 20px;
    margin-bottom: 10px;
    border-radius: 20px;
    background: #e4e4e4;
}
.login-btn input{
    font-size: 16px;
    margin-top: 30px;
    margin-bottom: 20px;
    padding: 10px 0;
    border-radius: 20px;
    outline: none;
    border: none;
    width: 90%;
    color: #fff;
    cursor: pointer;
    background: rgb(0, 0, 0);
}
button:hover{
    background: rgba(200, 16, 16, 0.977);
}
input:focus{
    border: 1px solid rgb(192, 192, 192)
}
.member{
    font-size: 12px;
    margin-top: 8px;
    color: #636363;
}
.member a{
    color: rgb(17, 107, 143);
    text-decoration: none;
}
    </style>
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