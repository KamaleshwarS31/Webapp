<?php
declare(strict_types=1);
date_default_timezone_set('Asia/Kolkata');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/PHPMailer-master/src/SMTP.php';

header('Content-Type: application/json; charset=utf-8');

session_start();

$conn = mysqli_connect("localhost","root","","sathya_academy");
if (!$conn) {
    echo json_encode(["success"=>false,"msg"=>"Database error"]);
    exit;
}

/* READ JSON INPUT */
$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

if (!is_array($data) || empty($data['email'])) {
    echo json_encode(["success"=>false,"msg"=>"Email is required"]);
    exit;
}

$email = mysqli_real_escape_string($conn, trim($data['email']));

/* CHECK USER */
$q = "SELECT id FROM users WHERE email='$email' AND status=1 LIMIT 1";
$res = mysqli_query($conn, $q);

if (mysqli_num_rows($res) !== 1) {
    // prevent email enumeration
    echo json_encode([
        "success" => true,
        "msg" => "If the email exists, OTP will be sent."
    ]);
    exit;
}

/* GENERATE OTP */
$otp = random_int(100000, 999999);
$expiry = date("Y-m-d H:i:s", time() + 300);

mysqli_query(
    $conn,
    "UPDATE users SET reset_otp='$otp', otp_expiry='$expiry' WHERE email='$email'"
);

/* SEND EMAIL */
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'sathyaacademybtl@gmail.com';
    $mail->Password = 'cvxu spxh abbq vgwv'; // app password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('sathyaacademybtl@gmail.com', 'Sathya Academy');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Password Reset OTP - Sathya Academy';
    $mail->Body = "
        <h3>Password Reset</h3>
        <p>Your OTP is: <b>$otp</b></p>
        <p>This OTP is valid for 5 minutes.</p>
    ";

    $mail->send();

    $_SESSION['reset_email'] = $email;

    echo json_encode([
        "success" => true,
        "msg" => "OTP sent to your email"
    ]);
    exit;

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "msg" => "Unable to send OTP. Try again later."
    ]);
    exit;
}
