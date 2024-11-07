<?php 
include_once('dbprofile.php'); 
// Configuration
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'smartmarket';

// Create connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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

    // Prepare an SQL statement
    if ($stmt = $conn->prepare("UPDATE buyer SET first_name = ?, last_name = ?, username = ?, gender = ?, phone_number = ?, email = ? WHERE buyer_id = ?")) {
        
        // Assuming you have the user ID stored in a session
        $buyerId = $_SESSION['buyer_id']; // Make sure this session variable is set

        // Bind parameters
        $stmt->bind_param("ssssssi", $firstName, $lastName, $username, $gender, $phone, $email, $buyerId);

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
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="editprofile.css" />
</head>
<body>

<div class="container">
    <h2>Edit Profile</h2>
    <!-- Display the message -->
    <?php if (!empty($message)): ?>
        <div class="message">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>
    <form id="profileForm" method="POST" action="">
        <div class="field-container">
            <div>
                <strong>Name:</strong>
                <div class="editable" id="nameDisplay"><?php echo htmlspecialchars($buyer['first_name']); ?>  <?php echo htmlspecialchars($buyer['last_name']); ?></div>
                <input type="text" id="name" name="name" class="hidden" value="<?php echo htmlspecialchars($buyer['first_name'] . ' ' . $buyer['last_name']); ?>" onblur="saveField('name')" onkeypress="if(event.key === 'Enter'){ saveField('name'); }">
            </div>
            <button type="button" class="edit-btn" onclick="editField('name')"><i class="fa-solid fa-pen-to-square"></i></button>
        </div>
        <div class="field-container">
            <div>
                <strong>Username:</strong>
                <div class="editable" id="usernameDisplay"><?php echo htmlspecialchars($buyer['username']); ?></div>
                <input type="text" id="username" name="username" class="hidden" value="<?php echo htmlspecialchars($buyer['username']); ?>" onblur="saveField('username')" onkeypress="if(event.key === 'Enter'){ saveField('username '); }">
            </div>
            <button type="button" class="edit-btn" onclick="editField('username')"><i class="fa-solid fa-pen-to-square"></i></button>
        </div>
        <div class="field-container">
            <div>
                <strong>Gender:</strong>
                <div class="editable" id="genderDisplay"><?php echo htmlspecialchars($buyer['gender']); ?></div>
                <select id="gender" name="gender" class="hidden" onblur="saveField('gender')" onchange="saveField('gender')">
                    <option value="male" <?php echo ($buyer['gender'] == 'male') ? 'selected' : ''; ?>>Male</option>
                    <option value="female" <?php echo ($buyer['gender'] == 'female') ? 'selected' : ''; ?>>Female</option>
                    <option value="other" <?php echo ($buyer['gender'] == 'other') ? 'selected' : ''; ?>>Other</option>
                </select>
            </div>
            <button type="button" class="edit-btn" onclick="editField('gender')"><i class="fa-solid fa-pen-to-square"></i></button>
        </div>
        <div class="field-container">
            <div>
                <strong>Phone:</strong>
                <div class="editable" id="phoneDisplay"><?php echo htmlspecialchars($buyer['phone_number']); ?></div>
                <input type="tel" id="phone" name="phone" class="hidden" value="<?php echo htmlspecialchars($buyer['phone_number']); ?>" onblur="saveField('phone')" onkeypress="if(event.key === 'Enter'){ saveField('phone'); }">
            </div>
            <button type="button" class="edit-btn" onclick="editField('phone')"><i class="fa-solid fa-pen-to-square"></i></button>
        </div>
        <div class="field-container">
            <div>
                <strong>Email:</strong>
                <div class="editable" id="emailDisplay"><?php echo htmlspecialchars($buyer['email']); ?></div>
                <input type="email" id="email" name="email" class="hidden" value="<?php echo htmlspecialchars($buyer['email']); ?>" onblur="saveField('email')" onkeypress="if(event.key === 'Enter'){ saveField('email'); }">
            </div>
            <button type="button" class="edit-btn" onclick="editField('email')"><i class="fa-solid fa-pen-to-square"></i></button>
        </div>
        <div class="form-buttons">
            <a href="profile.html" class="back-button">Back</a>
            <button type="submit" name="save">Save Changes</button>
        </div>
    </form>
</div>

<script src="editprofile.js"></script> 

</body>
</html>