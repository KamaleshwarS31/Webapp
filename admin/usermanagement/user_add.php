<?php
require "../../auth_check.php"
require "mailer.php";
$conn = mysqli_connect("localhost", "root", "", "sathya_academy");

if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $_POST['name'];
  $email = $_POST['email']
}
?>