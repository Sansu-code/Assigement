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
    <title>Resgistration Form</title>
    
</head>
<body>
    <div class="container">
        <?php
        // Is Set defines value Null or Not
        if (isset($_POST["submit"])){
            $fullname = $_POST["fullname"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $passwordretype = $_POST["retype_password"];
        //Password_hash:Creates a Password hash. Password_default:Default algorthim used for hashing. 
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
          //Decribes error  
            $errors = array();
            
            if (empty($fullname) OR empty($email) OR empty($password) OR empty($passwordretype)){
              array_push($errors,"All fields are required");  
            }
            //Email Validation using filter_var
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
              array_push($errors, "Email is not valid");
            }
            //Password Validation using strlen less than 8
            if(strlen($password)<8){
                array_push($errors, "Password must be 8 character long");         
               }
               //Both Password should  match
               if ($password!==$passwordretype){
                array_push($errors, "Password does not match");
               }
               //Connecting With Database
               require_once "database.php";
               $sql = "SELECT * FROM user WHERE email = '$email'"; 
               $result = mysqli_query($conn, $sql); 
               $rowCount = mysqli_num_rows($result);
               if ($rowCount>0) {
                array_push($errors, "Email already exists!");
               }
               if (count($errors)>0){
                foreach ($errors as $error) {
                    echo "<div> $error </div>";
                }
               }
               else{

                //We will insert the data into database
                $sql = "INSERT INTO user(Name, Email, Password) VALUES ( ?, ?, ?)";	
                $stmt = mysqli_stmt_init($conn);
                $preparestmt = mysqli_stmt_prepare($stmt,$sql);

                // Using Prepared statement to prevent SQL injection
                if ($preparestmt) {
                    mysqli_stmt_bind_param($stmt,"sss",$fullname, $email, $passwordHash);
                    mysqli_stmt_execute($stmt);
                    echo "<div> You are registered sucessfully.</div>";

                    
                }else{
                    echo("Something Went wrong");
                }

               }

        }


         ?>
      <form action="" method="post">
        <!--Create form for Name--> 
        <div class="form-group">
            <input type="text"  name="fullname" placeholder="Full Name:">
        </div>
        <!--Create form for Email-->
        <div class="form-group">
            <input type="email"  name="email" placeholder="Email:">
        </div>
        <!--Create form for Password-->
        <div class="form-group">
            <input type="password"  name="password" placeholder="Password:">
        </div>
        <!--Create form for Retype Password-->
        <div class="form-group">
            <input type="password"  name="retype_password" placeholder="Retype Password:">
        </div>
        <!--Create Submit Button-->
        <div class="form-group">
            <input type="submit"  value="Submit" name="submit">
        </div>
     </form>
     <div><p>Already Registered<a href="login.php">Login</a></p></div>
 
    
</body>
</html>