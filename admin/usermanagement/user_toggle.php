<?php
require __DIR__ . '/../../auth_check.php';
require __DIR__ . '/mailer.php';
require __DIR__ . '/email_templates/account_status.php';

header('Content-Type: application/json');
error_reporting(0);

$conn = mysqli_connect("localhost","root","","sathya_academy");

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    echo json_encode(["success"=>false,"msg"=>"Invalid user ID"]);
    exit;
}

/* Get user */
$q = mysqli_query($conn, "SELECT email,name,status FROM users WHERE id=$id LIMIT 1");
if (mysqli_num_rows($q) !== 1) {
    echo json_encode(["success"=>false,"msg"=>"User not found"]);
    exit;
}

$user = mysqli_fetch_assoc($q);

/* Toggle status */
$newStatus = $user['status'] ? 0 : 1;
mysqli_query($conn, "UPDATE users SET status=$newStatus WHERE id=$id");

/* Send mail */
$statusText = $newStatus ? "Activated" : "Deactivated";
$mailSent = false;

try {
    sendMail(
        $user['email'],
        "Account $statusText – Sathya Academy",
        accountStatusTemplate($user['name'], $statusText)
    );
    $mailSent = true;
} catch (Exception $e) {
    $mailSent = false;
}

/* 🔴 THIS WAS MISSING */
echo json_encode([
    "success" => true,
    "status"  => $newStatus,
    "mail"    => $mailSent
]);
exit;
