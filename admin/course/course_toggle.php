<?php
require 'C:\wamp64\www\website1\auth_check.php';

header('Content-Type: application/json');

$conn = mysqli_connect("localhost","root","","sathya_academy");
if (!$conn) {
    echo json_encode(["success"=>false,"msg"=>"DB connection failed"]);
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    echo json_encode(["success"=>false,"msg"=>"Invalid ID"]);
    exit;
}

/* Fetch current status */
$q = mysqli_query($conn,"SELECT status FROM courses WHERE id=$id LIMIT 1");

if (mysqli_num_rows($q) !== 1) {
    echo json_encode(["success"=>false,"msg"=>"Course not found"]);
    exit;
}

$row = mysqli_fetch_assoc($q);
$newStatus = $row['status'] == 1 ? 0 : 1;

/* Update */
$update = mysqli_query(
    $conn,
    "UPDATE courses SET status=$newStatus WHERE id=$id"
);

if (!$update) {
    echo json_encode(["success"=>false,"msg"=>"Update failed"]);
    exit;
}

/* ✅ ALWAYS return JSON */
echo json_encode([
    "success" => true,
    "status"  => $newStatus
]);
exit;
