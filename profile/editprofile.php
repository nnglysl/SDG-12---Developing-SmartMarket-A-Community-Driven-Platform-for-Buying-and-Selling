<?php
require_once '../db/Userprofile.php';

$editProfile = new UserAccount();
$message = "";
$buyer = $editProfile ->getBuyer();
// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    $message = $editProfile->updateProfile($_POST);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {
    $targetDir = '../uploads/';
    $targetFile = $targetDir . uniqid() . '_' . basename($_FILES["profile_picture"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    if ($_FILES["profile_picture"]["error"] !== UPLOAD_ERR_OK) {
        $message = "File upload error: " . $_FILES["profile_picture"]["error"];
        $uploadOk = 0;
    }

    if ($uploadOk && ($check = getimagesize($_FILES["profile_picture"]["tmp_name"])) === false) {
        $message = " File is not an image.";
        $uploadOk = 0;
    }

    if ($uploadOk && $_FILES["profile_picture"]["size"] > 5000000) {
        $message = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    if ($uploadOk && !in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
        $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if (!is_writable($targetDir)) {
        die("The uploads directory is not writable. Please check permissions.");
    }

    if ($uploadOk === 0) {
        $message = "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFile)) {
            $editProfile->saveProfilePicture($targetFile);
            $message = "The file " . htmlspecialchars(basename($_FILES["profile_picture"]["name"])) . " has been uploaded.";
        } else {
            $message = "Sorry, there was an error uploading your file.";
        }
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
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css"/>
    <link rel="stylesheet" href="../css/nav.css" />
    <link rel="stylesheet" href="../css/editprofile.css" />

</head>
<body>
    <?php include('../header/header.php'); ?>

<div class="container">
    <h2>Edit Profile</h2>
    <?php if (!empty($message)): ?>
        <div class="message">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>
    <form id="profileForm" method="POST" action="" enctype="multipart/form-data"> <!-- Added enctype for file upload -->

        <div class="field-container">
            <div>
                <strong>Profile Picture:</strong>
                <input type="file" name="profile_picture" accept="image/*">
            </div>
        </div>

        <div class="field-container">
            <div>
                <strong>Username:</strong>
                <div class="editable" id="usernameDisplay"><?php echo htmlspecialchars($buyer['username']); ?></div>
                <input type="text" id="username" name="username" class="hidden" value="<?php echo htmlspecialchars($buyer['username']); ?>" onblur="saveField('username')" onkeypress="if(event.key === 'Enter'){ saveField('username'); }">
            </div>
            <button type="button" class="edit-btn" onclick="editField('username')"><i class="fa-solid fa-pen-to square"></i></button>
        </div>
        <div class="field-container">
            <div>
                <strong>Address:</strong>
                <div class="editable" id="addressDisplay"><?php echo htmlspecialchars($buyer['address']); ?></div>
                <input type="text" id="address" name="address" class="hidden" value="<?php echo htmlspecialchars($buyer['address']); ?>" onblur="saveField('address')" onkeypress="if(event.key === 'Enter'){ saveField('address'); }">
            </div>
            <button type="button" class="edit-btn" onclick="editField('address')"><i class="fa-solid fa-pen-to-square"></i></button>
        </div>
        <div class="form-buttons">
            <button type="submit" name="save">Save Changes</button>
        </div>
    </form>
</div>

<script src="editprofile.js"></script> 

</body>
</html>