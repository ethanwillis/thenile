<?php

	include_once('../processors/sessions.php');
	/**
	* loginProcessor.php
	* This processor takes form data from the login form and creates
	* a new session for the customer if they provide the correct
	* login information
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
	
	// validate the user's login information if it is available
	if(isset($_POST['email']) && isset($_POST['password']) )
	{
		// if the email and password are available fetch the
		// user's customerid, username and password information.
		$query = "SELECT CustPassword, CustomerID, CustScreenName FROM customer WHERE CustomerLogin='".$_POST['email']."' AND CustPassword='".$_POST['password']."'";
		
		
		$result = mysql_query( $query );
		// if there was an error while querying then redirect the user to the login form.
		if(!$result)
		{
			echo ' <script type="text/javascript">
						<!--
						window.location = "../pages/login.php?reg=failed"
						//-->
						</script>';
		}
		else
		{
			//otherwise check to make sure that an account was returned
			if( mysql_num_rows( $result ) > 0 )
			{
				$row = mysql_fetch_array($result);
				
				// if there was an account create a session in the user's browser
				if( createSession( $row['CustomerID'], $row['CustomerID']) )
				{
					 //if the session was successfully created direct the user to the homepage
					 echo ' <script type="text/javascript">
						<!--
						window.location = "../pages/fluid.php?login=successful"
						//-->
						</script>';
				}
				else
				{
					// otherwise the session was not created successfully redirect them to the
					// login page.
					
					echo ' <script type="text/javascript">
						<!--
						window.location = "../pages/login.php?reg=failed"
						//-->
						</script>';
				}
			}
			else // there was no account found; redirect to login page
			{
				echo ' <script type="text/javascript">
						<!--
						window.location = "../pages/login.php?reg=failed"
						//-->
						</script>';

			}
		}
		
	}
?>
