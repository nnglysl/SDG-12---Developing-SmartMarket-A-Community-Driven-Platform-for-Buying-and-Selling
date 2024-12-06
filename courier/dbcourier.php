<?php
class Courier{
    private $conn;

    // Constructor to initialize the database connection
    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    // Method to log in a user
    public function courierLogin($email, $password) {
        // Prepare the SQL statement to prevent SQL injection
        $sql = $this->conn->prepare("SELECT * FROM courier WHERE email = ?");
        $sql->bind_param("s", $email);
        $sql->execute();
        $result = $sql->get_result();

        if ($result->num_rows > 0) {
            $buyer = $result->fetch_assoc();
            
            if (password_verify($password, $buyer['password'])) {
                session_start();
                $_SESSION['courier_id'] = $buyer['courier_id'];
                $_SESSION['email'] = $buyer['email']; 
                return true; 
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
?>