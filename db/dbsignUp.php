<?php
require_once __DIR__ . '/../PHPMailer/src/Exception.php';
require_once __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/src/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../db/dbcon.php';

class UserRegistration {
    private $conn;

    // Constructor to initialize the database connection
    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    // Check if the username is taken
    public function isUsernameTaken($username) {
        $query = "SELECT * FROM buyer WHERE username = ?"; // Adjust the table name as needed
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result(); // Get the result set
        $count = $result->num_rows; // Count the number of rows
        $stmt->close();
    
        return $count > 0; // Return true if the username exists
    }

    // Check if the email is taken
    public function isEmailTaken($email) {
        $query = "SELECT * FROM buyer WHERE email = ?"; // Adjust the table name as needed
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result(); // Get the result set
        $count = $result->num_rows; // Count the number of rows
        $stmt->close();
        
        return $count > 0; 
    }

    // Method to create a new account
    public function createAccount($firstName, $lastName, $userName, $email, $password, $confirmPassword) {
        // Validate username requirements
        if (!preg_match("/^[A-Za-z0-9_]{5,20}$/", $userName)) {
            return "Username must be between 5 and 20 characters and can only contain letters, numbers, and underscores.";
        }

        //Validate email domain
        if (!preg_match("/@g\.batstate-u.edu\.ph$/", $email)) {
            return "Email must be from the domain '@g.batstate-u.edu.ph'.";
        }

        // Check if passwords match
        if ($password !== $confirmPassword) {
            return "Passwords do not match.";
        }

        // Hash the password before storing
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if username or email already exists
        if ($this->isUsernameTaken($userName)) {
            return "Username is already taken.";
        }

        if ($this->isEmailTaken($email)) {
            return "Email is already registered.";
        }

        // Prepare the insert statement
        $query = "INSERT INTO buyer (username, first_name, last_name, email, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssss", $userName, $firstName, $lastName, $email, $hashed_password); // Bind the parameters
        $result = $stmt->execute(); // Execute the statement

        if ($result) {
            
            $confirmationCode = rand(1000, 9999); // Generate a random 6-digit confirmation code
            session_start();
            $_SESSION['verification_code'] =  $confirmationCode;
            $_SESSION['email'] = $email;
            // store the confirmation code in the database
            if ($this->storeConfirmationCode($email, $confirmationCode)) {

                $this->sendVerificationEmail($email, $firstName, $lastName, $confirmationCode);
            }

            return "Registration Successful. A verification email has been sent.";
        } else {
            return "Registration failed: " . $this->conn->error; // Get error message
        }
    }

    // Store the confirmation code in the database
    public function storeConfirmationCode($email, $confirmationCode) {
        $query = "UPDATE buyer SET verification_code = ? WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("is", $confirmationCode, $email);
        
        if ($stmt->execute()) {
            return true; // Successfully updated
        } else {
            return false; // Failed to update
        }
    }

    // Send the verification email
    public function sendVerificationEmail($email, $first_name, $last_name, $confirmationCode) {
        $mail = new PHPMailer(true);
    
        try {
            // Server settings
            $mail->isSMTP();
            $mail->SMTPAuth   = true;
            $mail->Host       = 'smtp.gmail.com';
            $mail->Username   = 'smartmarket0324@gmail.com'; // Your Gmail address
            $mail->Password   = 'yurb bjil dilf ypok'; // Your Gmail app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
    
            // Receiver
            $mail->setFrom('smartmarket0324@gmail.com', 'SmartMarket');
            $mail->addAddress($email, $first_name . ' ' . $last_name);
    
            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Verification Code';
            $mail->Body = "<h3>Dear $first_name,</h3>
                           <p>Your confirmation code is: <strong>$confirmationCode</strong></p>
                           <p>From,<br>SmartMarket</p>";
    
            // Send the email
            if ($mail->send()) {
                return "Verification code sent to your email.";
            } else {
                return "Unable to send verification code. Mailer Error: " . $mail->ErrorInfo;
            }
        } catch (Exception $e) {
            return "Unable to send verification code. Mailer Error: " . $mail->ErrorInfo;
        }
    }
}
?>
       