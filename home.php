<?php
$conn = mysqli_connect("localhost", "root", "", "sathya_academy");
if(!$conn){
    die("Database connection failed");
}

// Notification
$notifications = [];
$nQuery = "SELECT title, link FROM notifications WHERE status=1 ORDER BY id DESC";
$nResult = mysqli_query($conn, $nQuery);
while($row = mysqli_fetch_assoc($nResult)){
    $notifications[] = $row;
}

// Government Courses
$govCourses =[];
$govQuery = "SELECT title, image FROM courses WHERE status=1 AND category='government'";
$govResult = mysqli_query($conn, $govQuery);
while($row = mysqli_fetch_assoc($govResult)){
    $govCourses[] = $row;
}

// ---------------- COMPUTER COURSES ----------------
$compCourses = [];
$compQuery = "SELECT title, image FROM courses 
              WHERE status=1 AND category='computer'";
$compResult = mysqli_query($conn, $compQuery);
while($row = mysqli_fetch_assoc($compResult)){
    $compCourses[] = $row;
}

// ---------------- PACKAGES ----------------
$packages = [];
$pkgQuery = "SELECT title, image FROM courses 
              WHERE status=1 AND category='package'";
$pkgResult = mysqli_query($conn, $pkgQuery);
while($row = mysqli_fetch_assoc($pkgResult)){
    $packages[] = $row;
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
    <meta name="description" content="From Basic level to Master level of computer courses, with placement training and more.." />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://sathyaacademy.in" />
    <meta property="og:title" content="Sathya Academy - Master Tech, Build Career" />
    <meta property="og:description" content="From Basic level to Master level of computer courses, with placement training and more.." />
    <meta property="og:image" content="assets/Logo.png" />

    <!-- X (Twitter) -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="https://sathyaacademy.in" />
    <meta property="twitter:title" content="Sathya Academy - Master Tech, Build Career" />
    <meta property="twitter:description" content="From Basic level to Master level of computer courses, with placement training and more.." />
    <meta property="twitter:image" content="assets/Logo.png" />

    <!-- Meta Tags Generated with https://metatags.io -->
    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/Logo.png" type="image/x-icon">
    <!-- Bootstrap -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
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
        .hero{
            display: flex;
            background-color: #12374A;
            color: #E9BF65;
            text-align: center;
            width: auto;
            height: 495px;
            justify-content: center;
            align-items: center;
        }
        .hero > .hcontent > h1{
            font-size: 400%;
        }
        .hero > .hcontent > h2{
            font-size: 200%;
        }
        .hero > .hcontent > h3{
            font-size: 200%;
        }
        .hero > .hcontent > .hbuttons {
            margin-top: 50px;
        }
        .hero > .hcontent > .hbuttons > a{
            text-decoration: none;
            color: white;
            padding: 6px;
            background-color: #459C7F;
            font-weight: bolder;
        }
        .hero > .hcontent > .hbuttons > #c{
            border-top-left-radius: 50px;
            border-bottom-left-radius: 50px;
        }
        .hero > .hcontent > .hbuttons > #p{
            border-top-right-radius: 50px;
            border-bottom-right-radius: 50px;
        }
        .hero > .hcontent > .hbuttons > a:hover{
            background-color: #12374A;
            color: #459C7F;
            font-weight: bolder;
        }
        .footer {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            align-items: center;
            background-color: #023047;
            color: white;
            padding: 20px;
        }
        .footer-left, .footer-middle, .footer-right {
            margin: 10px;
            flex: 1 1 300px;
        }
        .footer-left > p{
        text-align: left;
        }
        .details {
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            text-align: center;
            background-color: #459C7F;
            font-size: 60px;
            color: #12374A;
        }
        .details > .details-1 {
            text-align: center;
        }
        .details > .details-1 > h1 {
            color: #E9BF65;
            background-color: #12374A;
            border-radius: 10px;
            width: 100px;
            height: 50px;
            margin: 10px;
        }
        .courses {
            background-color: #12374A;
        }
        .govt, .comp, .pack {
            display: flex;
            gap: 30px;
            padding: 20px;
            justify-content: center;
            align-items: center;
        }
        .govt > h2, .comp > h2, .pack > h2 {
            color: white;
        }
        .course-card {
            text-align: center;
            background-color: #459C74;
            border-radius: 10px;
            width: auto;
        }
        .course-card > h4 {
            padding: 15px;
        }
        .course-card > .img{
            width: auto;
            height: 150px;
            margin: 15px;
        }
     </style>
</head>
<body>
    <div class="navbar-container">
        <div class="navbar">
            <div class="nleft">
                <a href="index.html"><img src="assets/Logo.png" alt="Logo" width="50" height="auto"></a>
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
    <div class="hero">
        <div class="hcontent">
            <h2>Welcome</h2>
            <h1>Sathya Academy</h1>
            <h3>Master Tech, Build Career</h3>
            <div class="hbuttons">
                <a href="courses.html" id="c">Courses</a>
                <a href="packages.html" id="p">Packages</a>
            </div>
        </div>
    </div>
    <div class="details">
            <div class="details-1">
                <h1>25+</h1>
                <h3>Courses</h3>
            </div>
            <div class="details-1">
                <h1>500+</h1>
                <h3>Students</h3>
            </div>
            <div class="details-1">
                <h1>96%</h1>
                <h3>Success</h3>
            </div>
    </div>
    <div class="courses">
        <marquee behavior="slow" direction="left">
            <div class="govt">
                <h2>Government Courses</h2>
                <?php foreach($govCourses as $g): ?>
                    <div class="course-card">
                        <img src="uploads/courses/<?= htmlspecialchars($g['image']) ?>" width="auto" height="200px">
                        <h4><?= htmlspecialchars($g['title']) ?></h4>
                    </div>
                <?php endforeach; ?>
            </div>
        </marquee>
        <marquee behavior="slow" direction="right">
            <div class="comp">
                <?php foreach($compCourses as $c): ?>
                    <div class="course-card">
                        <img src="uploads/courses/<?= htmlspecialchars($c['image']) ?>" width="auto" height="200px">
                        <h4><?= htmlspecialchars($c['title']) ?></h4>
                    </div>
                <?php endforeach; ?>
                <h2>Computer Courses</h2>
            </div>
        </marquee>
        <marquee behavior="slow" direction="left">
            <div class="pack">
                <h2>Packages</h2>
                <?php foreach($packages as $p): ?>
                    <div class="course-card">
                        <img src="uploads/packages/<?= htmlspecialchars($p['image']) ?>" width="auto" height="200px">
                        <h4><?= htmlspecialchars($p['title']) ?></h4>
                    </div>
                <?php endforeach; ?>
            </div>
        </marquee>
    </div>
    <footer>
    <div class="footer" id="contact">
        <div class="footer-left">
            <!-- <h1>Sathya Academy</h1> -->
            <address>
                39A, Building Society Street,<br>
                Near Ramleela Hopital,<br>
                Gandhi Nagar Main Road,<br>
                Batlagundu, Dindigul Dt.,<br>
                Tamil Nadu - 624202
            </address>
            <p>Contact: +91 80980 24342</p>
            <p>Email: sathyaacademybtl@gmail.com</p>
            <div class="social-media">
                <a href="https://www.instagram.com/_sathya_academy_btl?utm_source=qr&igsh=cnhzbHB6a2h4bm12"><img src="./assets/Intagram.jpg" alt="Intagram Logo" width="25"></a>
                <a href="https://www.facebook.com/share/16QYSzmH8t/"><img src="./assets/facebook.jpg" alt="Facebook Logo" width="25"></a>
                <a href="https://www.threads.net/@_sathya_academy_btl"><img src="./assets/threads.png" alt="Threads Logo" width="25"></a>
                <a href="https://x.com/Sathya_Academy?t=yLxHx9xUhAaYKfQCXj_bqQ&s=08"><img src="./assets/X.png" alt="X Logo" width="25"></a>
                <a href="https://youtube.com/@sathyaacademy-btl?si=WJapsgOSoSNBm_l_"><img src="./assets/youtube.jpg" alt="Youtube Logo" width="25"></a>
                <a href="https://wa.me/message/AESPK5DPFXQVD1"><img src="./assets/whatsapp.jpg" alt="Whatsapp Logo" width="25"></a>
            </div>
        </div>
        <div class="footer-middle">
            <p>&copy; Sathya Academy, 2025</p>
        </div>
        <div class="footer-right">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3927.190962805451!2d77.75213747354306!3d10.165127770174605!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3b074f84aad9abe7%3A0x3426676831e9ea7c!2sSathya%20Academy!5e0!3m2!1sen!2sin!4v1744982086749!5m2!1sen!2sin" width="300" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
    </footer>
    <script>
        // counting numbers (home page)
        const counters = document.querySelectorAll(".details-1 h1");
        counters.forEach(counter => {
        const updateCount = () => {
            const target = +counter.textContent.replace(/\D/g, '');
            const speed = 500;
            let count = 0;
            const increment = target / speed;

            const animate = () => {
            if (count < target) {
                count += increment;
                counter.textContent = Math.ceil(count) + (counter.textContent.includes("%") ? "%" : "+");
                requestAnimationFrame(animate);
            } else {
                counter.textContent = target + (counter.textContent.includes("%") ? "%" : "+");
            }
            };

            animate();
        };
        updateCount();
        });
    </script>
</body>
</html>