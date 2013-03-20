<?php

	session_start();
	
	include_once('sessions.php');
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
	if( isset($_SESSION['customerId']) && isset($_SESSION['sessionId']) )
	{
		$loggedIn = validateSession();
	}
	else
	{
		$loggedIn = false;
	}
	if( !isset($_POST['emailspam'] ) )
	{
		$emailspam = 0;
	}
	else
	{
		$emailspam = 1;
	}
// if all the form data is available and valid, then create their account
	 if( isset($_POST['username']) && strlen($_POST['username']) > 3 &&
		 isset($_POST['password']) && strlen($_POST['password']) > 6 &&
		 isset($_POST['passConf']) && $_POST['password'] === $_POST['passConf'] &&
		 isset($_POST['firstname']) && strlen($_POST['firstname']) >=2 &&
		 isset($_POST['lastname']) && strlen($_POST['lastname']) >= 2 &&
		 isset($_POST['middleinit']) && strlen($_POST['middleinit']) > 0 &&
		 isset($_POST['email']) && strlen($_POST['email']) >= 7 )
		 {
			 // build query
			 $query = "UPDATE customer SET  CustomerID=".$_SESSION['customerId']." , 
			 CustomerLogin='".$_POST['email']."', CustPassword='".$_POST['password']."', CustScreenName='".$_POST['username']."', CustLastName='".$_POST['lastname']."', CustFirstName='".$_POST['firstname']."', CustMiddleName='".$_POST['middleinit']."', CustActive='1',  EmailSpam='".$emailspam."' WHERE CustomerID=".$_SESSION['customerId']."";
				// Update user
		     $result = mysql_query($query);
			echo ' <script type="text/javascript">
						<!--
						window.location = "../pages/editaccount.php?reg=successful"
						//-->
						</script>';
			 

		 }
		 else
		 {
			 echo ' <script type="text/javascript">
						<!--
						window.location = "../pages/editaccount.php?reg=failed"
						//-->
						</script>';
		 }
		 
		 
?>
