<?php
require_once('../dbconnection/dbcon.php');


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["logIn"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // to prevent SQL injection
    $sql = $conn->prepare("SELECT * FROM buyers WHERE email = ?");
    $sql->bind_param("s", $email);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) { //this indicates how many rows were returned 
        $user = $result->fetch_assoc();
        
        // verify the password 
        if (password_verify($password, $user['password'])) {
            // Login successful 
            //start session and redirect to the home page
            session_start();
            $_SESSION['buyer_id'] = $user['buyer_id']; // store user ID in session
            $_SESSION['email'] = $user['email']; // store email in session
            header("Location: ../home/home.html");
            exit;
        } else {
            // Login failed: incorrect password
            echo 'Invalid email or password.' .'<br>' .'Please try again or register.';
            header("Location: signIn.php");
            exit;
        }
    } else {
        // Login failed: user not found or not verified
        echo 'Invalid email or password.' .'<br>' .'Please try again or register.';;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>