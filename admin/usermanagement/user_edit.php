<?php
require 'C:\wamp64\www\website1\auth_check.php';
require 'mailer.php';
$conn = mysqli_connect("localhost","root","","sathya_academy");

$id = (int)$_GET['id'];
$user = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT * FROM users WHERE id=$id")
);

if($_SERVER['REQUEST_METHOD']=='POST'){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $uname = $_POST['username'];

    mysqli_query($conn,
        "UPDATE users SET name='$name', email='$email', username='$uname', role='$role' WHERE id=$id"
    );

    $body = profileUpdatedTemplate($name, $email, $uname, $role);

    sendMail(
        $email,
        "Profile Updated - Sathya Academy",
        $body
    );

    header("Location: users.php");
    exit;
}
?>

<form method="post">
  <input name="name" value="<?= $user['name'] ?>">
  <input name="email" value="<?= $user['email'] ?>">
  <input name="username" value="<?= $user['username'] ?>">

  <select name="role">
    <option <?= $user['role']=='admin'?'selected':'' ?>>admin</option>
    <option <?= $user['role']=='student'?'selected':'' ?>>student</option>
    <option <?= $user['role']=='teacher'?'selected':'' ?>>teacher</option>
    <option <?= $user['role']=='alumni'?'selected':'' ?>>alumni</option>
  </select>

  <button>Update</button>
</form>

<a href="user_password.php?id=<?= $id ?>">Change Password</a>
