<?php
require '../../auth_check.php';
require 'mailer.php';
$conn = mysqli_connect("localhost","root","","sathya_academy");

$id = (int)$_GET['id'];
$user = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT name,email,username,role FROM users WHERE id=$id")
);

/* HANDLE FORM SUBMIT */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name  = $_POST['name'];
    $email = $_POST['email'];
    $role  = $_POST['role'];
    $uname = $_POST['username'];

    /* Update profile */
    mysqli_query($conn,
        "UPDATE users 
         SET name='$name', email='$email', username='$uname', role='$role'
         WHERE id=$id"
    );

    /* Check if password change requested */
    if (!empty($_POST['new_password'])) {

        if (strlen($_POST['new_password']) < 6) {
            echo json_encode([
                "success" => false,
                "msg" => "Password must be at least 6 characters"
            ]);
            exit;
        }

        $hash = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

        mysqli_query($conn,
            "UPDATE users SET password='$hash' WHERE id=$id"
        );

        /* Password change email */
        sendMail(
            $email,
            "Password Changed - Sathya Academy",
            passwordChangedTemplate($name, $uname, $_POST['new_password'])
        );
    } 
    else {
        /* Profile update email */
        sendMail(
            $email,
            "Profile Updated - Sathya Academy",
            profileUpdatedTemplate($name, $email, $uname, $role)
        );
    }

    echo json_encode(["success" => true]);
    exit;
}
?>

<h3>Edit User</h3>

<form id="editUserForm">
    <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
    <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>">

    <select name="role">
        <option value="admin" <?= $user['role']=='admin'?'selected':'' ?>>Admin</option>
        <option value="student" <?= $user['role']=='student'?'selected':'' ?>>Student</option>
        <option value="teacher" <?= $user['role']=='teacher'?'selected':'' ?>>Teacher</option>
        <option value="alumni" <?= $user['role']=='alumni'?'selected':'' ?>>Alumni</option>
    </select>

    <hr>

    <h4>Change Password (Optional)</h4>
    <input type="password" name="new_password" placeholder="New Password">
    <small>Leave blank to keep current password</small>

    <button type="button"
        onclick="submitForm('editUserForm','user_edit.php?id=<?= $id ?>')">
        Update User
    </button>
</form>
