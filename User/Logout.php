<?php 
session_start();
unset($_SESSION['auth']);
header('Location: http://127.0.0.1/BeCoffee/');
?>