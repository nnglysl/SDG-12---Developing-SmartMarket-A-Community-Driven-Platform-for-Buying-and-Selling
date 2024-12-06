<?php
require_once '../db/dbprofile.php';

$editProfile = new EditProfile();
$message = $editProfile->updateProfile();
$buyer = $editProfile->getBuyer();

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {
    $targetDir = '../uploads/'; // Use absolute path
    $targetFile = $targetDir . uniqid() . '_' . basename($_FILES["profile_picture"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check for upload errors
    if ($_FILES["profile_picture"]["error"] !== UPLOAD_ERR_OK) {
        $message = "File upload error: " . $_FILES["profile_picture"]["error"];
        $uploadOk = 0;
    }

    // Check if image file is a actual image or fake image
    if ($uploadOk && ($check = getimagesize($_FILES["profile_picture"]["tmp_name"])) === false) {
        $message = "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size (5MB limit)
    if ($uploadOk && $_FILES["profile_picture"]["size"] > 5000000) {
        $message = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($uploadOk && !in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
        $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if target directory is writable
    if (!is_writable($targetDir)) {
        die("The uploads directory is not writable. Please check permissions.");
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk === 0) {
        $message = "Sorry, your file was not uploaded.";
    } else {
        // If everything is ok, try to upload file
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
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" />
    <link rel="stylesheet" href="../css/nav.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffeef2;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 150px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #000;
        }

        .editable {
            display: inline-block;
            padding: 10px;
            margin: 10px 0;
            border: none;
            background: none;
            color: #555;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            text-align: left;
            border-bottom: 1px dashed #ccc;
            /* Visual cue for editability */
        }

        .editable:hover {
            background-color: #f0f0f0;
        }

        .hidden {
            display: none;
        }

        .form-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .form-buttons button {
            width: 48%;
            /* Adjusted for spacing */
            padding: 10px;
            background-color: #c2adad;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .form-buttons .back-button {
            background-color: #d3d3d3;
            color: #000;
        }

        .form-buttons .back-button:hover {
            background-color: #b0b0b0;
        }

        a {
            text-decoration: none;
            text-align: center;
        }

        .edit-btn {
            padding: 0px 10px;
            background-color: #ffffff;
            color: rgb(0, 0, 0);
            border: none;
            border-radius: 4px;
            font-size: 18px;
            cursor: pointer;
        }

        .edit-btn:hover {
            background-color: #bdc1c5;
            transform: translateY(-2px);
        }

        .field-container {
            margin-bottom: 15px;
        }

        .field-container div {
            display: inline-block;
            width: 75%;
        }

        .field-container button {
            width: 20%;
            /* Set width of the edit button */
            display: inline-block;
        }

        .message {
            display: none;
            /* Initially hide the message */
            padding: 10px;
            margin: 10px 0;
            border: 1px solid transparent;
            border-radius: 5px;
            color: #fff;
            /* Text color */
            text-align: center;
        }

        .message.success {
            background-color: #28a745;
            /* Green for success */
            border-color: #28a745;
            /* Match border to background */
        }

        .message.error {
            background-color: #dc3545;
            /* Red for error */
            border-color: #dc3545;
            /* Match border to background */
        }
    </style>
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
        <form id="profileForm" method="POST" action="" enctype="multipart/form-data">
            <!-- Added enctype for file upload -->

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
                    <input type="text" id="username" name="username" class="hidden"
                        value="<?php echo htmlspecialchars($buyer['username']); ?>" onblur="saveField('username')"
                        onkeypress="if(event.key === 'Enter'){ saveField('username'); }">
                </div>
                <button type="button" class="edit-btn" onclick="editField('username')"><i
                        class="fa-solid fa-pen-to-square"></i></button>
            </div>
            <div class="field-container">
                <div>
                    <strong>Address:</strong>
                    <div class="editable" id="addressDisplay"><?php echo htmlspecialchars($buyer['address']); ?></div>
                    <input type="text" id="address" name="address" class="hidden"
                        value="<?php echo htmlspecialchars($buyer['address']); ?>" onblur="saveField('address')"
                        onkeypress="if(event.key === 'Enter'){ saveField('address'); }">
                </div>
                <button type="button" class="edit-btn" onclick="editField('address')"><i
                        class="fa-solid fa-pen-to-square"></i></button>
            </div>
            <div class="form-buttons">
                <button type="submit" name="save">Save Changes</button>
            </div>
        </form>
    </div>

    <script src="editprofile.js"></script>

</body>

</html>