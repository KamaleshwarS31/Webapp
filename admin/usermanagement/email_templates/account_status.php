<?php
function accountStatusTemplate($name, $status)
{
    $title = $status ? "Account Activated 🎉" : "Account Deactivated ⚠️";
    $message = $status
        ? "Your account has been <b>activated</b>. You can now log in and access our services."
        : "Your account has been <b>deactivated</b>. Please contact the administrator for more details.";

    $color = $status ? "#459C7F" : "#d9534f";

    return "
    <div style='font-family:Arial;background:#f4f6f8;padding:20px'>
        <div style='max-width:600px;margin:auto;background:#ffffff;
                    border-radius:8px;padding:20px'>

            <h2 style='color:$color;'>$title</h2>

            <p>Dear <b>$name</b>,</p>

            <p>$message</p>

            <p style='margin-top:20px'>
                If you have any questions, please contact Sathya Academy.
            </p>

            <hr>

            <p style='font-size:12px;color:#666'>
                Sathya Academy<br>
                Master Tech, Build Career
            </p>
        </div>
    </div>
    ";
}
