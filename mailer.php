<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . "/vendor/autoload.php";

$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->isHtml(true);
$mail->Host = "smtp.gmail.com";
$mail->SMTPSecure = "tls";
$mail->Port = 587;
$mail->Username = "sansu.aryal.1013@gmail.com"; // Your Gmail address
$mail->Password = "yxqgiphpslkiknzu"; // Your Gmail password

// Additional SMTP options if needed
$mail->SMTPOptions = [
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => false
    ]
];