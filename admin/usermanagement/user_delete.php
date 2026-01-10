<?php
require 'C:\wamp64\www\website1\auth_check.php';
require 'mailer.php';

$conn = mysqli_connect("localhost","root","","sathya_academy");
$id = (int)$_GET['id'];

$user = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT email FROM users WHERE id=$id")
);

mysqli_query($conn,"DELETE FROM users WHERE id=$id");

sendMail(
    $user['email'],
    "Account Deleted",
    "Your account has been removed by admin."
);

header("Location: users.php");
exit;
