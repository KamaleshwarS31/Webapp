<?php
require __DIR__ . '/../../auth_check.php';

header('Content-Type: application/json');

$conn = mysqli_connect("localhost","root","","sathya_academy");
if(!$conn){
    echo json_encode(["success"=>false,"msg"=>"DB connection failed"]);
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    echo json_encode(["success"=>false,"msg"=>"Invalid user ID"]);
    exit;
}

/* Fetch current status */
$res = mysqli_query($conn,
    "SELECT status FROM users WHERE id=$id LIMIT 1"
);

if (mysqli_num_rows($res) !== 1) {
    echo json_encode(["success"=>false,"msg"=>"User not found"]);
    exit;
}

$user = mysqli_fetch_assoc($res);
$newStatus = $user['status'] ? 0 : 1;

/* Update status */
mysqli_query($conn,
    "UPDATE users SET status=$newStatus WHERE id=$id"
);

echo json_encode([
    "success" => true,
    "status"  => $newStatus
]);
exit;
