<?php
class UserLogin {
    private $conn;

    // Constructor to initialize the database connection
    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    // Method to log in a user
    public function login($email, $password) {
        // Prepare the SQL statement to prevent SQL injection
        $sql = $this->conn->prepare("SELECT * FROM buyer WHERE email = ?");
        $sql->bind_param("s", $email);
        $sql->execute();
        $result = $sql->get_result();

        if ($result->num_rows > 0) {
            $buyer = $result->fetch_assoc();
            
            // Verify the password 
            if (password_verify($password, $buyer['password'])) {
                // Login successful 
                session_start();
                $_SESSION['buyer_id'] = $buyer['buyer_id']; // Store user ID in session
                $_SESSION['email'] = $buyer['email']; // Store email in session
                return true; // Indicate success
            } else {
                // Incorrect password
                return false;
            }
        } else {
            // User not found
            return false;
        }
    }
}
?>