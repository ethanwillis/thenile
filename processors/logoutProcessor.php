<?php
	/**
	 * logoutProcessor.php
	 */ 
	 
	 	 // Setup variables for opening a mysql connection
	// Information for connecting to THE NILE database.
	$username="root";
	$password="";
	$database="mydb";
	$hostname="localhost";

	// Open a connection to the database.
	mysql_connect($hostname, $username, $password);

	// Select the database to use or quit if there is an error.
	@mysql_select_db($database) or die( "Unable to select database");
	 session_start();
	
	 include_once('../processors/sessions.php');
	 
	 if( checkSession() )
	 {
		 destroySession($_SESSION['customerId']);
		 echo ' <script type="text/javascript">
						<!--
						window.location = "../pages/login.php"
						//-->
						</script>';
	 }
	 else
	 {
		 echo ' <script type="text/javascript">
						<!--
						window.location = "../pages/login.php"
						//-->
						</script>';
	 }
?>
