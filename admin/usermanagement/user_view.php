<?php
require '../../auth_check.php';
$conn = mysqli_connect("localhost","root","","sathya_academy");

if (!isset($_GET['id'])) {
    echo "<p>Invalid request</p>";
    exit;
}

$id = (int)$_GET['id'];

$user = mysqli_fetch_assoc(
    mysqli_query($conn,
        "SELECT name,email,username,role,status 
         FROM users WHERE id = $id"
    )
);

if (!$user) {
    echo "<p>User not found</p>";
    exit;
}
?>

<h3>User Details</h3>

<table>
    <tr><td><b>Name</b></td><td><?= htmlspecialchars($user['name']) ?></td></tr>
    <tr><td><b>Email</b></td><td><?= htmlspecialchars($user['email']) ?></td></tr>
    <tr><td><b>Username</b></td><td><?= htmlspecialchars($user['username']) ?></td></tr>
    <tr><td><b>Role</b></td><td><?= htmlspecialchars($user['role']) ?></td></tr>
    <tr><td><b>Status</b></td><td><?= $user['status']?'Active':'Inactive' ?></td></tr>
</table>

<div class="modal-actions">
    <button class="secondary-btn"
        onclick="openModal('user_edit.php?id=<?= $id ?>')">
        Edit User
    </button>
</div>
