<?
 ?>
<?php
require_once('include/config.php');

session_name("jbsakad");
session_start();

if (isset($_SESSION['namasimaka'])) 
	include("index2.php");
else 
	include("login.php");
	
?>