<?php
session_start(); // Start the session
require_once '../db/dbcon.php'; // database connection
require_once '../db/Account.php'; // UserRegistration class

$database = new Database();
$conn = $database->getConnection();
$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $userName = $_POST["userName"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

    $userRegistration = new UserRegistration($conn);
    // Proceed with user registration
    $response = $userRegistration->createAccount($firstName, $lastName, $userName, $email, $password, $confirmPassword);

    if (strpos($response, 'Successful') !== false) {
        header("Location: ../verify/verify.php");
        exit();
    } else {
        $message = $response;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../signup/signup.css">
    <link href="https://fonts.googleapis.com/css2?family=Nanum+Gothic&display=swap" rel="stylesheet">
</head>


<body>
    <img src="../imgs/mainpagelogo.png" alt="Logo" class="logo">
    <div class="signup">
        <h1>Create an account</h1>
        <?php echo htmlspecialchars($message)?>

        <form action="" method="post"> 
            <input type="text" name="firstName" placeholder="First Name" required>
            <input type="text" name="lastName" placeholder="Last Name" required>
            <input type="text" name="userName" placeholder="Username" required >
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirmPassword" placeholder="Confirm Password" required>
            <input type="submit" class="btn" value="Create Account" name="createAccount">
        </form>
        <div class="member"> Already have an account? <a href="../login/login.php"> Log In</a>
        </div>
    </div>
</body>
</html>