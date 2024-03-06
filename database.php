<?php

// Sql type define 
$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "rf";

//$conn to connect with sql server
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);

//Check if $conn is true or not
if (!$conn) {
    echo("Something went worng:");
}

?>