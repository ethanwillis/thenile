<?php
	session_start();
	include_once('../processors/sessions.php');

	/**
	 * addToCart.php
	 * Adds an item specified by UPC to the user's shopping cart.
	 */ 
	 
	 // check if the upc variable is set so we can find and add a product
	 // to our cart.
	 
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
	
	//make sure a upc was passed
	if( isset($_GET['upc']) )
	{
		// make sure the customer is logged in.
		if( checkSession() )
		{
			// if the item is to be removed
			if( isset($_GET['rem']) && $_GET['rem'] === 'true' )
			{
				$query = "SELECT Quantity FROM cart WHERE CustomerID=".$_SESSION['customerId']." AND Upc=".$_GET['upc'];
				$result = mysql_query($query);
				if( mysql_num_rows($result) > 0 )
				{
					$row = mysql_fetch_array($result);
					$quantity = $row['Quantity'] - 1;
					if( $quantity > 0 )
					{
						$query = "UPDATE cart SET  Quantity= ".$quantity." WHERE CustomerID=".$_SESSION['customerId']." AND CONCAT( Upc )= ".$_GET['upc']."";
					}
					else
					{
						$query = "DELETE FROM cart WHERE CustomerID=".$_SESSION['customerId']." AND CONCAT( Upc )= ".$_GET['upc']."";
					}
					
					mysql_query($query);
					echo ' <script type="text/javascript">
							<!--
							window.location = "../pages/shoppingcart.php"
							//-->
							</script>';
				}
			}
			else // otherwise add the item
			{
				$quantity = 1;
				$query = "SELECT Quantity FROM cart WHERE CustomerID=".$_SESSION['customerId']." AND Upc=".$_GET['upc'];
				$result = mysql_query($query);
				if( mysql_num_rows($result) > 0 )
				{
					$row = mysql_fetch_array($result);
					$quantity = $quantity + $row['Quantity'];
					$query = "UPDATE cart SET  Quantity= ".$quantity." WHERE CustomerID=".$_SESSION['customerId']." AND CONCAT( Upc )= ".$_GET['upc']."";
				}
				else
				{
					$query = "INSERT INTO cart ( CustomerID, Upc, Quantity ) VALUES ( ".$_SESSION['customerId'].", ".$_GET['upc'].", ".$quantity.")";
				}
				$result = mysql_query($query);
				if(!$result)
				{
					// if there was an error adding the item to their cart redirect
					// the customer back to the item page and inform them
					//echo ' <script type="text/javascript">
							//<!--
							//window.location = "/pages/product.php?upc='.$_GET['upc'].'&val=failedadd"
							//-->
							//</script>';
				}
				else
				{
					// the item was succsessfully added to their cart.
					echo ' <script type="text/javascript">
							<!--
							window.location = "../pages/product.php?upc='.$_GET['upc'].'&val=successfuladd"
							//-->
							</script>';
				}
			}
		}
		else // if they arent logged in redirect them to the login page
		{
			echo ' <script type="text/javascript">
						<!--
						window.location = "../pages/login.php?reg=failedadd"
						//-->
						</script>';
		}
		
	}
?>
