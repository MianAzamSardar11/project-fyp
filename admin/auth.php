<?php
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['admin_id']) && !isset($_SESSION['admin_email'])) {
    $_SESSION['alert'] = ['type' => 'warning', 'message' => 'Please login to access this page.'];
    header('Location: login.php');
    exit;
}
