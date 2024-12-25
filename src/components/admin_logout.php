<?php

include 'connect.php';

session_start(); // Start the session

// Destroy session to log out
session_unset(); 
session_destroy(); 

// Redirect to admin login page after logout
header('Location: ../admin/admin_login.php');
exit(); // Make sure no further code is executed after redirection
?>
