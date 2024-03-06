<?php
// Include database configuration
require_once "database.php";

// Check if token is provided in the URL
if(isset($_GET['token'])) {
    $token = $_GET['token'];
    $token = filter_var($token, FILTER_SANITIZE_STRING);
    $token_hash = hash("sha256", $token);
    // Query to check token validity
    $sql = "SELECT reset_token_hash, reset_token_expire_at FROM user WHERE reset_token_hash = ?";
    $stmt = mysqli_stmt_init($conn);
    if(mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $token_hash);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if(mysqli_num_rows($result) > 0) {
            // Token is valid, display reset password form
            ?>
            <!DOCTYPE html>
            <html>
            <head>
                <title>Reset Password</title>
            </head>
            <body>
                <h2>Reset Your Password</h2>
                <form action="processreset.php" method="post">
                    <!--Create form for Password-->
                    <div class="form-group">
                        <input type="password" name="password" placeholder="Password">
                    </div>
                    <!--Create form for Retype Password-->
                    <div class="form-group">
                        <input type="password" name="retype_password" placeholder="Retype Password">
                    </div>
                    <!--Hidden input field for token-->
                    <input type="hidden" name="token" value="<?php echo $token; ?>">
                    <!--Create Submit Button-->
                    <div class="form-group">
                        <input type="submit" value="Submit" name="submit">
                    </div>
                </form>
            </body>
            </html>
            <?php
        } else {
            // Token is invalid or expired
            echo "Invalid or expired token.";
        }
    } else {
        echo "Error preparing statement: " . mysqli_stmt_error($stmt);
    }
} else {
    // Token is not provided in the URL
    echo "Token not provided.";
}
?>
