<?php
session_start();
include_once 'db_connect.php';

if(isset($_SESSION['admin'])) {
	session_destroy();
	unset($_SESSION['admin']);
	header("Location: index.php");
} else {
	header("Location: index.php");
}



?>