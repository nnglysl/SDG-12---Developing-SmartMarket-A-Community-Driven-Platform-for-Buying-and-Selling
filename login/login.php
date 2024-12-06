<?php
require_once '../db/Account.php'; 


$database = new Database();
$conn = $database->getConnection(); 
$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["logIn"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $userLogin = new UserLogin($conn);

    if ($userLogin->login($email, $password)) {
        header("Location: ../home/home.php"); // goto the home page 
        exit;
    } else {
        $message = 'Invalid email or password.<br>Please try again or register.';
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
        <?php echo htmlspecialchars($message)?>
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