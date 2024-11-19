<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Profile - Desktop View</title>
    <link rel="stylesheet" href="selleraccount.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
</head>
<body>
<header>

    <img src="/imgs/mainpagelogo.png" alt="Logo" class="logo">
    <ul class="nav">
        <li><a href="/home/home.html">HOME</a></li>
        <li><a href="/shop/school_supplies/school supplies.html">MANAGE SHOP</a></li>
    </ul>
    <!-- Search Bar -->
    <div class="search-container">
        <input type="text" placeholder="Search" class="search-bar">
        <button type="submit" class="search-button"><i class='bx bx-search'></i></button>
    </div>
    <div class="navicon">
        <a href="/profile/profile.html"><i class='bx bx-user'></i></a>
        <a href="#"><i class='bx bx-cart'></i></a>
    </div>
</header>

<div class="profile-container">
    <div class="profile-header">
        <div class="profile-pic">
            <img src="user.jpg" alt="Seller Profile Picture">
        </div>
        <div class="profile-info">
            <h2><?php echo htmlspecialchars($seller['username']); ?></h2>
            <p>Seller's Account</p>
            <div class="contact-info">
            </div>
        </div>
        <div class="edit-profile">
            <a href="editprofile.php"><i class="fas fa-edit"></i> Edit Profile</a>
        </div>
    </div>

    <div class="profile-nav">
        <a href="createProduct.html"><i class="fas fa-box"></i> Add Product </a>
    </div>
    <!-- Account Details Section -->
    <div class="account-details">
        <div class="orders">
            <label><i class="fas fa-clipboard-list"></i> Orders</label>
        </div>
        <div class="products">
            <label><i class="fas fa-box"></i> Products</label>
        </div>
        <div class="earnings">
            <label><i class="fas fa-dollar-sign"></i> Earnings</label>
        </div>
    </div>
</div>


</body>
</html>














