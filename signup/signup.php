<?php
session_start(); // Start the session
require_once('../dbconnection/dbcon.php'); // database connection
require_once('dbsignUp.php'); // UserRegistration class

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $userName = $_POST["userName"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

    $userRegistration = new UserRegistration($conn);
    $response = $userRegistration->createAccount($userName, $firstName, $lastName, $email, $password, $confirmPassword);
    echo $response;

    // redirect on success
    if ($response === "Registration Successful") {
        header("Location: ../login/login.html");
        exit(); // Ensure no further code is executed after redirection
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel = "stylesheet" href="signup.css">
    <link href = https://fonts.google.com/specimen/Nanum+Gothic rel = "stylesheet">
</head>
<body>
    <img src="../imgs/logo.png" alt="Logo" class="logo">
    <div class = "signup">
        <h1>Create an account</h1>
        <form action = "dbsignUp.php" method="post">
            <input type = "text" name="userName" placeholder = "Userame" required>
            <input type = "text" name="firstName" placeholder = " Fist Name" required>
            <input type = "text" name="lastName" placeholder = "Last Name" required>
            <input type = "email" name="email" placeholder = "Email" required>
            <input type = "password" name="password" placeholder = "Password" required minlength="8" maxlength="20" placeholder="8 characters" >
            <input type = "password" name="confirmPassword" placeholder = "Confirm Password" required minlength="8" maxlength="20" placeholder="8 characters" >
        <input type="submit" class="btn" value="Create Account" name="createAccount">
        </form>
    <div class = "member">  Already have an account? <a href = "../login/login.html"> Log In</a>
    </div>
    </div>
</body>
</html>