<?php
require '../../auth_check.php';
$conn = mysqli_connect("localhost","root","","sathya_academy");

$id = (int)$_GET['id'];

$q = mysqli_query($conn,"SELECT * FROM courses WHERE id=$id");
$c = mysqli_fetch_assoc($q);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title       = $_POST['title'];
    $category    = $_POST['category'];
    $career      = $_POST['career'];
    $price       = $_POST['price'];
    $discount    = $_POST['discount'];
    $description = $_POST['description'];

    /* ---------- IMAGE LOGIC (OPTIONAL) ---------- */
    if (!empty($_FILES['image']['name'])) {

        $allowed = ['jpg','jpeg','png','webp'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            echo json_encode(["success"=>false,"msg"=>"Invalid image format"]);
            exit;
        }

        $uploadDir = ($category === 'package')
            ? "../../uploads/packages/"
            : "../../uploads/courses/";

        $newImage = time() . "_" . uniqid() . "." . $ext;

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir.$newImage)) {
            echo json_encode(["success"=>false,"msg"=>"Image upload failed"]);
            exit;
        }

        /* Delete old image */
        $oldPath = ($c['category'] === 'package')
            ? "../../uploads/packages/".$c['image']
            : "../../uploads/courses/".$c['image'];

        if (file_exists($oldPath)) unlink($oldPath);

        /* Update with image */
        mysqli_query($conn,"
            UPDATE courses SET
                title='$title',
                category='$category',
                career='$career',
                price='$price',
                discount='$discount',
                description='$description',
                image='$newImage'
            WHERE id=$id
        ");

    } else {

        /* Update WITHOUT image */
        mysqli_query($conn,"
            UPDATE courses SET
                title='$title',
                category='$category',
                career='$career',
                price='$price',
                discount='$discount',
                description='$description'
            WHERE id=$id
        ");
    }

    echo json_encode(["success"=>true]);
    exit;
}
?>

<h3>Edit Course</h3>

<form id="courseEditForm" enctype="multipart/form-data">

<input name="title" value="<?= htmlspecialchars($c['title']) ?>" required>

<?php
$imgPath = ($c['category'] === 'package')
    ? "../../uploads/packages/".$c['image']
    : "../../uploads/courses/".$c['image'];
?>
<img src="<?= $imgPath ?>" width="120"><br><br>

<input type="file" name="image">

<select name="category" required>
    <option value="government" <?= $c['category']=='government'?'selected':'' ?>>Government</option>
    <option value="computer" <?= $c['category']=='computer'?'selected':'' ?>>Computer</option>
    <option value="package" <?= $c['category']=='package'?'selected':'' ?>>Package</option>
</select>

<input name="career" value="<?= htmlspecialchars($c['career']) ?>">
<input name="price" value="<?= $c['price'] ?>">
<input name="discount" value="<?= $c['discount'] ?>">

<textarea name="description"><?= htmlspecialchars($c['description']) ?></textarea>

<button type="button"
 onclick="submitForm('courseEditForm','course_edit.php?id=<?= $id ?>')">
 Update Course
</button>

</form>
