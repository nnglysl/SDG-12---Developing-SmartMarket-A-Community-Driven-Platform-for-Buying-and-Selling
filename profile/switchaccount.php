<?php
class AccountSwitcher {
    private $conn;
    private $buyerID;

    public function __construct() {
        $database = new Database(); // Create an instance of the Database class
        $this->conn = $database->getConnection();
        $this->buyerID = $_SESSION['buyer_id']; // Assume buyerID is stored in session
    }

    public function switchAccount() {
        // Check if the buyer is already a seller
        $query = "SELECT * FROM seller WHERE buyer_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->buyerID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Buyer is already a seller
            $seller = $result->fetch_assoc();
                session_start();
                $_SESSION['seller_id'] = $seller['seller_id'];
            header("Location: ../seller/sellerdashboard.php"); // Assuming 'id' is the seller's unique identifier
        } else {
            // Buyer is not a seller, redirect to create account form with buyer ID
            header('Location: ../seller/sellerregister.php?buyer_id=' . $this->buyerID); // Pass the buyer ID as a query parameter
        }
        exit();
    }
}
?>