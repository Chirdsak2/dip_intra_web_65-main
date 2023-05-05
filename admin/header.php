<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Knowledge Management System (KM)</title>
<link href="https://fonts.googleapis.com/css?family=Itim|Kanit|Lobster|Mitr|Pridi|Prompt|Roboto|Roboto+Condensed|Slabo+27px|Sriracha|K2D|Sarabun" rel="stylesheet"> 
<?php 
include("link.php"); 
?>   
</head>
<body class="ewt-bg-body">
<?php include('../ewt_module_hidden.php');?>
<!-- Start menu section -->
<section id="menu-area">
<nav class="navbar navbar-default main-navbar" role="navigation" >  
<!--Menu-->	
<div class="navbar-header btn-header" id="btn-header">
<ul>
	<li id="btn-menu" ><a href="#"><i class="fas fa-bars fa-2x i-menu" aria-hidden="true" id="i-menu" ></i></a></li>
		<!--<li><a href="#" class="icon icon-menu" id="btn-menu">Menu</a></li>-->
</ul>                                                             
</div>

<div id="navbar-logo">
	<a class="navbar-brand logo animated fadeInLeft" href="<?php echo $MAIN_PATH; ?>main.php">
		<img src="<?php echo $IMG_PATH;?>../images/logo.png"  alt="logo" /> 
	</a> 
</div> 	
<?php
include($MAIN_PATH.'menu-top.php');
?>
<div id="navbar" class="navbar-collapse collapse">
<div class="collapse navbar-collapse navbar-right">
<div class="home-cms ">
	<!--<p class="aBiz "><span class="icon-notification text-larger text-white "></span><span class="text-white"> Site  :  <?php echo $_SESSION["EWT_SUSER"]; ?></span></p>
	<p class="aBiz ">
	<i class="fas fa-user-cog text-larger text-white "></i>		
	<span class="text-dark"> User : <?php echo $_SESSION["EWT_SMUSER"]; ?></span>
	</p>-->
	<p class="aBiz"><a href="<?php echo $EWT_PATH; ?>DashboardMgt/notification.php"><span class="ringBell"><span class="-count">0</span></span></a></p>  
	<p class="aBiz dropdown-toggle" id="menu1" type="button" data-toggle="dropdown" >
	<a href=""><i class="fas fa-user-cog text-larger text-white "></i><span class="caret text-white"></span></a>		
	<!--<span class="text-white"> User : <?php echo $_SESSION["EWT_SMUSER"]; ?></span>-->
	</p>
	<ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
	<li role="presentation"><a role="menuitem" tabindex="-1" href=""><i class="fas fa-user-cog"></i> : <?php echo $_SESSION["EWT_SMUSER"]; ?></a></li>
	<?php if($_SESSION['EWT_SMTYPE'] == 'N'){?>
	<?php /*<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $EWT_PATH; ?>ewt_logout.php"><i class="fas fa-sign-out-alt"></i> Profile</a></li> */?>
	<?php } ?>
	<?php if($_SESSION['EWT_SMTYPE'] == 'Y'){?>
	<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $EWT_PATH; ?>SystemLogMgt/"><i class="far fa-caret-square-right"></i> System Log</a></li> 
	<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $EWT_PATH; ?>VisitorStatMgt/"><i class="far fa-caret-square-right"></i> Visitor Stat</a></li>    
	<?php } ?> 	
	<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $EWT_PATH; ?>ewt_logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>    
</ul>
</div>
</div>
</div>
</nav> 
</section>
<!--End Menu-->