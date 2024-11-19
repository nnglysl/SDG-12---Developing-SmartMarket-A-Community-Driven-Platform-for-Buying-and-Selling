<?php
require_once '../dbcon.php';
require_once 'dbprofile.php'; 

$profile = new EditProfile();
$buyer = $profile->getBuyer();

$message = $profile->updateProfile();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Desktop View</title>
    <link rel="stylesheet" href="/final/profile/profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
</head>
<body>
<header>
        <img src="/imgs/mainpagelogo.png" alt="Logo" class="logo">

        <ul class="nav">
            <li><a href="/home/home.html">HOME</a></li>
            <li><a href="/shop/school_supplies/school supplies.html">SHOP</a></li>
        </ul>
        <!-- Search Bar -->
        <div class="search-container">
            <input type="text" placeholder="Search" class="search-bar">
            <button type="submit" class="search-button"><i class='bx bx-search'></i></button>
        </div>

        <div class="navicon">
            <a href="/profile/profile.php"><i class='bx bx-user'></i></a>
            <a href="#"><i class='bx bx-cart'></i></a>
        </div>
    </header>
    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-pic">
                <img src="/final/imgs/user.jpg" alt=""> <!-- Use user's name as alt text -->
            </div>
            <div class="profile-info">
                <h2><?php echo htmlspecialchars($buyer['username']); ?></h2> <!-- Display user's name -->
                <p>Buyer's Account</p>
                <div class="contact-info">
                    <!-- You can add more user information here if needed -->
                </div>
            </div>
            <div class="edit-profile">
                <a href="editprofile.php"><i class="fas fa-edit"></i>Edit Profile</a>
            </div>
        </div>

        <!-- Navigation Bar (moved to the top of the profile) -->
        <div class="profile-nav">
                <a href="createShop.php"><i class="fas fa-store"></i>  Create Shop </a>
        </div>
        <div class="account-details">
            <div class="ship">
                <label><i class="fas fa-inbox"></i> To Ship</label>
            </div>
            <div class="receive">
                <label><i class="fas fa-truck"></i> To Receive</label>
            </div>
            <div class="rate">
                <label><i class="fas fa-star"></i> To Rate</label>
            </div>
        </div>

    </div>

</body>
</html>