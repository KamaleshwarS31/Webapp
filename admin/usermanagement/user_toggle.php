<?php
require 'C:\wamp64\www\website1\auth_check.php';
$conn = mysqli_connect("localhost","root","","sathya_academy");

header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    echo json_encode(["success" => false, "msg" => "Invalid ID"]);
    exit;
}

$id = (int)$_GET['id'];

/* Toggle status */
$q = mysqli_query(
    $conn,
    "UPDATE users SET status = IF(status=1, 0, 1) WHERE id = $id"
);

if ($q) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "msg" => "DB error"]);
}
?>