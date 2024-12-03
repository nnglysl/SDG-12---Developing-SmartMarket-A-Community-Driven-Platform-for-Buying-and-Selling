<?php
require_once '../db/dbcon.php'; // Include your database connection
require_once '../db/dblogin.php'; // Include the UserLogin class

// Create a new database connection
$database = new Database();
$conn = $database->getConnection(); // Get the connection

// Login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["logIn"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Create an instance of UserLogin
    $userLogin = new UserLogin($conn);

    // Attempt to log in the user
    if ($userLogin->login($email, $password)) {
        // Redirect to the home page on successful login
        header("Location: ../home/home.php");
        exit;
    } else {
        // Login failed: incorrect email or password
        echo 'Invalid email or password.<br>Please try again or register.';
        // Optionally, redirect back to the login page
        header("Location: login.php");
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
        <div class="account">
            Don't have an account? <a href="../signup/signup.php">
                Create an account
            </a>

        </div>
</body>

</html>