<?php
session_start();
	
	include_once('../processors/sessions.php');
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
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Welcome to The Nile!</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
    </style>
    <link href="../assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="../pages/fluid.php"><img src="../assets/img/Nile_Logo.png"></img></a>
          <div class="nav-collapse">
            <ul class="nav">
              <li><a href="../pages/fluid.php">Home</a></li>
              <li><a href="../pages/products.php">Products</a></li>

		   <?php if($loggedIn==true){echo '<li><a href="../processors/logoutProcessor.php">Logout</a>';}else{echo'</li><li><a href="../pages/login.php">Login</a></li>
		   <li><a href="../pages/register.php">Register</a></li>';} ?>
            </ul>
            <form action="../pages/search.php" method="get">  
				<input type="text" name="searchterm" class="input-medium search-query" placeholder="Enter your Query...">  
				<button type="submit" class="btn">Search</button>  
			</form> 
            <p class="navbar-text pull-right">
				<!-- ENTER SEARCH BOX HERE LATER -->
		 </p>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span3">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
			  <?php
				if($loggedIn)
				{	
					
					echo '<li class="nav-header">Welcome, '.$_SESSION['screenname'].'</li>
					<li><a href="../pages/shoppingcart.php">Shopping Cart</a></li>
					<li><a href="../pages/editaccount.php">Account Settings</a></li>';
				}
			  ?>
              <li class="nav-header">Products</li>
              <li><a href="../pages/products.php?cat=1">Computer</a></li>
              <li><a href="../pages/products.php?cat=2">Music</a></li>
              <li><a href="../pages/products.php?cat=3">Software</a></li>
              <li><a href="../pages/products.php?cat=4">Videos</a></li>
              <li><a href="../pages/products.php?cat=5">Books</a></li>
              <li><a href="../pages/products.php?cat=6">Audio Books</a></li>
              <li><a href="../pages/products.php?cat=7">Cell Phones</a></li>
              <li><a href="../pages/products.php?cat=8">Electronics</a></li>
              <li><a href="../pages/products.php?cat=9">Video Games</a></li>
           </ul>
          </div><!--/.well -->
        </div><!--/span-->
		<div class="span4">
			<?php
			 if( checkSession() ) 
			 {
					$query = "SELECT * FROM customer WHERE CustomerID=".$_SESSION['customerId']."";
					$result = mysql_query($query);
					$row = mysql_fetch_array($result);
					echo '<form class="well" action="../pages/checkoutConfirmation.php" method="POST">  
					<label><strong><h3><center>Enter your checkout information below to complete your order:</center></h3></strong></label>
					<br>';

						
					echo '<input type="text" class="span5" value="'.$row['CustScreenName'].'" name="username">'; 
					echo '<input type="hidden" class="span5" value="'.$_SESSION['customerId'].'" name="customerid">';
					echo '<input type="hidden" class="span5" value="'.date("y-m-d").'" name="date">';
					echo '<input type="text" class="span5" placeholder="Street Address One..." name="sa1">';  
					echo '<input type="text" class="span5" placeholder="Street Address Two..." name="sa2">';  
					echo '<input type="text" class="span5" placeholder="City..." name="city">';  
					echo '<div class="control-group">  
							<label class="control-label" for="select01">State</label>  
							<div class="controls">  
								<select id="select01" name="state"> 
								<option>AB</option>
								<option>AK</option>
								<option>AL</option>
								<option>AR</option>
								<option>AZ</option>
								<option>BC</option>
								<option>CA</option>
								<option>CO</option>
								<option>CT</option>
								<option>DC</option>
								<option>DE</option>
								<option>FL</option>
								<option>GA</option>
								<option>HI</option>
								<option>IA</option>
								<option>ID</option>
								<option>IL</option>
								<option>IN</option>
								<option>KS</option>
								<option>KY</option>
								<option>LA</option>
								<option>MA</option>
								<option>MB</option>
								<option>MD</option>
								<option>ME</option>
								<option>MI</option>
								<option>MN</option>
								<option>MO</option>
								<option>MS</option>
								<option>MT</option>
								<option>NB</option>
								<option>NC</option>
								<option>ND</option>
								<option>NE</option>
								<option>NH</option>
								<option>NJ</option>
								<option>NL</option>
								<option>NM</option>
								<option>NS</option>
								<option>NT</option>
								<option>NU</option>
								<option>NV</option>
								<option>NY</option>
								<option>OH</option>
								<option>OK</option>
								<option>ON</option>
								<option>OR</option>
								<option>PA</option>
								<option>PE</option>
								<option>PR</option>
								<option>QC</option>
								<option>RI</option>
								<option>SC</option>
								<option>SD</option>
								<option>SK</option>
								<option>TN</option>
								<option>TX</option>
								<option>UT</option>
								<option>VA</option>
								<option>VI</option>
								<option>VT</option>
								<option>WA</option>
								<option>WI</option>
								<option>WV</option>
								<option>WY</option>
								<option>YT</option>
								</select>  
							</div>  
						</div> ';
					echo '<div class="control-group">  
							<label class="control-label" for="select02">Select list</label>  
							<div class="controls">  
							  <select id="select02" name="country">  
								<option>United States</option>  
								<option>Canada</option>    
							  </select>  
							</div>  
						  </div>';
						  echo '<input type="text" class="span5" placeholder="Zipcode..." name="zipcode">';
						  
				  echo '<div class="control-group">  
					<label class="control-label" for="select03">Select list</label>  
					<div class="controls">  
					  <select id="select03" name="Payment Type">  
						<option>American Express</option>  
						<option>Carte Blanche</option>   
						<option>Check</option> 
						<option>Diners Club</option> 
						<option>Discover</option>
						<option>eCheck</option>
						<option>Master Card</option>
						<option>Money Order</option>
						<option>PayPal</option>
						<option>Visa</option>
					  </select>  
					</div>  
				  </div>';
				  echo '<input type="text" class="span5" placeholder="Payment Auth Number..." name="payment">';
					
					echo '</label>  
					<center><button type="submit" class="btn">Checkout</button></center>
					</form>'; 
					 
				} ?>
		</div><!--/span-->
      </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; The Nile 2012</p>
      </footer>

    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap-transition.js"></script>
    <script src="../assets/js/bootstrap-alert.js"></script>
    <script src="../assets/js/bootstrap-modal.js"></script>
    <script src="../assets/js/bootstrap-dropdown.js"></script>
    <script src="../assets/js/bootstrap-scrollspy.js"></script>
    <script src="../assets/js/bootstrap-tab.js"></script>
    <script src="../assets/js/bootstrap-tooltip.js"></script>
    <script src="../assets/js/bootstrap-popover.js"></script>
    <script src="../assets/js/bootstrap-button.js"></script>
    <script src="../assets/js/bootstrap-collapse.js"></script>
    <script src="../assets/js/bootstrap-carousel.js"></script>
    <script src="../assets/js/bootstrap-typeahead.js"></script>

  </body>
</html>
