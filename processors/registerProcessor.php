<?php
	/**
	 * registerProcessor.php
	 * Takes form data from the user and creates an account for them
	 * and then redirects them to the login page. If there is an error
	 * they are redirected to the signup page.
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
	 
	 // if all the form data is available and valid, then create their account
	 if( isset($_POST['username']) && strlen($_POST['username']) > 3 &&
		 isset($_POST['password']) && strlen($_POST['password']) > 6 &&
		 isset($_POST['passConf']) && $_POST['password'] === $_POST['passConf'] &&
		 isset($_POST['firstname']) && strlen($_POST['firstname']) >=2 &&
		 isset($_POST['lastname']) && strlen($_POST['lastname']) >= 2 &&
		 isset($_POST['middleinit']) && strlen($_POST['middleinit']) > 0 &&
		 isset($_POST['email']) && strlen($_POST['email']) >= 7 &&
		 isset($_POST['isActive']) && 
		 isset($_POST['joinDate']) &&
		 isset($_POST['emailspam']) &&
		 isset($_POST['tos']) && $_POST['tos'] === "on")
		 {
			 if($_POST['emailspam'] === "on")
			 {
				 $emailspam = 1;
			 }
			 else
			 {
				 $emailspam = 2;
			 }
			 // build query
			 $query = "INSERT INTO customer (`CustomerID`, `CustScreenName`, 
			 `CustPassword`, `CustomerLogin`, `CustLastName`, `CustFirstName`, 
			 `CustMiddleName`, `CustActive`, `JoinDate`, `EmailSpam`) VALUES ( 
			 NULL ,  '".$_POST['username']."' ,  '".$_POST['password']."' ,  '".$_POST['email']."' ,  
			 '".$_POST['lastname']."' ,  '".$_POST['firstname']."' ,  '".$_POST['middleinit']."' ,  '1' ,  '".$_POST['joinDate']."' ,  '".$emailspam."');";
			 
			 // insert the user into the database
			 $result = mysql_query($query);
			 
			 if (!$result) 
			 {
				
				echo ' <script type="text/javascript">
						<!--
						window.location = "../pages/register.php?reg=failed"
						//-->
						</script>';
			}
			else
			{
				// the account was succsessfully created
				echo ' <script type="text/javascript">
						<!--
						window.location = "../pages/login.php?reg=success"
						//-->
						</script>';
			}
		 }
	 else // otherwise redirect them back to the registration page
	 {
		 echo ' <script type="text/javascript">
						<!--
						window.location = "../pages/register.php?reg=failed"
						//-->
						</script>';
	 }
?>
