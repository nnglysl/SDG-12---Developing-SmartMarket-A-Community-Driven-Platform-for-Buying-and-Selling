<?php 
require_once 'dbprofile.php';

$editProfile = new EditProfile();
$message = $editProfile->updateProfile();
$buyer = $editProfile->getBuyer(); 


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css"/>
    <link rel="stylesheet" href="editprofile.css">
    <link rel="stylesheet" href="../css/nav.css" />
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
            <a href="profile.php" class="back-button">Back</a>
            <button type="submit" name="save">Save Changes</button>
        </div>
    </form>
</div>

<script src="editprofile.js"></script> 

</body>
</html>