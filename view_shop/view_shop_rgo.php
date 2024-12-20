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
    <link rel="stylesheet" href="/final/view_shop/view_shop_rgo.css"> 
    <link href="https://fonts.google.com/specimen/Nanum+Gothic" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="/final/css/nav.css">
</head>
<body>
    
    <!-- Seller Profile Section -->
    <section class="seller-profile">
        <img src="/final/imgs/sellerpics/rgo.jfif" alt="Resource Generation Office Logo" class="seller-logo">
        <div class="seller-info">
            <h2>Resource Generation Office</h2>
            <a href="/final/contact/contact_rgo.php"><button class="chat-button"><i class='bx bx-chat'></i> Contact us</button></a>
        </div>
    </section>

    <div class="center-container">
        <h2>ALL PRODUCTS</h2>
        
    <!-- Products Section -->
    <section class="shop-section">
        <div class="products">
            <!-- First Row of Products -->
            <div class="product">
                <a href="/final/items_deptshirt/cics/cics.php">
                    <img src="/final/imgs/department shirts/cics.png" alt="CICS Department Shirt">
                    <h3>CICS Department Shirt</h3>
                    <p>₱ 500.00</p>
                </a>
            </div>
            <div class="product">
                <a href="/final/items_deptshirt/cas/cas.php">
                    <img src="/final/imgs/department shirts/cas.png" alt="CAS Department Shirt">
                    <h3>CAS Department Shirt</h3>
                    <p>₱ 500.00</p>
                </a>
            </div>
            <div class="product">
                <a href="/final/items_deptshirt/cabe/cabe.php">
                    <img src="/final/imgs/department shirts/cabe.png" alt="CABE Department Shirt">
                    <h3>CABE Department Shirt</h3>
                    <p>₱ 500.00</p>
                </a>
            </div>
        </div>

        <div class="products">
            <!-- Second Row of Products -->
        <div class="product">
            <a href="/final/items_uniforms/collarpin/collarpin.php">
                <img src="/final/imgs/uniforms/collarpin.jfif" alt="Collar Pin">
                <h3>Second hand University Collar Pin</h3>
                <p>₱ 50.00</p>
            </a>
        </div>
        <div class="product">
            <a href="/final/items/idlace/idlace.php">
                <img src="/final/imgs/school supplies/idlace.jpg" alt="ID Lace">
                <h3>ID Lace</h3>
                <p>₱ 50.00</p>
            </a>
        </div>
        
    </div>
</body>
</html>
