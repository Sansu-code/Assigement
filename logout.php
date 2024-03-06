<?php
//logout page takes user again to login page
session_start();
session_destroy();
header("Location: login.php");
?>