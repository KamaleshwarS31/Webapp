<?php
require '../../auth_check.php';
require 'mailer.php';
$conn = mysqli_connect("localhost","root","","sathya_academy");

if($_SERVER['REQUEST_METHOD']=='POST'){
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

<form id="addUserForm">
  <input name="name" placeholder="Name" required><br>
  <input name="email" placeholder="Email" required><br>
  <input name="username" placeholder="Username" required><br>
  <select name="role">
    <option>student</option>
    <option>teacher</option>
    <option>alumni</option>
    <option>admin</option>
  </select><br>
  <button type="button"
          onclick="submitForm('addUserForm','ajax_user_add.php')">
    Add User
  </button>
</form>
