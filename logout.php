<?php
   session_start();
   unset($_SESSION["username"]);
   unset($_SESSION["password"]);
   unset($_SESSION["role"]);
   
   echo 'You have successfully logged out';
   header('Refresh: 2; URL = schedule.php');
?>