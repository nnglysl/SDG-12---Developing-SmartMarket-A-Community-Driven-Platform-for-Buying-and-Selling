<?php
session_start(); // Start the session
require_once('../dbconnection/dbcon.php');


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["createAccount"])) {
    $userName = $_POST["userName"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];
    // Check if passwords match
    if ($password != $confirmPassword) {
        echo "Passwords do not match";
    } else {
        // Hash the password before storing
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $hashed_confirm_password = password_hash($confirmPassword, PASSWORD_DEFAULT);

        // Query to check if email already exists
        $query = "SELECT * FROM buyers WHERE email = '$email'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            echo "Email already exists";
        } else {
            
            // Insert user data into the database
            $query = "INSERT INTO buyers (username,first_name,last_name ,email, password, confirm_password) VALUES ('$userNsame','$firstName' ,'$lastName', '$email','$hashed_password', '$hashed_confirm_password')";
            $result = $conn->query($query);

            if ($result) {
                echo "Registration Successful";
                header("Location: ../login/login.html");
            } else {
                echo "Registration failed";
            }
        }
    }
}

?>
