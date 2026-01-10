<?php
require '../../auth_check.php';
$conn=mysqli_connect("localhost","root","","sathya_academy");

$id=(int)$_GET['id'];
$q=mysqli_query($conn,"SELECT * FROM courses WHERE id=$id");
$c=mysqli_fetch_assoc($q);
?>

<h3><?= htmlspecialchars($c['title']) ?></h3>

<?php
$imgPath = ($c['category'] === 'package')
    ? "../../uploads/packages/" . $c['image']
    : "../../uploads/courses/" . $c['image'];
?>

<img src="<?= htmlspecialchars($imgPath) ?>" width="200">
<br><br>

<b>Category:</b> <?= $c['category'] ?><br>
<b>Career:</b> <?= $c['career'] ?><br>
<b>Price:</b> ₹<?= $c['price'] ?><br>
<b>Discount:</b> <?= $c['discount'] ?>%<br>

<p><?= nl2br($c['description']) ?></p>
