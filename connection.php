<?php
	$appname	= "Dating App";
	$dbname		= "dating_app";
	$dbuser		= "dateappmaster";
	$dbpass		= "dateappmaster.4";
	$dbhost		= "localhost";
	
	$time		= time();
	
	$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) or die("Error Connecting to Database");
	
	function sanitizeString($con,$val) {
		$val = strip_tags($val);
		$val = htmlentities($val);
		$val = stripslashes($val);
		return mysqli_real_escape_string($con,$val);
	}
?>