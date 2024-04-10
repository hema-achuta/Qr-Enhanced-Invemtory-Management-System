<?php
session_start();
if(session_destroy()) // Destroying All Sessions
{
header("Location: shipperlogin.php"); // Redirecting To Home Page
}
?>