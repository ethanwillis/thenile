<?php
	session_start();
	include_once('../processors/sessions.php');
	/**
	* Product.php
	* 
	* This script builds a view that lists detailed information for a single product.
	* The information listed depends on the category of item displayed.
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
	
	if( isset($_SESSION['customerId']) && isset($_SESSION['sessionId']) )
	{
		$loggedIn = validateSession();
	}
	else
	{
		$loggedIn = false;
	}
	
	if( isset($_GET['upc'] ) )
	{
		$pInfo['Upc'] = $_GET['upc'];
		
		// build query to pull general information about the product
		$query = 'SELECT * FROM product WHERE upc="'.$pInfo['Upc'].'"';
		$pResults = mysql_query($query);
		// pull general product information
		$pInfo = mysql_fetch_array($pResults);

		// check if we have category information for this product.
		if( isset($_GET['cat'] ) )
		{
			$productCat = $_GET['upc'];
		}
	}
	else // if there was no upc set we can't pull any product information
	{
		// set product upc to a negative value to indicate no information 
		// was pulled.
		$productUPC = -1;
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
              <li class="active"><a href="../pages/products.php">Products</a></li>
		   <?php if($loggedIn==true){echo '<li><a href="../processors/logoutProcessor.php">Logout</a>';}else{echo'</li><li><a href="/pages/login.php">Login</a></li>
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
        <div class="span9">
          <div class="fluid-row">
			  <?php if( isset($_GET['val']) && $_GET['val'] === "failedadd" )
						   { 
								echo '<div class="alert alert-error">  
								<a class="close" data-dismiss="alert">×</a>  
								<strong>Oops!</strong> There was an error adding this item to your cart try again.
								</div> ';
						   }
						   else if(isset($_GET['val']) && $_GET['val'] === "successfuladd")
						   {
							   echo '<div class="alert alert-success">  
								<a class="close" data-dismiss="alert">×</a>  
								<strong>Grats!</strong> The item was successfully added to your <a href="/pages/shoppingcart.php">cart</a>!
								</div> ';
						   }?>
			<p><h1><?php echo $pInfo['Title']; ?></h1></p>
			<strong> Price: </strong> <em> <?php echo $pInfo['MsrpPrice']; ?> </em><br>
			<strong> Saver Shipping Eligble?: </strong> <em> <?php if($pInfo['SaverShipEleg'] == 1){ echo "yes";}else{echo "no";} ?> </em><br>
			<strong> Average Rating: </strong> <em> <?php echo $pInfo['AverageRating']; ?></em>
			<strong> Five Stars: </strong> <em> <?php echo $pInfo['FiveStarRating'].'  '; ?></em>
			<strong> Four Stars: </strong> <em> <?php echo $pInfo['FourStarRating'].' '; ?></em>
			<strong> Three Stars: </strong> <em> <?php echo $pInfo['ThreeStarRating'].' '; ?></em>
			<strong> Two Stars: </strong> <em> <?php echo $pInfo['TwoStarRating'].' '; ?></em>
			<strong> One Star: </strong> <em> <?php echo $pInfo['OneStarRating']; ?></em><br><Br>
			
			<strong> Description: </strong> <em> <?php echo $pInfo['Summary']; ?> </em>;
			
			<form class="well" action="/processors/addToCart.php" method="GET">  
				<input type="hidden" value="<?php echo $pInfo['Upc'];?>" name="upc">
				<button type="submit" class="btn">Add to cart &raquo;</button>
			</form>  
		  </div><!--/row-->
          
          
          
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

