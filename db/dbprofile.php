<?php
<<<<<<< HEAD
session_start();
require_once('dbcon.php');
=======
session_start(); 
require_once('../dbconnection/dbcon.php'); 
>>>>>>> d4b3911f02e1ce4b4ec13ff391a248cfa6225f7e

class EditProfile
{
    private $buyer_id;
<<<<<<< HEAD
    private $buyer;
=======
    private $buyer; 
>>>>>>> d4b3911f02e1ce4b4ec13ff391a248cfa6225f7e
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
            // Check if 'name' is set and not empty
            if (isset($_POST['name']) && !empty(trim($_POST['name']))) {
                // Get the form data
                $name = explode(' ', trim($_POST['name']), 2);
                $firstName = htmlspecialchars($name[0]);
                $lastName = isset($name[1]) ? htmlspecialchars($name[1]) : ''; // Handle case where last name is not provided
            } else {
                // Handle the error for name not provided
                die("Name is required.");
            }

            $username = htmlspecialchars($_POST['username']);
            $gender = htmlspecialchars($_POST['gender']);
            $phone = htmlspecialchars($_POST['phone']);
            $email = htmlspecialchars($_POST['email']);

            // Get the database connection from the Database class
            $conn = $this->db->getConnection();

            // Prepare an SQL statement
            if ($stmt = $conn->prepare("UPDATE buyer SET first_name = ?, last_name = ?, username = ?, gender = ?, phone_number = ?, email = ? WHERE buyer_id = ?")) {

                // Bind parameters
                $stmt->bind_param("ssssssi", $firstName, $lastName, $username, $gender, $phone, $email, $this->buyer_id);

                // Execute the statement
                if ($stmt->execute()) {
                    $message = "Profile updated successfully.";
                } else {
                    $message = "Error updating profile: " . $stmt->error;
                }

                // Close the statement
                $stmt->close();
            } else {
                $message = "Error preparing statement: " . $conn->error;
            }

            // Return the message
            return $message;
        }

        return '';
    }

    // Destructor to close the database connection
    public function __destruct()
    {
        // Close the database connection when the object is destroyed
        $this->db->closeConnection();
    }
}
?>