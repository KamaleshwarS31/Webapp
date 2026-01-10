<?php
require '../auth_check.php';
$conn=mysqli_connect("localhost","root","","sathya_academy");
$id=(int)$_GET['id'];

mysqli_query($conn,"DELETE FROM users WHERE id=$id");
echo json_encode(["success"=>true]);
?>