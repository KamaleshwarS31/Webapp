<?php
require 'C:\wamp64\www\website1\auth_check.php'; // checks admin role
$conn = mysqli_connect("localhost","root","","sathya_academy");

$res = mysqli_query($conn, "SELECT id,name,email,username,role,status FROM users");

// Notification
$notifications = [];
$nQuery = "SELECT title, link FROM notifications WHERE status=1 ORDER BY id DESC";
$nResult = mysqli_query($conn, $nQuery);
while($row = mysqli_fetch_assoc($nResult)){
    $notifications[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Primary Meta Tags -->
    <title>Sathya Academy - Master Tech, Build Career</title>
    <meta name="title" content="Sathya Academy - Master Tech, Build Career" />
    <style>
        body{
            margin: 0;
            background-color: #12374A;
        }
        .navbar-container{
            margin: 0;
            padding: 0;
            background-color: #12374A;
        }
        .navbar-container > .navbar {
            margin: 0;
            padding: 0;
            display: flex;
            height: 60px;
            width: auto;
            justify-content:space-between;
            align-items: center;
        }
        .navbar-container > .navbar > .ncenter > a{
            text-align: center;
            text-decoration: none;
            color: #E9BF65;
            padding: 10px;
        }
        .navbar-container > .navbar > .ncenter > a:hover {
            background-color: #E9BF65;
            color: #12374A;
            font-weight: bolder;
            border-radius: 50px;
        }
        .navbar-container > .navbar > .nright > a{
            border: solid 3px #E9BF65;
            border-radius: 50px;
            border-top-right-radius: 0px;
            text-align: center;
            text-decoration: none;
            padding: 5px;
            color: white;
            margin-right: 5px;
        }
        .navbar-container > .navbar > .nright > a:hover {
            background-color: #E9BF65;
            color: #12374A;
            font-weight: bolder;
        }
        .notification{
            background-color: #459C7F;
        }
        .notification > marquee > a{
            text-decoration: none;
            color:#12374A;
        }
        .notification > marquee > a:hover{
            text-decoration: dashed;
            color: #E9BF65;
        }
        h2{
    color:#E9BF65;
    text-align:center;
    margin:20px 0;
}

a{
    color:#E9BF65;
    text-decoration:none;
    font-weight:bold;
}

a:hover{
    color:#459C7F;
}

/* Container */
.admin-container{
    width:95%;
    margin:auto;
    background:#0f2f40;
    padding:20px;
    border-radius:10px;
}

/* Add button */
.add-btn{
    display:inline-block;
    padding:8px 14px;
    background:#459C7F;
    color:#12374A;
    border-radius:6px;
    margin-bottom:15px;
}

.add-btn:hover{
    background:#E9BF65;
}

/* Table */
table{
    width:100%;
    border-collapse:collapse;
    background:#12374A;
    color:#fff;
}

th{
    background:#459C7F;
    color:#12374A;
    padding:12px;
}

td{
    padding:10px;
    text-align:center;
    border-bottom:1px solid #0b2533;
}

tr:hover{
    background:#0b2d3d;
}

/* Action links */
.actions a{
    margin:0 5px;
}

/* Toggle Switch */
.switch{
    position:relative;
    display:inline-block;
    width:50px;
    height:24px;
}

.switch input{
    opacity:0;
    width:0;
    height:0;
}

.slider{
    position:absolute;
    cursor:pointer;
    top:0;
    left:0;
    right:0;
    bottom:0;
    background:#ccc;
    transition:.4s;
    border-radius:24px;
}

.slider:before{
    position:absolute;
    content:"❌";
    height:20px;
    width:20px;
    left:2px;
    bottom:2px;
    background:white;
    transition:.4s;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:12px;
}

input:checked + .slider{
    background:#459C7F;
}

input:checked + .slider:before{
    transform:translateX(26px);
    content:"✔";
}

/* Status label */
.status-text{
    font-size:12px;
    margin-top:4px;
    display:block;
    color:#E9BF65;
}
.modal{
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.7);
    z-index:999;
}

.modal-box{
    background:#459C7F;
    width:360px;
    margin:100px auto;
    padding:20px;
    border-radius:10px;
    color:#12374A;
    position:relative;
}

.close{
    position:absolute;
    right:10px;
    top:5px;
    font-size:22px;
    cursor:pointer;
    color:#12374A;
}

     </style>
</head>
<body>
    <div class="navbar-container">
        <div class="navbar">
            <div class="nleft">
                <a href="index.html"><img src="../../assets/Logo.png" alt="Logo" width="50" height="auto"></a>
            </div>
            <div class="ncenter">
                <a href="home.html">Home</a>
                <a href="courses.html">Courses</a>
                <a href="packages.html">Packages</a>
                <a href="about.html">About</a>
                <a href="contact.html">Contact</a>
            </div>
            <div class="nright">
                <a href="login.php">Login</a>
            </div>
        </div>
    </div>
    <div class="notification">
        <marquee behavior="slow" direction="left">
            <?php if(count($notifications) > 0): ?>
                <?php foreach ($notifications as $n): ?>
                    <a href="<?= htmlspecialchars($n['link']) ?>" target = "_blank"><?= htmlspecialchars($n['title']) ?>
                    </a>
                    &nbsp;&nbsp; | &nbsp;&nbsp;
                <?php endforeach; ?>
            <?php else: ?>
                No new notifications
            <?php endif; ?>
        </marquee>
    </div>
      <div class="admin-container">
    <h2>User Management</h2>

    <a href="#" class="add-btn" onclick="openModal('user_add.php')">➕ Add User</a>

    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Username</th>
            <th>Role</th>
            <!-- <th>Status</th> -->
            <th>Status</th>
            <th>Actions</th>
        </tr>

        <?php while($u = mysqli_fetch_assoc($res)): ?>
        <tr>
            <td><?= htmlspecialchars($u['name']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td><?= htmlspecialchars($u['username']) ?></td>
            <td><?= htmlspecialchars($u['role']) ?></td>

            <!-- <td>
                <?= $u['status'] ? 'Active' : 'Inactive' ?>
            </td> -->

            <!-- Toggle -->
            <td>
                <label class="switch">
                    <input type="checkbox"
                           <?= $u['status'] ? 'checked' : '' ?>
                           onchange="toggleUser(<?= $u['id'] ?>)">
                    <span class="slider"></span>
                </label>
                <span class="status-text">
                    <?= $u['status'] ? 'Active' : 'Inactive' ?>
                </span>
            </td>

            <!-- Actions -->
            <td class="actions">
            <a href="#" onclick="openModal('ajax_user_view.php?id=<?= $u['id'] ?>')">👁 View</a>
            <a href="#" onclick="openModal('ajax_user_edit.php?id=<?= $u['id'] ?>')">✏ Edit</a>
            <a href="#" onclick="deleteUser(<?= $u['id'] ?>)">🗑 Delete</a>
          </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
<!-- Modal -->
<div class="modal" id="userModal">
  <div class="modal-box">
    <span class="close" onclick="closeModal()">×</span>
    <div id="modalContent"></div>
  </div>
</div>
<script>
function openModal(url){
    fetch(url)
    .then(res => res.text())
    .then(html => {
        document.getElementById("modalContent").innerHTML = html;
        document.getElementById("userModal").style.display = "block";
    });
}

function closeModal(){
    document.getElementById("userModal").style.display = "none";
}

/* Submit form inside modal */
function submitForm(formId, actionUrl){
    const form = document.getElementById(formId);
    const data = new FormData(form);

    fetch(actionUrl, {
        method: "POST",
        body: data
    })
    .then(res => res.json())
    .then(resp => {
        if(resp.success){
            location.reload();
        }else{
            alert(resp.msg);
        }
    });
}

/* Delete */
function deleteUser(id){
    if(!confirm("Delete this user?")) return;

    fetch("ajax_user_delete.php?id="+id)
    .then(res => res.json())
    .then(resp => {
        if(resp.success) location.reload();
        else alert(resp.msg);
    });
}

/* Toggle */
function toggleUser(id){
    fetch("ajax_user_toggle.php?id="+id)
    .then(res => res.json())
    .then(() => location.reload());
}
</script>

</body>
</html>
