<?php
session_start();
require_once('../db/dbcon.php');

class UserAccount {
    private $buyer_id;
    private $buyer;
    private $db;

    public function __construct() {
        if (!isset($_SESSION['buyer_id'])) {
            header("Location: ../login/login.php");
            exit();
        }
        $this->buyer_id = $_SESSION['buyer_id'];
        $this->db = new Database();
        $this->getBuyerData();
    }

    // Fetch user data from the database
    private function getBuyerData() {
        $conn = $this->db->getConnection(); // Get the database connection

        $sql = $conn->prepare("SELECT * FROM buyer WHERE buyer_id = ?");
        $sql->bind_param("i", $this->buyer_id);
        $sql->execute();
        $result = $sql->get_result();

        if ($result->num_rows > 0) {
            $this->buyer = $result->fetch_assoc(); 
        } else {
            echo "User  not found.";
            exit();
        }

        $sql->close();
    }

    public function getBuyer() {
        return $this->buyer;
    }

    public function updateProfile($data) {
        if ($this->validateProfileData($data)) {
            $username = htmlspecialchars(trim($data['username']));
            $address = htmlspecialchars(trim($data['address']));

            $conn = $this->db->getConnection();

            if ($stmt = $conn->prepare("UPDATE buyer SET username = ?, address = ? WHERE buyer_id = ?")) {
                $stmt->bind_param("ssi", $username, $address, $this->buyer_id);
                // Execute the statement
                if ($stmt->execute()) {
                    $_SESSION['address'] = $data['address'];
                    return "Profile updated successfully.";
                } else {
                    return "Error updating profile: " . $stmt->error;
                }
                $stmt->close();
            } else {
                return "Error preparing statement: " . $conn->error;
            }
        }

        return "All fields are required.";
    }

    private function validateProfileData($data) {
        return !empty($data['username']) && !empty($data['address']);
    }

    public function saveProfilePicture($filePath) {
        $conn = $this->db->getConnection();

        // Prepare the update statement
        if ($stmt = $conn->prepare("UPDATE buyer SET profile_picture = ? WHERE buyer_id = ?")) {
            $stmt->bind_param("si", $filePath, $this->buyer_id);
            // Execute the statement
            if ($stmt->execute()) {
                return "Profile picture updated successfully.";
            } else {
                return "Error updating profile picture: " . $stmt->error;
            }
            $stmt->close();
        } else {
            return "Error preparing statement: " . $conn->error;
        }
    }

    public function switchAccount() {
        // Check if the buyer is already a seller
        $query = "SELECT * FROM seller WHERE buyer_id = ?";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->bind_param("i", $this->buyer_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Buyer is already a seller
            $seller = $result->fetch_assoc();
            $_SESSION['seller_id'] = $seller['seller_id'];
            header("Location: ../seller/sellerdashboard.php"); 
        } else {
            header('Location: ../seller/sellerregister.php?buyer_id=' . $this->buyer_id);
        }
        exit();
    }

    public function __destruct() {
        $this->db->closeConnection();
    }
}
?>