<?php
require_once __DIR__ . '/../db/dbcon.php'; 
require_once 'verifycode.php'; 

$message = ""; //put message as null 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect input from the 6 fields
    $verification_code = $_POST['verification_code']; //ippost yung 6 na opt or input ng user
    
    if (strlen($verification_code) !== 4) { //check if the length is not equal to 6 but the same data type
        $message = "Verification code must be 4 digits.";
    } else {
        $verification = new Verification($verification_code); // verification class
        $message = $verification->verifyAccount($verification_code); //input the verification code
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 400px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 8px;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Enter Your Verification Code</h2>
        <form action="" method="post">
            <label for="verification_code">Verification Code:</label>
            <input type="text" id="verification_code" name="verification_code" required>
            <input type="submit" value="Verify">
        </form>
    </div>
</body>
</html>