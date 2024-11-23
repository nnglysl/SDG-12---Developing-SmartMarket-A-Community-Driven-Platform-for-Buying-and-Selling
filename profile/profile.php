<?php
require_once '../db/dbprofile.php';
require_once 'switchaccount.php'; // Include the AccountSwitcher class

$profile = new EditProfile();
$buyer = $profile->getBuyer();

$message = $profile->updateProfile();

// Create an instance of the AccountSwitcher class
$accountSwitcher = new AccountSwitcher();

// Call the method to switch account only if a specific action is triggered
if (isset($_POST['switch_account'])) {
    $accountSwitcher->switchAccount();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Desktop View</title>
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" />
    <link rel="stylesheet" href="../css/nav.css" />

</head>

<body>
    <?php include('../header/header.php'); ?>
    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-pic">
<<<<<<< HEAD
                <img src="user.jpg" alt="<?php echo htmlspecialchars($buyer['username']); ?>">
                <!-- Use user's name as alt text -->
=======
                <img src="user.jpg" alt="<?php echo htmlspecialchars($buyer['username']); ?>"> <!-- Use user's name as alt text -->
>>>>>>> d4b3911f02e1ce4b4ec13ff391a248cfa6225f7e
            </div>
            <div class="profile-info">
                <h2><?php echo htmlspecialchars($buyer['username']); ?></h2> <!-- Display user's name -->
                <p>Buyer's Account</p>
                <div class="contact-info">
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($buyer['email']); ?></p>
                    <p><strong>Phone:</strong> <?php echo htmlspecialchars($buyer['phone_number']); ?></p>
                </div>
            </div>
            <div class="edit-profile">
                <a href="editprofile.php"><i class="fas fa-edit"></i> Edit Profile</a>
            </div>
        </div>
        <div class="account-details">
            <div class="account-section ship">
                <label><i class="fas fa-inbox"></i> To Ship</label>
                <p>No items to ship.</p>
            </div>
            <div class="account-section receive">
                <label><i class="fas fa-truck"></i> To Receive</label>
                <p>No items to receive.</p>
            </div>
        </div>
        <div class="switch-account">
            <p>Want to sell? Switch to your Seller Account:</p>
            <form method="post">
                <button type="submit" name="switch_account">Switch to Seller Account</button>
            </form>
        </div>
    </div>
</body>
</html>