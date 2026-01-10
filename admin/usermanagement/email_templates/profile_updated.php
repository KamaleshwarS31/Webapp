<?php
function profileUpdatedTemplate($name, $email, $username, $role) {
    return "
    <div style='font-family:Arial;background:#f4f6f8;padding:20px'>
        <div style='max-width:600px;margin:auto;background:#ffffff;border-radius:8px;padding:20px'>
            <h2 style='color:#12374A'>Profile Updated</h2>

            <p>Dear <b>$name</b>,</p>

            <p>Your profile details have been updated by the administrator.</p>

            <div style='background:#f0f0f0;padding:15px;border-radius:6px'>
                <p><b>Name:</b> $name</p>
                <p><b>Email:</b> $email</p>
                <p><b>Username:</b> $username</p>
                <p><b>Role:</b> $role</p>
            </div>

            <p>If you did not request this change, please contact the admin immediately.</p>

            <hr>
            <p style='font-size:12px;color:#666'>
                Sathya Academy<br>
                Master Tech, Build Career
            </p>
        </div>
    </div>";
}
