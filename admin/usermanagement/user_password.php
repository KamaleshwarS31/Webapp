<?php
require 'C:\wamp64\www\website1\auth_check.php';
require 'mailer.php';

$conn = mysqli_connect("localhost","root","","sathya_academy");
$id = (int)$_GET['id'];
$user = mysqli_fetch_assoc(mysqli_query($conn,"SELECT name,username, email FROM users WHERE id=$id"));


if($_SERVER['REQUEST_METHOD']=='POST'){
    $pass = $_POST['password'];
    $hash = password_hash($pass, PASSWORD_DEFAULT);

    mysqli_query($conn,
        "UPDATE users SET password='$hash' WHERE id=$id"
    );

    $body = passwordChangedTemplate($user['name'], $user['username'], $pass);

    sendMail(
        $user['email'],
        "Password Changed - Sathya Academy",
        $body
    );

    header("Location: users.php");
    exit;
}
?>

<form method="post">
  <input type="password" name="password" placeholder="New Password" required>
  <button>Change Password</button>
</form>
