<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel = "stylesheet" href="signup.css">
    <link href = https://fonts.google.com/specimen/Nanum+Gothic
    rel = "stylesheet">
</head>
<body>
    <img src="logo.png" alt="Logo" class="logo">
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
    <div class = "member">
        Already have an account? <a href = "../login/login.html">
            Log In
        </a>
    </div>
    </div>
</body>
</html>