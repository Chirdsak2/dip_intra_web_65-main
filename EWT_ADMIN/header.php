<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ระบบบริหารเว็บไซต์ PRD INTRANET </title>
	<?php
	include("link.php");
	?>
</head>

<body class="ewt-bg-body">
	<?php include('../ewt_module_hidden.php'); ?>
	<!-- Start menu section -->
	<section id="menu-area">
		<nav class="navbar navbar-default main-navbar" role="navigation">
			<!--Menu-->
			<div class="navbar-header btn-header" id="btn-header">
				<ul>
					<li id="btn-menu"><a href="#"><i class="fas fa-bars fa-2x i-menu" aria-hidden="true" id="i-menu"></i></a></li>
					<!--<li><a href="#" class="icon icon-menu" id="btn-menu">Menu</a></li>-->
				</ul>
			</div>

			<div id="navbar-logo">
				<!-- <?php echo $MAIN_PATH; ?>main.php -->
				<a class="navbar-brand logo animated fadeInLeft" href="<?php echo $EWT_PATH; ?>EWT_ADMIN/main.php" target="_black"> <!-- http://203.151.166.134/PRD_INTRA_WEB/ewt/prd_intra_web/ -->
					<img src="<?php echo $IMG_PATH; ?>../images/logo.png" alt="logo" />
				</a>
			</div>
			<?php
			include($MAIN_PATH . 'menu-top.php');
			?>
			<div id="navbar" class="navbar-collapse collapse">
				<div class="collapse navbar-collapse navbar-right">
					<div class="home-cms ">
						<p class="aBiz "><span class="icon-notification text-larger text-white "></span><span class="text-white"> Site : <?php echo $_SESSION["EWT_SUSER"]; ?></span></p>
						<!--<p class="aBiz ">
						<i class="fas fa-user-cog text-larger text-white "></i>		
						<span class="text-dark"> User : <?php echo $_SESSION['EWT_SMUSER']; ?></span>
						</p>-->
						<p class="aBiz dropdown-toggle" id="menu1" type="button" data-toggle="dropdown">
							<a href=""><i class="fas fa-user-cog text-larger text-white "></i><span class="caret text-white"></span></a>
							<!--<span class="text-white"> User : <?php //echo $_SESSION['EWT_SMUSER']; 
																	?></span>-->
						</p>
						<ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
							<li role="presentation"><a role="menuitem" tabindex="-1" href=""><i class="fas fa-user-cog"></i> User : <?php echo $_SESSION["EWT_SMUSER"]; ?></a></li>
							<?php if ($_SESSION['EWT_SMTYPE'] == 'N') { ?>
								<?php /*<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $EWT_PATH; ?>ewt_logout.php"><i class="fas fa-sign-out-alt"></i> Profile</a></li> */ ?>
							<?php } ?>
							<?php if ($_SESSION['EWT_SMTYPE'] == 'Y') { ?>
								<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $EWT_PATH; ?>SystemLogMgt/"><i class="far fa-caret-square-right"></i> System Log</a></li>
								<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $EWT_PATH; ?>PasswordLogMgt/"><i class="far fa-caret-square-right"></i> Password Log</a></li>
							<?php } ?>
							<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $EWT_PATH; ?>VisitorStatMgt/"><i class="far fa-caret-square-right"></i> Visitor Stat</a></li>
							<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $EWT_PATH; ?>ewt_logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
						</ul>
					</div>
				</div>
			</div>
		</nav>
	</section>
	<!--End Menu-->
	<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<script>
		$(document).ready(function() {
			$('.select2').select2();
		});
	</script>