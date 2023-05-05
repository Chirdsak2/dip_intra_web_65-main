<?php
session_start();
	if($_SESSION["EWT_SMUSER"] == "" ){
				?>
				<script language="javascript">
				self.location.href = "../index.php";	
				</script>
				<?php
			exit();
		}
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$EWT_PATH = '../';	
$IMG_PATH = '';
$MAIN_PATH = '';

function link_view(){
	global $db,$EWT_FOLDER_USER;
	$PHPSELF = explode('/',$_SERVER["PHP_SELF"]);
	$paths = $PHPSELF[1]."/ewt/".$EWT_FOLDER_USER."/";


	return "http://".$_SERVER['HTTP_HOST']."/".$paths;	
}	

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>EasyWebTime 8.9</title>
 <!-- Favicon -->
<link rel="shortcut icon" type="image/icon" href="images/logo_biz.png"/>
<link href="https://fonts.googleapis.com/css?family=Itim|Kanit|Lobster|Mitr|Pridi|Prompt|Roboto|Roboto+Condensed|Slabo+27px|Sriracha" rel="stylesheet">
    
<link rel="stylesheet" href="css/backend_style.css">

<link rel="stylesheet" href="css/icons.css">

    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!-- Slick slider -->
    <link rel="stylesheet" type="text/css" href="assets/css/slick.css"/> 
	
    <link href="preloader.css" rel="stylesheet">
	 <!-- Main Style -->
    <link href="style.css" rel="stylesheet">
	
	<!-- Latest compiled and minified CSS -->

	
	<link rel="stylesheet" href="assets/css/animate.min.css"/>
	
	<style type="text/css">
<!--
.style2 {color: #FF0000}
-->
 table {
	 font-size: 14px;
	 font-weight: 400;
 }  
 input {
	 
	 height:30px;
	 
 }

</style>
</head>
<body>
<?php include('../ewt_module_hidden.php');?>
<?php 
include('menu.php');
include('navbar.php');
?>
<!--<div class="clear pad8"></div>-->
<div class="container" align="center" style="padding-bottom:80px;width: 100%;">

<div class="col-md-12 col-sm-12 col-xs-12" align="center" _style="border-color:#000000;background-color:#F9F9F9;border: 4px solid #FFC153;
    padding: 10px;
    border-radius: 15px;top:10px;">
<!-----start Module---->
<div class="panel panel-default" style="background-color:#F9F9F9;border: 2px solid #FFC153;
    padding: 10px;
    border-radius: 4px;">
<div class="panel-body">

<div class="col-md-3 col-sm-3 col-xs-6 animated fadeInDown" >
<a href="<?=link_view(); ?>" target="_blank">
<div class="card-module">
<div class="head-module">

  <img src="images/preview3.png" class="img-responsive img-fluid o-hidden m-t-20" />

</div>
<h5 class="footer-module text-center text-bold">Site Preview</h5>
</div>
</a>
</div>


<div class="col-md-3 col-sm-3 col-xs-6 animated fadeInDown" >
<a href="<?=$EWT_PATH; ?>ewt_info_site.php">
<div class="card-module">
<div class="head-module">

  <img src="images/SiteProperties.png" class="img-responsive img-fluid o-hidden m-t-20" />

</div>
<h5 class="footer-module text-center text-bold">Site Properties</h5>
</div>
</a>
</div>

<div class="col-md-3 col-sm-3 col-xs-6 animated fadeInDown" >
<a href="<?=$EWT_PATH; ?>SiteMgt" >
<div class="card-module">
<div class="head-module">

  <img src="images/OrgManager.png" class="img-responsive img-fluid o-hidden m-t-20" />

</div>
<h5 class="footer-module text-center text-bold">Permission</h5>
</div>
</a>
</div>

<?php if($db->check_permission("art","","")){ ?>
<div class="col-md-3 col-sm-3 col-xs-6 animated fadeInDown">
<a href="<?=$EWT_PATH; ?>ArticleMgt/">
<div class="card-module">
<div class="head-module">
  <img src="images/Article.png" class="img-responsive" />
</div>
<h5 class="footer-module text-center text-bold">Article</h5>
</div>
</a>
</div>
<?php } if($db->check_permission("Banner","w","")){?>
<div class="col-md-3 col-sm-3 col-xs-6 animated fadeInDown">
<a href="<?=$EWT_PATH; ?>BannerMgt/">
<div class="card-module">
<div class="head-module">
  <img src="images/banner.png" class="img-responsive" />
</div>
<h5 class="footer-module text-center text-bold">Banner</h5>
</div>
</a>
</div>
<?php } if($db->check_permission("newsl","w","")){?>
<div class="col-md-3 col-sm-3 col-xs-6 animated fadeInDown">
<a href="<?=$EWT_PATH; ?>CalendarMgt/">
<div class="card-module">
<div class="head-module">
  <img src="images/calendar1.png" class="img-responsive" />
</div>
<h5 class="footer-module text-center text-bold">Calendar</h5>
</div>
</a>
</div>
<?php } if($db->check_permission("complain","w","")){ ?>
<div class="col-md-3 col-sm-3 col-xs-6 animated fadeInDown">
<a href="<?=$EWT_PATH; ?>ComplainMgt/">
<div class="card-module">
<div class="head-module">
  <img src="images/webboard.png" class="img-responsive" />
</div>
<h5 class="footer-module text-center text-bold">Complain</h5>
</div>
</a>
</div>
<?php } if($db->check_permission("newsl","w","")){?>
<div class="col-md-3 col-sm-3 col-xs-6 animated fadeInDown">
<a href="<?=$EWT_PATH; ?>NewsLetterMgt/">
<div class="card-module">
<div class="head-module">
  <img src="images/E-Newsletter.png" class="img-responsive" />
</div>
<h5 class="footer-module text-center text-bold">E-Newsletter</h5>
</div>
</a>
</div>
<?php } if($db->check_permission("newsl","w","")){?>
<div class="col-md-3 col-sm-3 col-xs-6 animated fadeInDown ">
<a href="<?=$EWT_PATH; ?>EbookMgt/index.php">
<div class="card-module">
<div class="head-module">
  <img src="images/e-book.png" class="img-responsive" />
</div>
<h5 class="footer-module text-center text-bold">E-Book</h5>
</div>
</a>
</div>
<?php } ?>
<?php if($db->check_permission("faq","w","")){ ?>
<!--<div class="col-md-3 col-sm-3 col-xs-6">
<a href="<?php //echo $EWT_PATH; ?>WebboardMgt/faq_index.php">
<div class="card-module">
<div class="head-module">
  <img src="images/FAQ.png" class="img-responsive" />
</div>
<h5 class="footer-module text-center text-bold">FAQ</h5>
</div>
</a>
</div>-->
<?php } if($db->check_permission("survey","w","")){ ?>
<div class="col-md-3 col-sm-3 col-xs-6 animated fadeInDown">
<a href="<?=$EWT_PATH; ?>SurveyMgt_/">
<div class="card-module">
<div class="head-module">
  <img src="images/Form Generator.png" class="img-responsive" />
</div>
<h5 class="footer-module text-center text-bold">Form Survey</h5>
</div>
</a>
</div>
<?php } if($db->check_permission("Gallery","w","")){?>
<div class="col-md-3 col-sm-3 col-xs-6 animated fadeInDown">
<a href="<?=$EWT_PATH; ?>GrapMgt/">
<div class="card-module">
<div class="head-module">
  <img src="images/graph.png" class="img-responsive" />
</div>
<h5 class="footer-module text-center text-bold">Graph</h5>
</div>
</a>
</div>
<?php } if($db->check_permission("Gallery","w","")){?>
<!--<div class="col-md-3 col-sm-3 col-xs-6">
<a href="<?php //echo $EWT_PATH; ?>GalleryMgt/gallery_index.php">
<div class="card-module">
<div class="head-module">
  <img src="images/Gallery.png" class="img-responsive" />
</div>
<h5 class="footer-module text-center text-bold">Gallery</h5>
</div>
</a>
</div>-->
<?php }if($db->check_permission("menu","w","")){ ?>
<div class="col-md-3 col-sm-3 col-xs-6 animated fadeInDown">
<a href="<?=$EWT_PATH; ?>MenuMgt/menu_index.php">
<div class="card-module">
<div class="head-module">
  <img src="images/Menu.png" class="img-responsive" />
</div>
<h5 class="footer-module text-center text-bold">Menu</h5>
</div>
</a>
</div>
<?php } if($db->check_permission("language","w","")){ ?>
<!--<div class="col-md-3 col-sm-3 col-xs-6">
<a href="<?php //echo $EWT_PATH; ?>LanguageMgt/language_index.php">
<div class="card-module">
<div class="head-module">
  <img src="images/Multi language.png" class="img-responsive" />
</div>
<h5 class="footer-module text-center text-bold">Multi language</h5>
</div>
</a>
</div>-->
<?php } if($_SESSION['EWT_SMUSER'] == $_SESSION['EWT_SUSER']){ if($db->check_permission("org","w","")){?>
<div class="col-md-3 col-sm-3 col-xs-6 animated fadeInDown">
<a href="<?=$EWT_PATH; ?>MemberMgt">
<div class="card-module">
<div class="head-module">
  <img src="images/Artboard 20.png" class="img-responsive" />
</div>
<h5 class="footer-module text-center text-bold">Organization</h5>
</div>
</a>
</div><?php } }  if($db->check_permission("poll","w","")){ ?>
<div class="col-md-3 col-sm-3 col-xs-6 animated fadeInDown">
<a href="<?php echo $EWT_PATH; ?>PollMgt">
<div class="card-module">
<div class="head-module">
  <img src="images/Polls.png" class="img-responsive" />
</div>
<h5 class="footer-module text-center text-bold">Polls</h5>
</div>
</a>
</div>
<?php } if($db->check_permission("sitemap","w","")){ ?>
<!--<div class="col-md-3 col-sm-3 col-xs-6">
<a href="<?php //echo $EWT_PATH; ?>MenuMgt/sitemap_index.php">
<div class="card-module">
<div class="head-module">
  <img src="images/Artboard 23.png" class="img-responsive" />
</div>
<h5 class="footer-module text-center text-bold">Site map</h5>
</div>
</a>
</div>-->
<?php }if($db->check_permission("Vulgar","w","")){?> 
<!--<div class="col-md-3 col-sm-3 col-xs-6">
<a href="<?php //echo $EWT_PATH; ?>VulgarMgt/vul_index.php">
<div class="card-module">
<div class="head-module">
  <img src="images/Artboard 21.png" class="img-responsive" />
</div>
<h5 class="footer-module text-center text-bold">Rude words filter</h5>
</div>
</a>
</div>-->
<?php } if($vdo_hidden){ ?>
<div class="col-md-3 col-sm-3 col-xs-6 animated fadeInDown">
<a href="<?=$EWT_PATH; ?>vdoMgt/">
<div class="card-module">
<div class="head-module">
  <img src="images/Artboard 22.png" class="img-responsive" />
</div>
<h5 class="footer-module text-center text-bold">Video</h5>
</div>
</a>
</div><?php }  ?>
<!--<div class="col-md-2 col-sm-3 col-xs-6">
<a href="#">
<div class="card-module">
<div class="head-module">
  <img src="images/module-helpdesk.png" class="img-responsive" />
</div>
<h5 class="footer-module text-center text-bold">Blog</h5>
</div>
</a>
</div>-->
<?php if($db->check_permission("webboard","w","")){ ?>
<!--<div class="col-md-3 col-sm-3 col-xs-6">
<a href="<?php //echo $EWT_PATH; ?>WebboardMgt/webboard_index.php">
<div class="card-module">
<div class="head-module">
  <img src="images/webboard.png" class="img-responsive" />
</div>
<h5 class="footer-module text-center text-bold">Webboard</h5>
</div>
</a>
</div>-->
<?php } if($db->check_permission("tradeboard","w","")){  ?>
<!--<div class="col-md-3 col-sm-3 col-xs-6">
<a href="<?php //echo $EWT_PATH; ?>TradeboardMgt/webboard_index.php">
<div class="card-module">
<div class="head-module">
  <img src="images/wall-post .png" class="img-responsive" />
</div>
<h5 class="footer-module text-center text-bold">กระดานซื้อ-ขาย</h5>
</div>
</a>
</div>-->
<?php  }?> 



<!--<div class="col-md-2 col-sm-3 col-xs-6">
<a href="#">
<div class="card-module">
<div class="head-module">
  <img src="images/module-helpdesk.png" class="img-responsive" />
</div>
<h5 class="footer-module text-center text-bold">ระบบจัดเก็บเอกสาร</h5>
</div>
</a>
</div>-->
<!--<div class="col-md-2 col-sm-3 col-xs-6">
<a href="#">
<div class="card-module">
<div class="head-module">
  <img src="images/G calendar.png" class="img-responsive" />
</div>
<h5 class="footer-module text-center text-bold">Calendar</h5>
</div>
</a>
</div>-->


<!--<div class="col-md-2 col-sm-3 col-xs-6">
<a href="#">
<div class="card-module">
<div class="head-module">
  <img src="images/module-helpdesk.png" class="img-responsive" />
</div>
<h5 class="footer-module text-center text-bold">KM</h5>
</div>
</a>
</div>-->



<!--<div class="col-md-2 col-sm-3 col-xs-6">
<a href="#">
<div class="card-module">
<div class="head-module">
  <img src="images/module-helpdesk.png" class="img-responsive" />
</div>
<h5 class="footer-module text-center text-bold">Chat</h5>
</div>
</a>
</div>-->

<div class="col-md-3 col-sm-3 col-xs-6 animated fadeInDown">
<a href="<?=$EWT_PATH; ?>InfographicsMgt/">
<div class="card-module">
<div class="head-module">
  <img src="images/gallery_image.png" class="img-responsive" />
</div>
<h5 class="footer-module text-center text-bold">Infographics</h5>
</div>
</a>
</div>
</div>
</div>
</div>
<!----end Module--->
</div>

<footer class="footer panel-footer fix navbar-fixed-footer" >
<div class="container">
<p>© Copyright © 2017, BizPotential.com - All Rights Reserved.</p>
</div>
</footer>
<a href="#" class="scrollup" style="display: none;"><span class="glyphicon glyphicon-circle-arrow-up scrollup-icon"></span></a>
<script src="js/jquery-3.1.0.js"></script> 
<script src="js/bootstrap.js"></script>
<script type="text/javascript">
			$(document).ready(function(){ 
			
			$(window).scroll(function(){
				if ($(this).scrollTop() > 50) {
					$('.scrollup').fadeIn();
				} else {
					$('.scrollup').fadeOut();
				}
			}); 
			
			$('.scrollup').click(function(){
				$("html, body").animate({ scrollTop: 0 }, 300);
				return false;
			});
 
		});
		</script>
  <!-- Slick Slider -->
  <script type="text/javascript" src="assets/js/slick.js"></script>
  
  <!-- Custom js -->
  <script type="text/javascript" src="assets/js/custom.js"></script>		
</body>
</html>
