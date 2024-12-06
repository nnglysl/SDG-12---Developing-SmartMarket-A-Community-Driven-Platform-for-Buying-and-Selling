<?php
require_once 'dbcon.php';

class SellerRegistration {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function register($store_name, $email, $password, $confirmPassword,$buyer_id) {
        // Check if passwords match
        if ($password !== $confirmPassword) {
            return json_encode(["message" => "Passwords do not match"]);
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $hashedConfirmPassword = password_hash($confirmPassword, PASSWORD_DEFAULT);
        // Prepare and bind
        $stmt = $this->db->getConnection()->prepare("INSERT INTO seller (shop_name, email, password, confirm_password, buyer_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $store_name, $email, $hashedPassword, $hashedConfirmPassword,$buyer_id);

        // Execute the statement
        if ($stmt->execute()) {
            $stmt->close();
            $this->db->closeConnection();
            header('Location: ../seller/sellerdashboard.php');
        } else {
            if ($this->db->getConnection()->errno == 1062) { // Duplicate entry
                return json_encode(["message" => "Seller already exists"]);
            } else {
                return json_encode(["message" => "Error: " . $stmt->error]);
            }
        }
    }
}
?>