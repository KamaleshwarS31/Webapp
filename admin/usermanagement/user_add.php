<?php
require __DIR__ . '/../../auth_check.php';
require 'mailer.php';
$conn = mysqli_connect("localhost","root","","sathya_academy");

if($_SERVER['REQUEST_METHOD']=='POST'){
  header('Content-Type: application/json');

    $name=$_POST['name'];
    $email=$_POST['email'];
    $username=$_POST['username'];
    $role=$_POST['role'];

    $pass = bin2hex(random_bytes(4));
    $hash = password_hash($pass, PASSWORD_DEFAULT);

    mysqli_query($conn,"INSERT INTO users (name,email,username,password,role,status)
                        VALUES ('$name','$email','$username','$hash','$role',1)");

    sendMail($email,"Welcome to Sathya Academy",
        welcomeUserTemplate($name,$username,$pass));

    echo json_encode(["success"=>true]);
    exit;
}
?>

<h3>Add New User</h3>

<form id="addUserForm">
    <input type="text" name="name" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email Address" required>
    <input type="text" name="username" placeholder="Username" required>

    <select name="role" required>
        <option value="">Select Role</option>
        <option value="student">Student</option>
        <option value="teacher">Teacher</option>
        <option value="alumni">Alumni</option>
        <option value="admin">Admin</option>
    </select>

    <button type="button"
        onclick="submitForm('addUserForm','user_add.php')">
        Add User
    </button>
</form>

