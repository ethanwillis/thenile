<?php
	/**
	* Sessions php
	* This is a controller that provides the ability for creating and 
	* destroying sessions in the database for users.
	*/
	
	function createSession( $customerId, $uniqueValue )
	{
		$sessionId = sha1($uniqueValue.time());
		
		session_start();
		$_SESSION['customerId'] = $customerId;
		$_SESSION['sessionId'] = $sessionId;
		$query = "SELECT * FROM sessions WHERE CustomerID=".$customerId."";
		$result = mysql_query($query);
		if( mysql_num_rows($result) > 0 )
		{
			$query="DELETE FROM sessions WHERE CustomerID=".$customerId."";
			mysql_query($query);
		}
		$result = mysql_query($query);
		$query = "INSERT INTO sessions ( CustomerID, SessionID, LastVisit ) VALUES ( ".$_SESSION['customerId'].", '".$_SESSION['sessionId']."', ".time().")";
		$result = mysql_query($query);
		$query = "SELECT CustScreenName FROM customer WHERE CustomerId=".$customerId."";
		$result2 = mysql_query($query);
		if(!$result2)
		{
			return false;
		}
		else
		{
			$row = mysql_fetch_array($result2);
			$_SESSION['screenname'] = $row['CustScreenName'];
		} 
		if(!$result)
		{
			return false;
		}
		if(isset($_SESSION['sessionId']) && isset($_SESSION['customerId']))
		{
			return true;
		}
		else
		{
			echo $_SESSION['customerId'];
			echo $_SESSION['sessionId'];
			return false;
		}
	}
	
	function validateSession( )
	{
		$query = "SELECT CustomerID, SessionID, LastVisit FROM sessions WHERE CustomerID=".$_SESSION['customerId']." AND SessionID='".$_SESSION['sessionId']."'";
		$result = mysql_query($query);
		
		if(!$result)
		{
			// if the query didn't execute the session cant be checked for
			// validity
			return false;
		}
		else
		{
			// if a result is returned from the query then the session is valid
			if( mysql_num_rows($result) > 0 )
			{
				// create a new session id and update it in the database and in the session vars.
				renewSession($_SESSION['customerId'], $_SESSION['sessionId']);
				return true;
			}
			else
			{
				return false;
			}
			
		}
	}
	
	function checkSession()
	{
		$query = "SELECT CustomerID, SessionID, LastVisit FROM sessions WHERE CustomerID=".$_SESSION['customerId']." AND SessionID='".$_SESSION['sessionId']."'";
		$result = mysql_query($query);
		
		if(!$result)
		{
			// if the query didn't execute the session cant be checked for
			// validity
			return false;
		}
		else
		{
			// if a result is returned from the query then the session is valid
			if( mysql_num_rows($result) > 0 )
			{
				return true;
			}
			else
			{
				return false;
			}
			
		}
	}
	
	function renewSession($customerId, $sessId)
	{
		$newSessId = sha1(time().$sessId);
		$_SESSION['sessionId'] = $newSessId;
		$query = "UPDATE sessions SET CustomerID=".$customerId.", SessionID='".$newSessId."', LastVisit=".time()." WHERE CustomerID=".$customerId."";
		mysql_query($query);
	}
	
	function destroySession($customerId)
	{
		$query = "DELETE FROM sessions WHERE CustomerID=".$customerId."";
		session_destroy();
		mysql_query($query);
	}
?>
