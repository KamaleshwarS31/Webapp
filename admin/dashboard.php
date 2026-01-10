<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
?>
<a href="usermanagement/users.php">Users</a>
<a href="course/courses.php">Users</a>