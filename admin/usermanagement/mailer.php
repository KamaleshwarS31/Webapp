<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/mail_error.log');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/* Absolute base path (safe & portable) */

require_once __DIR__ . '/../../PHPMailer-master/PHPMailer-master/src/Exception.php';
require_once __DIR__ . '/../../PHPMailer-master/PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/../../PHPMailer-master/PHPMailer-master/src/SMTP.php';

require_once __DIR__ . '/email_templates/welcome_user.php';
require_once __DIR__ . '/email_templates/profile_updated.php';
require_once __DIR__ . '/email_templates/password_changed.php';
require_once __DIR__ . '/email_templates/account_status.php';


function sendMail($to, $subject, $body)
{
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'sathyaacademybtl@gmail.com';
        $mail->Password = 'cvxu spxh abbq vgwv'; // App password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('sathyaacademybtl@gmail.com', 'Sathya Academy');
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
        return true;

    } catch (Exception $e) {
        // Optional: log error
        error_log("Mailer Error: " . $mail->ErrorInfo);
        return false;
    }
}
