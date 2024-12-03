<?php
session_start();
require_once('../db/dbcon.php');

class EditProfile
{
    private $buyer_id;
    private $buyer;
    private $db;

    public function __construct()
    {
        // Check if user is logged in
        if (!isset($_SESSION['buyer_id'])) {
            // Redirect to login page if not logged in
            header("Location: ../login/login.php");
            exit();
        }

        // Get user ID from session
        $this->buyer_id = $_SESSION['buyer_id'];

        // Create a Database object to get the connection
        $this->db = new Database();
        $conn = $this->db->getConnection(); // Get the database connection

        // Fetch user data from the database
        $sql = $conn->prepare("SELECT * FROM buyer WHERE buyer_id = ?");
        $sql->bind_param("i", $this->buyer_id);
        $sql->execute();
        $result = $sql->get_result();

        if ($result->num_rows > 0) {
            $this->buyer = $result->fetch_assoc(); // Fetch user data
        } else {
            // Handle case where user is not found
            echo "User  not found.";
            exit();
        }

        // Close the statement
        $sql->close();
    }

    // Getter method to access buyer information
    public function getBuyer()
    {
        return $this->buyer;
    }

    public function updateProfile()
{
    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])) {
        $username = htmlspecialchars(trim($_POST['username']));
        $address = htmlspecialchars(trim($_POST['address'])); // Capture the address input

        // Validate required fields
        if (empty($username) || empty($gender) || empty($phone) || empty($email) || empty($address)) {
            return "All fields are required.";
        }

        // Get the database connection from the Database class
        $conn = $this->db->getConnection();

        // Update the SQL query to include the address
        if ($stmt = $conn->prepare("UPDATE buyer SET username = ?, address = ? WHERE buyer_id = ?")) {
            $stmt->bind_param("sssssi", $username, $address, $this->buyer_id);
            // Execute the statement
            if ($stmt->execute()) {
                return "Profile updated successfully.";
            } else {
                return "Error updating profile: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            return "Error preparing statement: " . $conn->error;
        }
    }

    return '';
}

    // Method to save the profile picture path
    public function saveProfilePicture($filePath)
    {
        // Get the database connection from the Database class
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
            // Close the statement
            $stmt->close();
        } else {
            return "Error preparing statement: " . $conn->error;
        }
    }

    // Destructor to close the database connection
    public function __destruct()
    {
        // Close the database connection when the object is destroyed
        $this->db->closeConnection();
    }
}
?>