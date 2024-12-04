<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .sidebar {
    width: 250px;
    background-color: #222;
    color: white;
    height: 100%;
    position: fixed;
    top: 0;
    left: 0;
    padding-top: 50px;
}

.sidebar ul {
    list-style-type: none;
    padding: 0;
}

.sidebar-item {
    text-decoration: none;
    color: white;
    display: block;
    padding: 15px 20px;
    font-size: 1.1rem;
    transition: background-color 0.3s ease, color 0.3s ease;
}


.sidebar-item:hover {
    background-color: #ffb6c1;
    color: #333;
}

.sidebar-item i {
    margin-right: 10px;
    font-size: 1.2rem;
}

/* Reset default margins and paddings */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

    </style>
</head>
<body>
        <div class="sidebar">
            <ul>
                <li><a href="../courier/courierdashboard.php" class="sidebar-item"><i class="fas fa-times-circle"></i>To Receive</a></li>
                <li><a href="../courier/deliveredorder.php" class="sidebar-item"><i class="fas fa-times-circle"></i>Completed</a></li>
                <li><a href="../logout/logout.php" class="sidebar-item"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
</body>
</html>
