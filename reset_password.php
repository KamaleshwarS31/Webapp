<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
session_start();

$conn = mysqli_connect("localhost", "root", "", "sathya_academy");
if (!$conn) {
    echo json_encode(["success"=>false, "msg"=>"Database error"]);
    exit;
}

/* SECURITY CHECK */
if (!isset($_SESSION['otp_verified'], $_SESSION['reset_email'])) {
    echo json_encode(["success"=>false, "msg"=>"Unauthorized"]);
    exit;
}

/* READ JSON INPUT */
$data = json_decode(file_get_contents("php://input"), true);

if (!is_array($data) || empty($data['password']) || empty($data['confirm'])) {
    echo json_encode(["success"=>false, "msg"=>"Invalid input"]);
    exit;
}

$password = $data['password'];
$confirm  = $data['confirm'];

/* VALIDATION */
if ($password !== $confirm) {
    echo json_encode(["success"=>false, "msg"=>"Passwords do not match"]);
    exit;
}

if (strlen($password) < 6) {
    echo json_encode(["success"=>false, "msg"=>"Password too short"]);
    exit;
}

/* UPDATE PASSWORD */
$hash  = password_hash($password, PASSWORD_DEFAULT);
$email = mysqli_real_escape_string($conn, $_SESSION['reset_email']);

mysqli_query($conn,
    "UPDATE users 
     SET password='$hash', reset_otp=NULL, otp_expiry=NULL
     WHERE email='$email'"
);

/* CLEAN SESSION */

echo json_encode([
    "success" => true,
    "msg" => "Password reset successful"
]);
exit;
