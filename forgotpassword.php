<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot PASSWORD</title>
</head>
<body>
    <h1>Enter Your Email To Reset Password</h1>
    <p>An e-mail will be send with instructions</p>

    <form method="POST" action="sendpasswordreset.php">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Enter Your Email">
        <button type= "submit" name="reset-password">Send Link</button>
    </form>
 
</body>
</html>