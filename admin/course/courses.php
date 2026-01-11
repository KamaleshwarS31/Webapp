<?php
require 'C:\wamp64\www\website1\auth_check.php';
$conn = mysqli_connect("localhost","root","","sathya_academy");

$res = mysqli_query($conn, "SELECT * FROM courses ORDER BY id DESC");

/* Notifications */
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
<title>Course Management</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="../../assets/Logo.png" type="image/x-icon">

<!-- 🔥 USE SAME STYLE AS users.php -->
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
    width:450px;
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
/* ===== MODAL FORM STYLES ===== */

.modal-box h3,
.modal-box h4 {
    margin-top: 0;
    margin-bottom: 12px;
    color: #12374A;
    text-align: center;
}

/* Form wrapper */
.modal-box form {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

/* Inputs & Select */
.modal-box input,
.modal-box select {
    width: 90%;
    padding: 10px 12px;
    border-radius: 6px;
    border: 1px solid #12374A;
    font-size: 14px;
    outline: none;
    background: #ffffff;
    color: #12374A;
}

/* Disabled input */
.modal-box input:disabled {
    background: #eaeaea;
    color: #666;
    cursor: not-allowed;
}

/* Focus effect */
.modal-box input:focus,
.modal-box select:focus {
    border-color: #E9BF65;
    box-shadow: 0 0 0 2px rgba(233,191,101,0.3);
}

/* Divider */
.modal-box hr {
    border: none;
    height: 1px;
    background: #12374A;
    margin: 10px 0;
}

/* Buttons */
.modal-box button {
    padding: 10px;
    border-radius: 6px;
    border: none;
    background: #12374A;
    color: #E9BF65;
    font-size: 14px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

.modal-box button:hover {
    background: #E9BF65;
    color: #12374A;
}

/* Secondary buttons (View modal etc.) */
.modal-box .secondary-btn {
    background: #459C7F;
    color: #12374A;
}

.modal-box .secondary-btn:hover {
    background: #E9BF65;
}

/* Small helper text */
.modal-box small {
    font-size: 12px;
    color: #12374A;
    opacity: 0.8;
}

/* View table inside modal */
.modal-box table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

.modal-box table td {
    padding: 6px;
    color: #E9BF65;
}

/* Center buttons */
.modal-actions {
    text-align: center;
    margin-top: 10px;
}
/* ===== LAYOUT ===== */
.layout{
    display:flex;
    min-height:100vh;
}

/* ===== SIDEBAR ===== */
.sidebar{
    width:220px;
    background:#0b2533;
    padding:20px 10px;
}

.sidebar h3{
    color:#E9BF65;
    text-align:center;
    margin-bottom:20px;
}

.sidebar a{
    display:block;
    padding:10px 12px;
    margin-bottom:8px;
    background:#12374A;
    color:#E9BF65;
    border-radius:6px;
    text-decoration:none;
    font-weight:bold;
}

.sidebar a:hover,
.sidebar a.active{
    background:#459C7F;
    color:#12374A;
}

/* ===== MAIN CONTENT ===== */
.main-content{
    flex:1;
    padding:20px;
}


     </style>
</head>
<body>

<!-- ===== TOP NAVBAR ===== -->
<div class="navbar-container">
    <div class="navbar">
        <div class="nleft">
            <a href="../../index.html">
                <img src="../../assets/Logo.png" width="50">
            </a>
        </div>
        <div class="ncenter"></div>
        <div class="nright">
            <a href="../../logout.php">Logout</a>
        </div>
    </div>
</div>

<!-- ===== NOTIFICATION BAR ===== -->
<div class="notification">
<marquee>
<?php foreach($notifications as $n): ?>
<a href="<?= htmlspecialchars($n['link']) ?>" target="_blank">
<?= htmlspecialchars($n['title']) ?>
</a> &nbsp; | &nbsp;
<?php endforeach; ?>
</marquee>
</div>

<!-- ===== LAYOUT ===== -->
<div class="layout">

<!-- ===== SIDEBAR ===== -->
<div class="sidebar">
    <h3>Admin</h3>
    <a href="../dashboard.php">Dashboard</a>
    <a href="../usermanagement/users.php">Users</a>
    <a href="courses.php" class="active">Courses</a>
</div>

<!-- ===== MAIN CONTENT ===== -->
<div class="main-content">

<div class="admin-container">
<h2>Course Management</h2>

<a href="#" class="add-btn" onclick="openModal('course_add.php')">
➕ Add Course
</a>

<table>
<tr>
    <th>Image</th>
    <th>Title</th>
    <th>Category</th>
    <th>Price</th>
    <th>Discount</th>
    <th>Status</th>
    <th>Actions</th>
</tr>

<?php while($c = mysqli_fetch_assoc($res)): ?>
<tr>
<td>
    <img src="../../uploads/<?= 
    ($c['category'] === 'package') ? 'packages' : 'courses'
?>/<?= htmlspecialchars($c['image']) ?>"
width="60" style="border-radius:6px">

</td>
<td><?= htmlspecialchars($c['title']) ?></td>
<td><?= htmlspecialchars($c['category']) ?></td>
<td>₹<?= (int)$c['price'] ?></td>
<?php
$price = $c['price'];
$discount = $c['discount'];

$final = $price - ($price * $discount / 100);
?>

<td>
<?php if ($discount > 0): ?>
    <del style="color:#aaa;">₹<?= number_format($price) ?></del><br>
    <strong style="color:#E9BF65;">₹<?= number_format($final) ?></strong><br>
    <small style="color:#459C7F;"><?= $discount ?>% OFF</small>
<?php else: ?>
    <strong>₹<?= number_format($price) ?></strong>
<?php endif; ?>
</td>


<td>
<label class="switch">
<input type="checkbox"
    <?= $c['status'] ? 'checked' : '' ?>
    data-id="<?= (int)$c['id'] ?>"
    onchange="toggleCourse(this)">
<span class="slider"></span>
</label>
<span class="status-text">
<?= $c['status'] ? 'Active' : 'Inactive' ?>
</span>
</td>

<td class="actions">
<a href="#" onclick="openModal('course_view.php?id=<?= $c['id'] ?>')">👁</a>
<a href="#" onclick="openModal('course_edit.php?id=<?= $c['id'] ?>')">✏</a>
<a href="#" onclick="deleteCourse(<?= $c['id'] ?>)">🗑</a>
</td>
</tr>
<?php endwhile; ?>
</table>
</div>

</div>
</div>

<!-- ===== MODAL ===== -->
<div class="modal" id="courseModal">
<div class="modal-box">
<span class="close" onclick="closeModal()">×</span>
<div id="modalContent"></div>
</div>
</div>

<!-- ===== JS ===== -->
<script>
function openModal(url){
    fetch(url)
    .then(r=>r.text())
    .then(html=>{
        document.getElementById("modalContent").innerHTML = html;
        document.getElementById("courseModal").style.display="block";
    });
}

function closeModal(){
    document.getElementById("courseModal").style.display="none";
}

function deleteCourse(id){
    if(!confirm("Delete course?")) return;
    fetch("course_delete.php?id="+id)
    .then(r=>r.json())
    .then(d=>{
        if(d.success) location.reload();
        else alert(d.msg);
    });
}

function toggleCourse(el){
    const id = parseInt(el.dataset.id, 10);
    const statusText = el.closest("td").querySelector(".status-text");

    /* Temporarily disable toggle */
    el.disabled = true;

    fetch("course_toggle.php?id=" + id)
        .then(res => res.json())
        .then(resp => {

            if (!resp.success) {
                alert(resp.msg || "Toggle failed");
                el.checked = !el.checked; // revert
                return;
            }

            /* ✅ Sync checkbox with DB */
            el.checked = resp.status === 1;
            statusText.textContent = resp.status === 1 ? "Active" : "Inactive";
        })
        .catch(() => {
            alert("Network error");
            el.checked = !el.checked;
        })
        .finally(() => {
            el.disabled = false;
        });
}
function submitForm(formId, actionUrl){
    const form = document.getElementById(formId);

    if (!form) {
        alert("Form not found");
        return;
    }

    const data = new FormData(form);

    fetch(actionUrl, {
        method: "POST",
        body: data
    })
    .then(res => res.json())
    .then(resp => {
        if (resp.success) {
            location.reload();
        } else {
            alert(resp.msg || "Action failed");
        }
    })
    .catch(() => {
        alert("Network error");
    });
}
</script>

</body>
</html>
