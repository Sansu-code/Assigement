<?php
// Validate and sanitize email input
$email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email address";
    exit;
}

// Generate token and expiry time

$token = bin2hex(random_bytes(16));
$token_hash = hash("sha256", $token);
$expiry = date("Y-m-d H:i:s", time() + 60 * 30); // 30 minutes from now

// Include database configuration
require_once "database.php";
require_once "mailer.php"; // Include mailer configuration

$sql = "UPDATE user
        SET reset_token_hash = ?,
            reset_token_expire_at = ?
        WHERE email = ?";

$stmt = mysqli_stmt_init($conn);
if (!$stmt) {
    echo "Error initializing statement: " . mysqli_error($conn);
    exit;
}

$preparestmt = mysqli_stmt_prepare($stmt, $sql);
if (!$preparestmt) {
    echo "Error preparing statement: " . mysqli_error($conn);
    exit;
}

mysqli_stmt_bind_param($stmt, "sss", $token_hash, $expiry, $email);

if (!mysqli_stmt_execute($stmt)) {
    echo "Error executing statement: " . mysqli_stmt_error($stmt);
    exit;
}

if (mysqli_affected_rows($conn) > 0) {
    // Proceed with sending email
    $mail->setFrom("sansu.aryal.1013@gmail.com"); // Set the sender email address
    $mail->addAddress($email);
    $mail->Subject = "Password Reset";
    $mail->Body = "Click the following link to reset your password:https://localhost/registration/resetpassword.php?token=$token";

    try {
        $mail->send();
        echo "Password reset email sent successfully.";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
    }
} else {
    echo "No user found with the provided email address.";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>