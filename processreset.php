<?php
// Include database configuration
require_once "database.php";

// Check if form is submitted and all fields are filled
if(isset($_POST['submit']) && !empty($_POST['password']) && !empty($_POST['retype_password']) && !empty($_POST['token'])) {
    // Sanitize and validate password fields
    $password = $_POST['password'];
    $retype_password = $_POST['retype_password'];

    // Check if passwords match
    if($password !== $retype_password) {
        echo "Passwords do not match.";
        exit;
    }

    // Check if password meets minimum length requirement
    if(strlen($password) < 8) {
        echo "Password should be at least 8 characters long.";
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Update password in the database
    $sql = "UPDATE user SET password = ? WHERE reset_token_hash = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        echo "Error preparing statement: " . mysqli_error($conn);
        exit;
    }

    $token = $_POST['token'];
    $token = filter_var($token, FILTER_SANITIZE_STRING);
    $token_hash = hash("sha256", $token);
    mysqli_stmt_bind_param($stmt, "ss", $hashed_password, $token_hash);
    if(!mysqli_stmt_execute($stmt)) {
        echo "Error updating password: " . mysqli_stmt_error($stmt);
        exit;
    }

    // Password updated successfully
    echo "Password updated successfully.";
} else {
    // Form not submitted or fields are empty
    echo "Please fill all fields in the form.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
</head>
   

<body>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sucess</title>
    <div class="container">
    <h1>Successfully changed password now Login</h1>
   
    <a href="logout.php" input type= "submit" name="Login">Login</a>
</body>
</html>