<?php
require 'C:\wamp64\www\website1\auth_check.php';
require 'mailer.php';

$conn = mysqli_connect("localhost","root","","sathya_academy");
$id = (int)$_GET['id'];

$user = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT email,status FROM users WHERE id=$id")
);

$newStatus = $user['status'] ? 0 : 1;
mysqli_query($conn,"UPDATE users SET status=$newStatus WHERE id=$id");

sendMail(
    $user['email'],
    "Account Status Changed",
    $newStatus ? "Your account is now active." : "Your account has been deactivated."
);

header("Location: users.php");
exit;
