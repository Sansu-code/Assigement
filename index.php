<?php

session_start();
if (!isset($_SESSION["user"])){
    header("Location: login.php");

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
</head>
<body>
    <!-- Dashboard page after login-->
    <div class="container">
        <h1>Welcome to Dashboard</h1>
        <a href="logout.php" input type= "submit" name="Logout">Logout</a>

    </div>
    
</body>
</html>