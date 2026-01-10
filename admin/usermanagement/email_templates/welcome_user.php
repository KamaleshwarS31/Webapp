<?php
function welcomeUserTemplate($name, $username, $password) {
    return "
    <div style='font-family: Arial; background: #f4f6f8; padding: 20px'>
    <div style='max-width: 600px; margin: auto; background: #ffffff; border-radius: 8px; padding: 20px'>
    <h2 style='color:#12374A'>Welcome to Sathya Academy 🎉</h2>
    <p>Dear <b>$name</b>,</p>
    <p>We are happy to inform you that your account has been successfully created.</p>
    <div style='background:#f0f0f0; padding: 15px; border-radius: 6px'>
    <p><b>Username:</b> $username</p>
    <p><b>Password:</b> $password</p>
    </div>
    
    <p style='margin-top: 15px;'>
    Please login and change your password after your first login for security. </p>
    
    <p>
    <a href='https://sathyaacademy.in/login.php'>Login Here</a>
    </p>
    
    <hr>
    <p style='font-size: 12px; color: #666'>
    Sathya Academy<br>
    Master Tech, Build Career
    </p>
    </div>
    </div>";
}
?>