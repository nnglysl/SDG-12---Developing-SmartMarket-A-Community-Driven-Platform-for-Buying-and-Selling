<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex; /* Use flexbox to create a layout */
        }
        header {
            background: #333;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
            flex: 1; /* Allow header to take full width */
        }
        nav {
            width: 200px; /* Fixed width for sidebar */
            background: #444; /* Sidebar background color */
            height: 100vh; /* Full height */
            position: fixed; /* Fixed position */
            padding-top: 20px; /* Padding at the top */
        }
        nav ul {
            list-style: none;
            padding: 0;
        }
        nav ul li {
            margin: 15px 0;
        }
        nav ul li a {
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            display: block; /* Make links block elements */
            transition: background 0.3s; /* Smooth background transition */
        }
        nav ul li a:hover {
            background: #555; /* Change background on hover */
        }
        main {
            margin-left: 220px; /* Leave space for the sidebar */
            padding: 20px;
            flex: 1; /* Allow main to take remaining space */
        }
        section {
            margin-bottom: 20px;
            background: #fff;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .profile-card, .product-card {
            padding: 15px;
            background: #e9e9e9;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .product-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .product-card img {
            max-width: 100px;
            margin-right: 10px;
        }
        footer {
            text-align: center;
            padding: 10px 0;
            background: #333;
            color: #fff;
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <nav>
        <h1>Seller Dashboard</h1>
        <ul>
            <li><a href="#profile">Profile</a></li>
            <li><a href="addproduct.phpt">Add Product</a></li>
            <li><a href="earnings.php">Earnings</a></li>
            <li><a href="#shop-management">Shop Management</a></li>
        </ul>
    </nav>


    <main>
        <section id="profile">
            <h2>Seller Profile</h2>
            <div class="profile-card">
                <h3>Seller Name: <span id="seller-name">John Doe</span></h3>
                <p>Email: <span id="seller-email">john@example.com</span></p>
                <p>Shop Name: <span id="shop-name">John's Shop</span></p>
                <p>Rating: <span id="seller-rating">4.5</span> ⭐</p>
            </div>
        </section>

        <section id="shop-management">
            <h2>Shop Management</h2>
            <div class="product-cards">
                <!-- Example product card -->
                <div class="product-card">
                    <img src="product-image .jpg" alt="Product Image">
                    <div>
                        <h4>Product Name</h4>
                        <p>Price: $<span>29.99</span></p>
                    </div>
                    <div>
                        <button>Edit</button>
                        <button>Delete</button>
                    </div>
                </div>
                <!-- Add more product cards dynamically here -->
            </div>
        </section>
    </main>

</body>
</html> 