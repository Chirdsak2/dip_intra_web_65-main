<?php
	session_start();
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
	include("../../lib/ewt_function.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="content-type" content="text/html;" charset="utf-8">
    <!--<meta http-equiv="X-UA-Compatible" content="IE=edge">-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <!--The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

<title><?=gentitle();?></title>
<?=meta_share($nid,$vdo);?>
    <!-- Bootstrap -->
    <link href="css/bootstrap/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
		<link href="templates_02/css/style.css" rel="stylesheet">
		<link href="templates_02/css/animate.min.css" rel="stylesheet">
		<link href="templates_02/css/bootstrap-dropdownhover.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/plugin/owl.carousel.css" rel="stylesheet">
    <link href="css/plugin/owl.theme.default.css" rel="stylesheet">
    <link href="css/plugin/font-awesome.css" rel="stylesheet">
    <link href="css/plugin/jquery.fancybox.min.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

      <!-- animate.css -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.3.0/animate.min.css">

<!-- crosscover.css
      <link rel="stylesheet" href="css/plugin/crosscover.css">-->


  <body>

      <?// include 'link-guide.php'; ?>
