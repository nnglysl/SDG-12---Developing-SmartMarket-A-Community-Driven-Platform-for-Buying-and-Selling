<?php
require_once '../db/dbprofile.php';
require_once 'switchaccount.php'; 
require_once 'buyerorder.php';

$profile = new EditProfile();
$buyer = $profile->getBuyer();

$message = $profile->updateProfile();

$accountSwitcher = new AccountSwitcher();

if (isset($_POST['switch_account'])) {
    $accountSwitcher->switchAccount();
}

$buyerOrder = new BuyerOrder();
$buyerId = $_SESSION['buyer_id'];

$shipCount = $buyerOrder->countShipOrders($buyerId);
$receivedCount = $buyerOrder->countReceivedOrders($buyerId);
$deliveredCount = $buyerOrder->countDeliveredOrders($buyerId);
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
    <link rel="stylesheet" href="../css/nav.css"/>
    <style>
       /* Global Styles */
/* Global Styles */
body {
    font-family: 'Arial', sans-serif; /* Clean sans-serif font */
    background-color: #ffeef2; /* Soft light pink background */
    margin: 0;
    padding: 20px;
}

/* Header Right Button */
.header-right {
    display: flex;
    justify-content: flex-end;
    margin-top: 70px; /* Space below the header */
}

/* Switch Account Button */
.switch-account {
    padding: 10px 20px; /* Increased padding for better touch area */
    background-color: #fcfcfc; /* Light gray background */
    color: rgb(0, 0, 0);
    border: none;
    border-radius: 5px;
    cursor: pointer;
    display: flex;
    align-items: center;
    transition: background-color 0.3s ease; /* Smooth transition */
    position: relative; /* Position relative for z-index */
    z-index: 1; /* Ensure it is above other elements */
}

.switch-account .icon {
    margin-right: 5px;
    font-size: 18px;
}

/* Button hover effect */
.switch-account:hover {
    background-color: #f546ac; /* Light pink background on hover */
    color: #000; /* Change text color to black on hover */
}

.switch-account:active {
    background-color: #fa36a8; /* Darker pink when pressed */
}

/* Profile Container */
.profile-container {
    max-width: 800px; /* Set a maximum width for the profile */
    margin: 0 auto; /* Center the container */
    background: #ffffff; /* White background for contrast */
    border-radius: 10px; /* Rounded corners */
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    padding: 30px; /* Padding inside the container */
}

/* Profile Header */
.profile-header {
    text-align: center; /* Center text in the header */
    margin-bottom: 20px; /* Space below the header */
}

.profile-pic img {
    width: 120px; /* Set width of profile picture */
    height: 120px; /* Set height of profile picture */
    border-radius: 50%; /* Make the image circular */
}

.profile-info h2 {
    margin: 10px 0; /* Spacing around the name */
    font-size: 1.8rem; 
    color: #333333; /
}

.profile-info p {
    color: #666666;
    font-size: 1rem; 
}

.edit-profile {
    margin-top: 20px; /
}

.edit-profile a {
    color: #ffffff; 
    text-decoration: none; 
    font-size: 1rem; 
    padding: 12px 24px; 
    border-radius: 30px; 
    background: #333333; 
    box-shadow: 0 5px 10px rgba(51, 51, 51, 0.2); 
    transition: all 0.3s ease; 
    display: inline-block;
}

.edit-profile a:hover {
    background: #555555; 
    box-shadow: 0 8px 15px rgba(51, 51, 51, 0.3); 
    transform: translateY(-2px); 
}


.account-details {
    display: flex; 
    justify-content: space-between; 
    margin-top: 30px;
    
}

.account-section {
    background: #f8f8f8; 
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1); 
    padding: 20px; 
    border-radius: 10px; 
    width: 48%; 
    transition: all 0.3s ease; 
    
}

.account-section:hover {
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2); 
    transform: translateY(-2px);
}


.account-section label {
    font-weight: bold; 
    font-size: 1.2rem; 
    display: block;
}

.account-section p {
    margin-top: 5px; /* Space above the paragraph */
    color: #666666; /* Medium gray for the text */
}

/* Responsive adjustments */
@media (max-width: 600px) {
    .account-details {
        flex-direction: column; /* Stack account sections on smaller screens */
    }

    .account-section {
        width: 90%; /* Full width on mobile */
        margin: 10px auto; /* Center with auto margins */
    }

    .profile-info h2 {
        font-size: 1.5rem; /* Smaller font size on mobile */
    }
}
    </style>

</head>

<body>
    <?php include('../header/header.php'); ?>
    
    <div class="header-right">
        <form action="" method="post">
            <input type="hidden" name="buyer_id" value="<?php echo htmlspecialchars($buyer['buyer_id']); ?>">
            <button type="submit" name="switch_account" class="switch-account" >
            <span class="icon">&#x1F464;</span> Switch Account
            </button>
        </form>
    </div>
    
    <div class="profile-container">

        <div class="profile-header">
        <div class="profile-pic">
            <?php 
                $profilePicturePath = htmlspecialchars($buyer['profile_picture']);
                $fullPath = $profilePicturePath;

                if (file_exists($fullPath)) {
                    echo '<img src="' . $profilePicturePath . '" alt="' . htmlspecialchars($buyer['username']) . '">';
                } else {
                    // Fallback image if the profile picture does not exist
                    echo '<img src="uploads/default_profile.png" alt="Default Profile Picture">';
                }
            ?>
        </div>
            <div class="profile-info">
                <h2><?php echo htmlspecialchars($buyer['username']); ?></h2> <!-- Display user's name -->
                <p>Buyer's Account</p>
                <div class="contact-info">
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($buyer['email']); ?></p>
                </div>
            </div>
            <div class="edit-profile">
                <a href="editprofile.php"><i class="fas fa-edit"></i> Edit Profile</a>
            </div>
        </div>
            <div class="account-details">
                <div class="account-section">
                    <a href="buyertoship.php">
                        <label><i class="fas fa-inbox"></i> To Ship</label>
                        <p><?php echo $shipCount > 0 ? $shipCount . ' items to ship.' : 'No items to ship.'; ?></p>
                    </a>
                </div>
                <div class="account-section">
                    <a href="buyerreceived.php">
                        <label><i class="fas fa-truck"></i> To Receive</label>
                        <p><?php echo $receivedCount > 0 ? $receivedCount . ' items to receive.' : 'No items to receive.'; ?></p>
                    </a>
                </div>
                <div class="account-section">
                    <a href="buyercompleteorder.php">
                        <label><i class="fas fa-check-circle"></i> Completed</label>
                        <p><?php echo $deliveredCount > 0 ? $deliveredCount . ' items completed.' : 'No items completed.'; ?></p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>