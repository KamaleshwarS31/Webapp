<?php
require '../../auth_check.php';
header('Content-Type: application/json');

$conn=mysqli_connect("localhost","root","","sathya_academy");
$id=(int)$_GET['id'];

mysqli_query($conn,"DELETE FROM courses WHERE id=$id");
echo json_encode(["success"=>true]);
