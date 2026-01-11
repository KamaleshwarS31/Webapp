<?php
require '../../auth_check.php';
$conn = mysqli_connect("localhost","root","","sathya_academy");

if($_SERVER['REQUEST_METHOD']=='POST'){
    $title=$_POST['title'];
    $category=$_POST['category'];
    $description=$_POST['description'];
    $career=$_POST['career'];
    $price=$_POST['price'];
    $discount=$_POST['discount'];

    if ($price <= 0) {
        echo json_encode(["success"=>false, "msg"=>"Invalid price"]);
        exit;
    }

    if ($discount < 0 || $discount > 100) {
        echo json_encode(["success"=>false, "msg"=>"Discount must be between 0 and 100"]);
        exit;
    }

    $finalPrice = $price - ($price * $discount / 100);

    $img = $_FILES['image']['name'];
    $category = $_POST['category'];
$imageName = $_FILES['image']['name'];
$tmp = $_FILES['image']['tmp_name'];

$allowed = ['jpg','jpeg','png','webp'];
$ext = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

if (!in_array($ext, $allowed)) {
    echo json_encode(["success"=>false,"msg"=>"Invalid image format"]);
    exit;
}

/* Decide folder */
$uploadDir = ($category === 'package')
    ? "../../uploads/packages/"
    : "../../uploads/courses/";

$newImage = time() . "_" . uniqid() . "." . $ext;

if (!move_uploaded_file($tmp, $uploadDir . $newImage)) {
    echo json_encode(["success"=>false,"msg"=>"Image upload failed"]);
    exit;
}


    mysqli_query($conn,
        "INSERT INTO courses 
        (image,title,category,description,career,price,discount,status)
        VALUES
        ('$newImage','$title','$category','$description','$career','$price','$discount',1)"
    );

    echo json_encode(["success"=>true]);
    exit;
}
?>

<h3>Add Course</h3>

<form id="courseAddForm" enctype="multipart/form-data">
    <input name="title" placeholder="Course Title" required>
    <select name="category" required>
        <option value="">Category</option>
        <option value="government">Government</option>
        <option value="computer">Computer</option>
        <option value="package">Package</option>
    </select>
    <input type="file" name="image" required>
    <input name="career" placeholder="Career Path">
    <input name="price" type="number" placeholder="Price">
    <input name="discount" type="number" placeholder="Discount">
    <textarea name="description" placeholder="Description"></textarea>

    <button type="button"
        onclick="submitForm('courseAddForm','course_add.php')">
        Save Course
    </button>
</form>
