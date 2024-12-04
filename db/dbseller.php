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

        // Check username length
        if (strlen($username) < 5) {
            return "Username must be at least 5 characters long.";
        }

        // Check store name length
        if (strlen($store_name) < 5) {
            return "Store name must be at least 5 characters long.";
        }

        if (!preg_match("/^[A-Za-z0-9_]{5,20}$/", $username)) {
            return "Username must be between 5 and 20 characters and can only contain letters, numbers, and underscores.";
        }

        //Validate email domain
        if (!preg_match("/@g\.batstate-u-edu\.ph$/", $email)) {
            return "Email must be from the domain '@g.batstate-u-edu.ph'.";
        }

        // Check if passwords match
        if ($password !== $confirmPassword) {
            return "Passwords do not match.";
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL statement to prevent SQL injection
        $stmt = $this->conn->prepare("INSERT INTO seller (username, email, password, shop_name, buyer_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $username, $email, $hashedPassword, $store_name, $buyerID);

        // Execute the statement
        if ($stmt->execute()) {
            return "Seller account created successfully!";
        } else {
            return "Error: " . $stmt->error;
        }
    }
}
?>