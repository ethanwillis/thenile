<?php
		session_start();
		include_once('../processors/sessions.php');
		/*
		* Shoppingcart.php
		*/
		 // Setup variables for opening a mysql connection
	// Information for connecting to THE NILE database.
	$username="root";
	$password="";
	$database="mydb";
	$hostname="localhost";
	$totalPrice = 0;
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
              <li class="active"><a href="../pages/fluid.php">Home</a></li>
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
					echo '<li class="nav-header">My Account</li>
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
        <div class="span9">
          <div class="row-fluid">
			  <?php
					if( checkSession() )
					{
						// if the customer is logged in, display their shopping cart
						$query = "SELECT * FROM cart WHERE CustomerID=".$_SESSION['customerId'];
						$result = mysql_query($query);
						
						// if there was 1 or more products in their cart display them
						// otherwise display a message saying they have no carts and that they should add some
						
						if( mysql_num_rows($result) > 0 )
						{
							$itemCount = 1;
							$totalPrice = 0;
							echo '<table class="table table-striped">   
									<thead>  
										<tr>  
											<th> # </th>
											<th>Product name</th>  
											<th>Price</th>  
											<th>Quantity</th>
											<th>Delete</th>  
										</tr>  
									</thead>  
									<tbody>';
							while($row = mysql_fetch_array($result) )
							{
								$query2 = "SELECT Title, MsrpPrice FROM product WHERE Upc=".$row['Upc'];
								$result2 = mysql_query($query2);
								$row2 = mysql_fetch_array($result2);
									echo '<tr>  
											<td>'.$itemCount.'</td> 
											<td><a href="../pages/product.php?upc='.$row['Upc'].'">'.$row2['Title'].'</a></td>  
											<td>$'.$row2['MsrpPrice'].'</td>  
											<td>'.$row['Quantity'].'</td>
											<td><a href="../processors/addToCart.php?upc='.$row['Upc'].'&rem=true"><img src="/assets/img/delete.png"></a></td>   
										</tr>  ';
								$itemCount++;
								$totalPrice += $row2['MsrpPrice'] * $row['Quantity'] ;
							}
							// fetch the product information for each 
							// shopping cart item.
							echo '</tbody>
									</table>';
										
									
						}
						else
						{
							echo '  <div class="alert">  
									  <a class="close" data-dismiss="alert">×</a>  
									  <strong>You don\'t have any products!</strong> why not try adding <a href="/pages/products.php">some</a>? 
									</div>  ';
						}
						
					}
					else
					{
						// otherwise redirect them to login page
						echo ' <script type="text/javascript">
						<!--
						window.location = "../pages/login.php?reg=needlogin"
						//-->
						</script>';
					}
					
			  ?>
			  
			
          </div><!--/row-->
          <div class="row-fluid">
			  <p><strong> Total Cost: </strong> <?php echo $totalPrice; ?> </p>	
			<a class="btn btn-primary btn-large" href="../pages/checkout.php">Checkout &raquo;</a>
			</div>
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
