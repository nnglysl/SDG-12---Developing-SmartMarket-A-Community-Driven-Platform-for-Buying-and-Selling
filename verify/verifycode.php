<?php
require_once __DIR__ . '/../db/dbcon.php';
session_start(); // Start the session

class Verification {
    private $conn;

    public function __construct() {
        $database = new Database(); 
        $this->conn = $database->getConnection(); 
    }

    public function verifyAccount($verification_code) {
        if (isset($_SESSION['verification_code']) && isset($_SESSION['email'])) { // Check if verification code and email are set
            if ($verification_code == $_SESSION['verification_code']) { // Compare the entered code with session code
                $email = $_SESSION['email']; // Get the email from session
                $query = "UPDATE buyer SET verify = 'verified' WHERE email = ?"; // Use ? as a placeholder
                $sql = $this->conn->prepare($query);
                $sql->bind_param('s', $email); // Bind the email parameter

                if ($sql->execute()) { // Execute the update query
                    unset($_SESSION['verification_code']); // Unset session variables
                    unset($_SESSION['email']);
                    header("Location: ../login/login.php"); // Redirect to sign in
                    exit();
                } else {
                    // Log the error for debugging
                    error_log("Failed to update verification status for email: $email");
                    return "Verification failed. Please try again.";
                }
            } else {
                return "Invalid verification code. Please try again.";
            }
        } else {
            return "No verification code found. Please register again.";
        }
    }

    public function __destruct() {
        $this->conn = null; 
    }
}
?>