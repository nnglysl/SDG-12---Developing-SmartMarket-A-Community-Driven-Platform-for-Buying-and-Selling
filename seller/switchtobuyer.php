<?php
session_start(); 
require_once '../db/dbdashboard.php';

if (!isset($_SESSION['buyer_id'])) {

    header("Location: login.php");
    exit();
}

header("Location: ../profile/profile.php"); 
exit();
?>