<?php
require_once '../db/Userprofile.php';
require_once 'buyerorder.php';

// Create an instance of UserAccount
$profile = new UserAccount();
$buyer = $profile->getBuyer();

$message = "";

if (isset($_POST['switch_account'])) {//check if submitted
    $profile->switchAccount();
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" />
    <link rel="stylesheet" href="../css/nav.css"/>
    <link rel="stylesheet" href="../css/profile.css"/>

</head>

<body>
    <?php include('../header/header.php'); ?>
    
    <div class="header-right">
        <form action="" method="post">
            <input type="hidden" name="buyer_id" value="<?php echo htmlspecialchars($buyer['buyer_id']); ?>">
            <button type="submit" name="switch_account" class="switch-account" >
            <span class="icon">&#x1F464;</span> Switch to Seller
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