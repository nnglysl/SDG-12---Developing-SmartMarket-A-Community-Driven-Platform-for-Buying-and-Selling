<?php

    include '../db/dbcon.php'; // Include your database connection
    include('../header/header.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department Shirts</title>
    <link rel="stylesheet" href="/final/view_shop/view_shop_colleen.css"> 
    <link href="https://fonts.google.com/specimen/Nanum+Gothic" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="/final/css/nav.css">
</head>
<body>
    
    <!-- Seller Profile Section -->
    <section class="seller-profile">
        <img src="/final/imgs/sellerpics/deptshirt.avif" alt="User Logo" class="seller-logo">
        <div class="seller-info">
            <h2>Colleen Perez</h2>
            <a href="/final/contact/contact_colleen.php"><button class="chat-button"><i class='bx bx-chat'></i> Contact us</button></a>
        </div>
    </section>

    <div class="center-container">
        <h2>ALL PRODUCTS</h2>
        
    <!-- Products Section -->
    <section class="shop-section">
        <div class="products">
            <!-- First Row of Products -->
            <div class="product">
                <a href="/final/items/calcu/calcu.php">
                    <img src="/final/imgs/school supplies/calcu.png" alt="Calculator">
                    <h3>Casio Scientific Calculator</h3>
                    <p>₱ 500.00</p>
                </a>
            </div>
            <div class="product">
                <a href="/final/items_uniforms/blouse/blouse.php">
                    <img src="/final/imgs/uniforms/blouse.jpg" alt="Blouse">
                    <h3>Preloved College Blouse</h3>
                    <p>₱ 250.00</p>
                </a>
            </div>
            <div class="product">
                <a href="/final/items/binder/binder.php">
                    <img src="/final/imgs/school supplies/binder.jpg" alt="Binder">
                    <h3>B5 Binder Notebook</h3>
                    <p>₱ 70.00</p>
                </a>
            </div>
        </div>

        <div class="products">
            <!-- Second Row of Products -->
            <div class="product">
                <a href="/final/items_uniforms/peunif/peunif.php">
                    <img src="/final/imgs/uniforms/peunif.png" alt="PE Uniform">
                    <h3>Preloved PE Uniform Set</h3>
                    <p>₱ 400.00</p>
                </a>
            </div>
            
           
        
    </div>
</body>
</html>
