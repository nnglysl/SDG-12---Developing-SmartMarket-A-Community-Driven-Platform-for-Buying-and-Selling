<?php
include '../db/dbcon.php';

$db = new Database();
$conn = $db->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $stmt = $conn->prepare("INSERT INTO contact_submissions (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        echo "<script>alert('Message sent successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact</title>
    <link rel="stylesheet" href="/final/contact/contact_rgo.css" />
    <link href="https://fonts.google.com/specimen/Nanum+Gothic" rel="stylesheet"/>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css"/>
    <link rel="stylesheet" href="/final/css/nav.css" />
  </head>
  <body>
    <header>
      <img src="/final/imgs/mainpagelogo.png" alt="Logo" class="logo" />
      <ul class="nav">
        <li><a href="/final/home/home.php">HOME</a></li>
        <li><a href="/final/shop/school_supplies/school supplies.php">SHOP</a></li>
      </ul>
      <div class="search-container">
        <input type="text" id="product-search" class="search-bar" name="query" placeholder="Search"/>
        <button type="submit" class="search-button">
          <i class="bx bx-search"></i>
        </button>
        <ul id="dropdown-results" class="dropdown-results"></ul>
      </div>
      <div class="navicon">
        <a href="/final/profile/profile.php"><i class="bx bx-user"></i></a>
        <a href="#"><i class="bx bx-cart"></i></a>
      </div>
    </header>

    <div class="contact-container">
      <form action="https://formsubmit.co/23-32379@g.batstate-u.edu.ph" method="POST" class="contact"> 
        <div class="contact-title">
          <h1>Get in touch</h1>
          <hr>
        </div>
        <input type="text" name="name" placeholder="Your Name" class="contact-input" required>
        <input type="email" name="email" placeholder="Your Email" class="contact-input" required>
        <textarea name="message" placeholder="Your Message" class="contact-input" required></textarea>
        <button type="submit">Submit</button>
      </form>
    </div>
  </body>
</html>
