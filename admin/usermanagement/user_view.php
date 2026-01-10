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

<h3 style="margin-top:0;">User Details</h3>

<table style="width:100%;background-color:#12374A;">
    <tr>
        <td><b>Name</b></td>
        <td><?= htmlspecialchars($user['name']) ?></td>
    </tr>
    <tr>
        <td><b>Email</b></td>
        <td><?= htmlspecialchars($user['email']) ?></td>
    </tr>
    <tr>
        <td><b>Username</b></td>
        <td><?= htmlspecialchars($user['username']) ?></td>
    </tr>
    <tr>
        <td><b>Role</b></td>
        <td><?= htmlspecialchars($user['role']) ?></td>
    </tr>
    <tr>
        <td><b>Status</b></td>
        <td>
            <?= $user['status']
                ? "<span style='color:green'>Active</span>"
                : "<span style='color:red'>Inactive</span>" ?>
        </td>
    </tr>
</table>

<hr>

<div style="text-align:center;">
    <button onclick="openModal('user_edit.php?id=<?= $id ?>')">
        ✏ Edit User
    </button>
</div>
