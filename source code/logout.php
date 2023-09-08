<?php

@include 'config.php';

session_start();
// Clear all session variables
session_unset();
// Destroy the session
session_destroy();

// Redirect to the login page
header('location:login.php');

?>