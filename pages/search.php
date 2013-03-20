<?php
	session_start();
	include_once('../processors/sessions.php');
   /*
	*	Products.php
	* 	This php script represents a view that gets and displays
	* 	products. It will display products in a table format with their
	* 	Title, Price, Short Summary, and Average Rating.
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

	// set how many products have been pulled from the database.
	$numProducts = 0;

		if( isset($_GET['page']) )
		{
			$productPage = $_GET['page'];
		}
		else
		{
			$productPage = 1;
		}
	    //build query to select information about 20 products
	    if( isset($_GET['searchterm']) )
	    {
			$query = "SELECT * FROM product WHERE title like '%".$_GET['searchterm']."%' LIMIT ".(($productPage-1)*20).", ".(($productPage-1)*20+20)."";
		}
		else
		{
			$query = "SELECT * FROM product LIMIT ".(($productPage-1)*20).", ".(($productPage-1)*20+20)."";
		}
		// query database
		$prodResults = mysql_query($query);
		
		// for each item store the information about them.
		while($prodRow = mysql_fetch_array($prodResults))
		{
			$productUPCs[$numProducts] 		= $prodRow['Upc'];
			$productTitles[$numProducts]    = $prodRow['Title'];
			$productSummaries[$numProducts] = $prodRow['ShortSummary'];
			$productMSRPs[$numProducts]		= $prodRow['MsrpPrice'];
			$productSuperShip[$numProducts] = $prodRow['SaverShipEleg'];
			$productAvgRating[$numProducts] = $prodRow['AverageRating'];
			$prodNumRatings[$numProducts]   = $prodRow['FiveStarRating'] + $prodRow['FourStarRating'] + $prodRow['ThreeStarRating'] + $prodRow['TwoStarRating'] + $prodRow['OneStarRating'];
			$numProducts++;
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
          <a class="brand" href="/pages/fluid.php"><img src="../assets/img/Nile_Logo.png"></img></a>
          <div class="nav-collapse">
            <ul class="nav">
              <li><a href="../pages/fluid.php">Home</a></li>
              <li class="active"><a href="../pages/products.php">Products</a></li>
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
        <div class="span9">
			
			<?php
				// for each row of items
				for($i = 0; $i < $numProducts / 4; $i++)
				{
					echo '<div class="row-fluid">';
					// for the items in this row
					for($j = $i*4; ($j < ($i*4) + 4) && ($j < $numProducts); $j++)
					{
						
						// the specific product information will be
						// contained in the arrays at position $j
						echo '<div class="span3">';
						// display the product title
						echo '<h3>'.$productTitles[$j].'</h3>';
						// display the price and average rating
						echo '<p> <strong>Price:</strong> $'.$productMSRPs[$j].' <strong>Avg. Rating:</strong> '.$productAvgRating[$j].'</p>';
						// display if eligible for saver ship
						if($productSuperShip[$j] == 1){ $productSuperShip[$j]= "yes";}else{ $productSuperShip[$j]= "no";}
						echo '<p> <strong> Saver Shipping Eligible? </strong> <em>'.$productSuperShip[$j].'</em></p>';
						// display the product summary
						echo '<p><strong>Description:</strong> <em>'.$productSummaries[$j].'</em></p>';
						// display the details and add to cart buttons;
						if( !isset( $productCats[$j] ) )
						{
							$catString = "";
						}
						else
						{
							$catString = '&cat='.$productCats[$j];
						}
						echo '<p><a class="btn" href="../pages/product.php?upc='.$productUPCs[$j].$catString.'">Details &raquo;</a>
							     <a class="btn" href="../processors/addToCart.php?upc='.$productUPCs[$j].'">Add to Cart &raquo;</a></p>';
						echo '</div><!--/span-->';
					}
					echo '</div><!--/row-->';
				}
			?>

		  <!-- THIS IS WHERE PAGINATION BEGINS -->
		  
		  <div class="row-fluid">
			  <div class="pagination">
				  <p>
					  <?php 
							// if products were selected to be viewed, display a pagination bar.
							if( $productPage != -1 && $numProducts > 0)
							{
								// display pagination bar for specific category
								if( isset( $_GET['cat'] ) )
								{
									echo '
										 <li class="active"><a href="../pages/products.php?cat='.$_GET['cat'].'&page='.($productPage).'">'.($productPage).'</a></li>
										 <li><a href="../pages/products.php?cat='.$_GET['cat'].'&page='.($productPage+1).'">'.($productPage+1).'</a></li>
										 <li><a href="../pages/products.php?cat='.$_GET['cat'].'&page='.($productPage+2).'">'.($productPage+2).'</a></li>
										 <li><a href="../pages/products.php?cat='.$_GET['cat'].'&page='.($productPage+3).'">'.($productPage+3).'</a></li>
										 <li><a href="../pages/products.php?cat='.$_GET['cat'].'&page='.($productPage+4).'">'.($productPage+4).'</a></li>
										 <li><a href="../pages/products.php?cat='.$_GET['cat'].'&page='.($productPage+5).'">'.($productPage+5).'</a></li>
										 <li><a href="../pages/products.php?cat='.$_GET['cat'].'&page='.($productPage+6).'">'.($productPage+6).'</a></li>
										 <li><a href="../pages/products.php?cat='.$_GET['cat'].'&page='.($productPage+7).'">'.($productPage+7).'</a></li>
										 <li><a href="../pages/products.php?cat='.$_GET['cat'].'&page='.($productPage+8).'">'.($productPage+8).'</a></li>
										 <li><a href="../pages/products.php?cat='.$_GET['cat'].'&page='.($productPage+9).'">'.($productPage+9).'</a></li>';
								}
								else
								{
									// display pagination bar for general products
									echo '
										 <li class="active"><a href="../pages/products.php?page='.($productPage).'">'.($productPage).'</a></li>
										 <li><a href="../pages/products.php?page='.($productPage+1).'">'.($productPage+1).'</a></li>
										 <li><a href="../pages/products.php?page='.($productPage+2).'">'.($productPage+2).'</a></li>
										 <li><a href="../pages/products.php?page='.($productPage+3).'">'.($productPage+3).'</a></li>
										 <li><a href="../pages/products.php?page='.($productPage+4).'">'.($productPage+4).'</a></li>
										 <li><a href="../pages/products.php?page='.($productPage+5).'">'.($productPage+5).'</a></li>
										 <li><a href="../pages/products.php?page='.($productPage+6).'">'.($productPage+6).'</a></li>
										 <li><a href="../pages/products.php?page='.($productPage+7).'">'.($productPage+7).'</a></li>
										 <li><a href="../pages/products.php?page='.($productPage+8).'">'.($productPage+8).'</a></li>
										 <li><a href="../pages/products.php?page='.($productPage+9).'">'.($productPage+9).'</a></li>';
								}
								?>
								</div> <!--/span-->
								<?php
							}
							else
							{
								// otherwise there was some kind of strange error, dont display pagination bar.
								// tell the user that there were no products
								echo '  </div> <!--/span-->    
										
										<div class="hero-unit">
											<h1>Looking for products?</h1>
											<p>The Nile is an exciting place on the internet where you can find all your products, and discover new ones.</p>
											<p><a class="btn btn-primary btn-large" href="../pages/products.php">View All of our products! &raquo;</a></p>
										</div>
									  ';
							}
					  ?>
				  </p>

		  
		  <!-- THIS IS WHERE PAGINATION ENDS-->
          
       
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

