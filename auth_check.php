<?php
// auth_check.php
session_start();

/* Check if user is logged in */
if (!isset($_SESSION['user_id'], $_SESSION['role'])) {
    header("Location: /website1/login.php");
    exit;
}

/* Allow only admin */
if (strtolower($_SESSION['role']) !== 'admin') {
    // Optional: log unauthorized access attempt
    http_response_code(403);
    echo "Access Denied";
    exit;
}
