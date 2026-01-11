<?php
/* Security headers */
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', isset($_SERVER['HTTPS']));
session_start();
session_regenerate_id(true);

// Recaptcha
$RECAPTCHA_SITE_KEY = "6Lc7CEIsAAAAAMGrAukz3PJDRv9M9uU1VPQZOXZ1";
$RECAPTCHA_SECRET_KEY = "6Lc7CEIsAAAAAE_96ybdgMQwUHpoygBsDnL6x9xm";

$conn = mysqli_connect("localhost", "root", "", "sathya_academy");
if(!$conn){
    die("Database connection failed");
}

if(empty($_SESSION['csrf_token'])){
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Notification
$notifications = [];
$nQuery = "SELECT title, link FROM notifications WHERE status=1 ORDER BY id DESC";
$nResult = mysqli_query($conn, $nQuery);
while($row = mysqli_fetch_assoc($nResult)){
    $notifications[] = $row;
}


$error = "";
/* Login handler */
if($_SERVER["REQUEST_METHOD"] === "POST"){
    /*CSRF Token*/
    if(!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')){
        die("Invalid Request");
    }

    /*Input Validatin*/
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if(strlen($username) < 3 || strlen($username) > 50){
        $error = "Invalid login credentials";
    }elseif(strlen($password) < 6) {
        $error = "Invalid login credentials";
    }else{
        $username = mysqli_real_escape_string($conn, $username);

        $query = "SELECT * FROM users WHERE username='$username' AND status=1 LIMIT 1";
        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result) === 1){
            $user = mysqli_fetch_assoc($result);

            /*Login Attempt Limit*/
            if($user['failed_attempts'] >= 5){
                $error = "Account temporariy locked. Try later.";
            }else{
                if (empty($_POST['g-recaptcha-response'])) {
                $error = "Please verify captcha";
            } else {

                $captcha = $_POST['g-recaptcha-response'];
                $verify = file_get_contents(
                    "https://www.google.com/recaptcha/api/siteverify?secret="
                    . $RECAPTCHA_SECRET_KEY . "&response=" . $captcha
                );
                $captchaSuccess = json_decode($verify);

                if (!$captchaSuccess->success) {
                    $error = "Captcha verification failed";
                }
            }
                if(password_verify($password, $user['password'])){
                    /* Reset failed attempts */
                    mysqli_query($conn, "UPDATE users SET failed_attempts=0, last_failed=NULL WHERE id=".$user['id']);

                    /* set session */
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];

                    session_regenerate_id(true);

                    /* Role based redirect */
                    switch($user['role']){
                        case 'admin':
                            header("Location: admin/dashboard.php");
                            exit;
                        case 'student':
                            header("Location: student/dashboard.php");
                            exit;
                        case 'teacher':
                            header("Location: teacher/dashboard.php");
                            exit;
                        case 'alumni':
                            header("Location: alumni/dashboard.php");
                            exit;
                        default:
                            $error = "Invalid user role";
                    }
                    exit;
                }else{
                    /* Update failed attempts */
                    mysqli_query($conn, "UPDATE users SET failed_attempts = failed_attempts+1, last_failed=NOW() WHERE id=".$user['id']); 

                    $error = "Invalid login credentials";
                }
            }
        } else {
            $error = "Invalid login credentials";
        }
    }
}
// Recaptcha
$RECAPTCHA_SITE_KEY = "6Lc7CEIsAAAAAMGrAukz3PJDRv9M9uU1VPQZOXZ1";
$RECAPTCHA_SECRET_KEY = "6Lc7CEIsAAAAAE_96ybdgMQwUHpoygBsDnL6x9xm";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
        .login{
            background-color: #12374A;
            height: 496px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .form {
            text-align: center;
            background-color: #459C7F;
            height: 300px;
            width: 350px;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        form > input{
            margin: 5px;
            width: 250px;
            border-radius: 5px;
            height: 40px;
            border: none;
        }
        form > button {
            width: 240px;
            border-radius: 5px;
            height: 35px;
            border: none;
            background-color: #12374A;
            color: #E9BF65;
        }
        form > button:hover{
            background-color: #E9BF65;
            color: #12374A;
        }
        form > a {
            color: #12374A;
            text-decoration: none;
        }
        form > a:hover {
            text-decoration: underline;
        }
        /* Modal Background */
        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.6);
        }

        /* Modal Box */
        .modal-content {
            background: #459C7F;
            width: 320px;
            margin: 120px auto;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            position: relative;
        }

        /* Close Button */
        .close {
            position: absolute;
            right: 10px;
            top: 5px;
            font-size: 22px;
            cursor: pointer;
        }

        /* Inputs */
        .modal-content input {
            width: 90%;
            padding: 8px;
            margin: 6px 0;
            border-radius: 4px;
            border: none;
        }

        /* Buttons */
        .modal-content button {
            width: 95%;
            padding: 8px;
            margin-top: 8px;
            background: #12374A;
            color: #E9BF65;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .modal-content button:hover {
            background: #E9BF65;
            color: #12374A;
        }

        /* Messages */
        .error {
            color: red;
            font-size: 14px;
        }
        .success {
            color: green;
            font-size: 14px;
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
                <a href="home.php">Home</a>
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
    <div class="login">
        <div class="form">
            <form action="login.php" method="post" novalidate>
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <input type="text" name="username" id="username" placeholder="Username" required><br>
                <input type="password" name="password" id="password" placeholder="Password" required><br>
                <div class="g-recaptcha" data-sitekey="<?= $RECAPTCHA_SITE_KEY ?>"></div>

                <button type="submit">Login</button><br>
                <a href="#" onclick="openModal()" style="margin-top:10px;">Forgot Password?</a>
                <?php if(!empty($error)): ?>
                <p style="color:red; font-weight:bold;">
                    <?= htmlspecialchars($error) ?>
                </p>
                <?php endif; ?>
                <?php
                if (isset($_GET['msg']) && $_GET['msg'] === 'reset_success') {
                    echo "<p style='color:green'>Password reset successful. Login now.</p>";
                }
                ?>
            </form>
        </div>
    </div>
    <div class="modal" id="fpModal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3 id="modalTitle" >Forgot Password</h3>
            <div id="stepEmail">
                <input type="email" id="fp_email" placeholder="Registered Email ID">
                <button onclick="sendOTP()">Send OTP</button>
            </div>

            <div id="stepOTP" style="display:none;">
                <input type="text" id="fp_otp" placeholder="Enter OTP">
                <button onclick="verifyOTP()">Verify OTP</button>
            </div>

            <div id="stepReset" style="display: none;">
                <input type="password" id="fp_pass" placeholder="New Password">
                <input type="password" id="fp_confirm" placeholder="Confirm Password">
                <button onclick="resetPassword()">Reset Password</button>
            </div>

            <p id="fp_error" class="error"></p>
            <p id="fp_success" class="success"></p>
    </div>
    <script>
function openModal() {
    document.getElementById("fpModal").style.display = "block";
}

function closeModal() {
    document.getElementById("fpModal").style.display = "none";
    resetSteps();
}

function resetSteps() {
    stepEmail.style.display = "block";
    stepOTP.style.display = "none";
    stepReset.style.display = "none";
    fp_error.innerText = "";
    fp_success.innerText = "";
}

function sendOTP() {
    fetch("forgot_password.php", {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({ email: fp_email.value })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            stepEmail.style.display = "none";
            stepOTP.style.display = "block";
            fp_success.innerText = data.msg;
            fp_error.innerText = "";
        } else {
            fp_error.innerText = data.msg;
        }
    });
}

function verifyOTP() {
    fetch("verify_otp.php", {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({ otp: fp_otp.value })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            stepOTP.style.display = "none";
            stepReset.style.display = "block";
            fp_error.innerText = "";
        } else {
            fp_error.innerText = data.msg;
        }
    });
}

function resetPassword() {
    fetch("reset_password.php", {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({
            password: fp_pass.value,
            confirm: fp_confirm.value
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            fp_success.innerText = "Password reset successful!";
            fp_error.innerText = "";
            setTimeout(() => {
                closeModal();
                location.reload();
            }, 2000);
        } else {
            fp_error.innerText = data.msg;
        }
    });
}

/* Close modal when clicking outside */
window.onclick = function(e) {
    if (e.target === document.getElementById("fpModal")) {
        closeModal();
    }
};
</script>
</body>
</html>