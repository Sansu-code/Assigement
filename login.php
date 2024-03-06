<?php
session_start();
if (isset($_SESSION["user"])){
    header("location: index.php");

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
</head>
<body>
    <div class="container">
        <?php
        //Post method decribed
        if (isset($_POST["Login"])) {
            $email = $_POST["email"];
            $password = $_POST["password"];
           //Access the data from database.php
            require_once "database.php";
            //Connecting to database
            $sql = "SELECT * FROM user WHERE email = '$email' ";
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if ($user) {
              //Password varification
                if (password_verify($password, $user["Password"])){
                
                $_SESSION["user"] = "yes";
                header("Location: index.php");
                die();
              }else{
                echo "<div> Password Does Not Match</div>";
              }
            }else{
                echo "<div> Email Does Not Match </div>";
            }


        }
        ?>
        <form action="login.php" method="post">
            <div class="form-group">
                <input type="email" placeholder="Enter Email:" name="email">
            </div>
            <div class="form-group">
                <input type="password" placeholder="Enter Password:" name="password">
            </div>
            <div class="form-group">
                <input type="submit" value="Login" name="Login">
            </div>
        </form>
       <div><p>Not registered<a href="registration.php"> Register Here</a></p></div>
       <div><p>Reset Password<a href="forgotpassword.php" input type= "submit" name="Forgot_Password"> Forgot Password</a></div>

    
</body>
</html> 