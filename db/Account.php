<?php
require_once __DIR__ . '/../PHPMailer/src/Exception.php';
require_once __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/src/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../db/dbcon.php';

class Account {
    protected $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    protected function isUsernameTaken($username) {
        $query = "SELECT * FROM buyer WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $count = $result->num_rows;
        $stmt->close();
        return $count > 0;
    }

    protected function isEmailTaken($email) {
        $query = "SELECT * FROM buyer WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $count = $result->num_rows;
        $stmt->close();
        return $count > 0;
    }

    protected function validateUsername($username) {
        return preg_match("/^[A-Za-z0-9_]{5,20}$/", $username);
    }

    protected function validateEmail($email) {
        return preg_match("/@g\.batstate-u\.edu\.ph$/", $email);
    }

    protected function validatePassword($password, $confirmPassword) {
        return $password === $confirmPassword;
    }
}

class UserRegistration extends Account {
    public function createAccount($firstName, $lastName, $userName, $email, $password, $confirmPassword) {
        if (!$this->validateUsername($userName)) {
            return "Username must be between 5 and 20 characters and can only contain letters, numbers, and underscores.";
        }

        if (!$this->validateEmail($email)) {
            return "Use your G-suite account.";
        }

        if (!$this->validatePassword($password, $confirmPassword)) {
            return "Passwords do not match.";
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        if ($this->isUsernameTaken($userName)) {
            return "Username is already taken.";
        }

        if ($this->isEmailTaken($email)) {
            return "Email is already registered.";
        }

        $query = "INSERT INTO buyer (username, first_name, last_name, email, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssss", $userName, $firstName, $lastName, $email, $hashed_password);
        $result = $stmt->execute();

        if ($result) {
            $confirmationCode = rand(1000, 9999);
            session_start();
            $_SESSION['verification_code'] = $confirmationCode;
            $_SESSION['email'] = $email;

            if ($this->storeConfirmationCode($email, $confirmationCode)) {
                $this->sendVerificationEmail($email, $firstName, $lastName, $confirmationCode);
            }

            return "Registration Successful. A verification email has been sent.";
        } else {
            return "Registration failed: " . $this->conn->error;
        }
    }

    public function storeConfirmationCode($email, $confirmationCode) {
        $query = "UPDATE buyer SET verification_code = ? WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("is", $confirmationCode, $email);
        return $stmt->execute();
    }

    public function sendVerificationEmail($email, $first_name, $last_name, $confirmationCode) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->SMTPAuth   = true;
            $mail->Host       = 'smtp.gmail.com';
            $mail->Username   = 'smartmarket0324@gmail.com'; // Your Gmail address
            $mail->Password   = 'yurb bjil dilf ypok'; // Your Gmail app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('smartmarket0324@gmail.com', 'SmartMarket');
            $mail->addAddress($email, $first_name . ' ' . $last_name);

            $mail->isHTML(true);
            $mail->Subject = 'Verification Code';
            $mail->Body = "<h3>Dear $first_name,</h3>
                           <p>Your confirmation code is: <strong>$confirmationCode</strong></p>
                           <p>From,<br>SmartMarket</p>";

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

class SellerAccount extends Account {
    public function createAccount($username, $email, $password, $confirmPassword, $store_name, $buyerID) {
        $username = htmlspecialchars(trim($username));
        $email = htmlspecialchars(trim($email));
        $store_name = htmlspecialchars(trim($store_name));
        $buyerID = intval($buyerID);

        if (!$this->validateUsername($username)) {
            return "Username must be between 5 and 20 characters and can only contain letters, numbers, and underscores.";
        }

        if (!$this->validateEmail($email)) {
            return "Use your G-suite account.";
        }

        if (!$this->validatePassword($password, $confirmPassword)) {
            return "Passwords do not match.";
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->conn->prepare("INSERT INTO seller (username, email, password, shop_name, buyer_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $username, $email, $hashedPassword, $store_name, $buyerID);

        if ($stmt->execute()) {
            return "Seller account created successfully!";
        } else {
            return "Error: " . $stmt->error;
        }
    }
}

class UserLogin extends Account {
    public function __construct($dbConnection) {
        parent::__construct($dbConnection); // call the parent constructor
    }


    public function login($email, $password) {
        $sql = $this->conn->prepare("SELECT * FROM buyer WHERE email = ?");
        $sql->bind_param("s", $email);
        $sql->execute();
        $result = $sql->get_result();

        if ($result->num_rows > 0) {
            $buyer = $result->fetch_assoc();
            

            if (password_verify($password, $buyer['password'])) {

                session_start();//login successfuk
                $_SESSION['buyer_id'] = $buyer['buyer_id']; // store user ID in session
                $_SESSION['email'] = $buyer['email']; // store email in session
                
                // store address in session
                $_SESSION['address'] = $buyer['address']; 

                return true; 
            } else {
                return false; //if passowrd is not correct
            }
        } else {
            return false; //if user not found
        }
    }
}
?>
?>