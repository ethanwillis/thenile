<?php
session_start();
include_once('../processors/sessions.php');
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
			.
		</div><!--/span-->
		<div class="span4">
			<form class="well" action="../processors/loginProcessor.php" method="POST">  
				<label><strong><h2><center>Login Below</center></h2></strong></label> 
				<br> <?php if( isset($_GET['reg']) && $_GET['reg'] === "success" )
							   { 
									echo '<div class="alert alert-success">  
									<a class="close" data-dismiss="alert">×</a>  
									<strong>Success!</strong> Your account was successfully created! Please login.  
									</div> '; 
							   } 
							else if( isset($_GET['reg']) && $_GET['reg'] === "failed" )
							   { 
									echo '<div class="alert alert-error">  
									<a class="close" data-dismiss="alert">×</a>  
									<strong>Oops!</strong> It looks like you entered the wrong password/username, Please try again. 
									</div> ';
							   } 
						   else if( isset($_GET['reg']) && $_GET['reg'] === "failedadd" )
						   { 
								echo '<div class="alert alert-error">  
								<a class="close" data-dismiss="alert">×</a>  
								<strong>Oops!</strong> Please login to add a product to your cart.
								</div> ';
						   }
						   else if( isset($_GET['reg']) && $_GET['reg'] === "needlogin" )
						   { 
								echo '<div class="alert alert-error">  
								<a class="close" data-dismiss="alert">×</a>  
								<strong>Oops!</strong> Please login to do that
								</div> ';
						   }?> 
					<input type="text" class="span5" placeholder="Email address..." name="email">   
					<input type="text" class="span5" placeholder="Password..." name="password">   
				</label>  
				<center><button type="submit" class="btn">Login!</button></center>
			</form>  
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
