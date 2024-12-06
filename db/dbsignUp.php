<?php
class UserRegistration {
    private $conn;

    // Constructor to initialize the database connection
    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    // Method to create a new account
    public function createAccount($userName, $firstName, $lastName, $email, $password, $confirmPassword) {
        // Check if passwords match
        if ($password !== $confirmPassword) {
            return "Passwords do not match";
        }

        // Hash the password before storing
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $hashed_confirm_password = password_hash($confirmPassword, PASSWORD_DEFAULT);

        // Query to check if email already exists
        $query = "SELECT * FROM buyer WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return "Email already exists";
        } else {
            // Insert user data into the database
            $query = "INSERT INTO buyer (userName, first_name, last_name, email, password, confirm_password) VALUES (?, ?, ?, ?, ?,?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("sssss", $userName, $firstName, $lastName, $email, $hashed_password,$hashed_confirm_password);
            $result = $stmt->execute();

            if ($result) {
                return "Registration Successful";
            } else {
                return "Registration failed: " . $this->conn->error;
            }
        }
    }
}
?>