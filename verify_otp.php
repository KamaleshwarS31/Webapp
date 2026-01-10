<?php
declare(strict_types=1);
date_default_timezone_set('Asia/Kolkata');

header('Content-Type: application/json; charset=utf-8');

session_start();

$conn = mysqli_connect("localhost","root","","sathya_academy");
if (!$conn) {
    echo json_encode(["success"=>false,"msg"=>"Database error"]);
    exit;
}

/* READ JSON INPUT */
$data = json_decode(file_get_contents("php://input"), true);

if (!is_array($data) || empty($data['otp'])) {
    echo json_encode(["success"=>false,"msg"=>"OTP is required"]);
    exit;
}

if (!isset($_SESSION['reset_email'])) {
    echo json_encode(["success"=>false,"msg"=>"Session expired. Try again."]);
    exit;
}

$otp = trim($data['otp']);
$email = mysqli_real_escape_string($conn, $_SESSION['reset_email']);

/* OTP FORMAT CHECK */
if (!preg_match('/^[0-9]{6}$/', $otp)) {
    echo json_encode(["success"=>false,"msg"=>"Invalid OTP format"]);
    exit;
}

/* VERIFY OTP */
$q = "SELECT id FROM users
      WHERE email='$email'
      AND reset_otp='$otp'
      AND otp_expiry >= NOW()
      LIMIT 1";

$res = mysqli_query($conn, $q);

if (mysqli_num_rows($res) === 1) {

    $_SESSION['otp_verified'] = true;

    echo json_encode([
        "success" => true,
        "msg" => "OTP verified"
    ]);
    exit;

} else {
    echo json_encode([
        "success" => false,
        "msg" => "Invalid or expired OTP"
    ]);
    exit;
}
