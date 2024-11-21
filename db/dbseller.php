<?php
class SellerAccount {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function createAccount($username, $email, $password, $confirmPassword, $store_name, $buyerID) {
        // Validate inputs
        $username = htmlspecialchars(trim($username));
        $email = htmlspecialchars(trim($email));
        $store_name = htmlspecialchars(trim($store_name));
        $buyerID = intval($buyerID);

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $hashedConfirmPassword = password_hash($confirmPassword, PASSWORD_DEFAULT);

        // Prepare SQL statement to prevent SQL injection
        $stmt = $this->conn->prepare("INSERT INTO sellers (username, email, password, confirm_password store_name, buyerID) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $username, $email, $hashedPassword, $hashedConfirmPassword, $store_name, $buyerID);

        // Execute the statement
        if ($stmt->execute()) {
            return "Seller account created successfully!";
        } else {
            return "Error: " . $stmt->error;
        }
    }
}
?>