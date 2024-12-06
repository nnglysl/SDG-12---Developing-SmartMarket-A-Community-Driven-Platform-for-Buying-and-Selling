<?php
require_once '../db/dbcon.php'; // Include your database connection
require_once 'dbcourier.php'; // Include the Courier class

// Create a new database connection
$database = new Database();
$conn = $database->getConnection(); // Get the connection

// Login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["logIn"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Create an instance of Courier
    $courierLogin = new Courier($conn);

    if ($courierLogin->courierLogin($email, $password)) {
        header("Location: ../courier/toreceiveorder.php");
        exit;
    } else {
        echo 'Invalid email or password.<br>Please try again or register.';
        header("Location: ../courier/courierlogin.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bg1.jpg">
    <link href=https://fonts.google.com/specimen/Nanum+Gothic rel="stylesheet">
    <link rel="stylesheet" href="../login/logins.css">
</head>

<body>

    <img src="../imgs/mainpagelogo.png" alt="Logo" class="logo">
    <div class="wrapper">
        <h2>Log In</h2>
        <form method="post" action="">
            <input type="email" name="email" placeholder="Email">
            <input type="password" name="password" placeholder="Password">
            <div class="remember">
                <input type="checkbox" id="checkbox"> <label for="checkbox"> Remember me </label>
            </div>
            <input type="submit" class="login-btn" value="Log In" name="logIn">
        </form>
</body>

</html>