<?php
require '../auth_check.php';
$conn=mysqli_connect("localhost","root","","sathya_academy");

$id=(int)$_GET['id'];
mysqli_query($conn,"UPDATE users SET status=IF(status=1,0,1) WHERE id=$id");
echo json_encode(["success"=>true]);
?>