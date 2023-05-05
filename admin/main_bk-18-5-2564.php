<?php
session_start();

## >> Check login

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
include("../lib/config_path.php");
$EWT_PATH = '../';	
$IMG_PATH = '';
$MAIN_PATH = '';



?>
<?php 
include("../header.php");
include('link.php');
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
	<div id="navbar-logo"><a class="navbar-brand logo animated fadeInLeft" href="<?=$MAIN_PATH; ?>main.php"><img src="<?=$IMG_PATH;?>images/EWT_logo.png"  alt="logo" /></a> </div> 	
	<div id="sideNav" class="sideNav">
	<ul>
		<li><a href="<?=$EWT_PATH; ?>EWT_ADMIN/main.php" ><img src="images/visitor1.png" class="img-responsive sideNavImg" /><span class="text-center"> Dashboard</span></a></li>
		<li><a href="<?=link_view(); ?>" target="_blank"><img src="images/preview3.png" class="img-responsive sideNavImg" /><span class="text-center"> Site Preview</span></a></li>
		<?php if($_SESSION['EWT_SMTYPE'] == 'Y'){?><li><a href="<?=$EWT_PATH; ?>SitePropertiesMgt/" ><img src="images/SiteProperties.png" class="img-responsive sideNavImg" /> Site Properties</a></li><?php } ?>
		<?php if($_SESSION['EWT_SMTYPE'] == 'Y'){?><li><a href="<?=$EWT_PATH; ?>PermissionMgt/" ><img src="images/OrgManager.png" class="img-responsive sideNavImg" /> Permission</a></li><?php } ?>
		<?php if($db->check_permission("art","w","")){ ?><li><a href="<?=$EWT_PATH; ?>ArticleMgt/"><img src="images/Article.png" class="img-responsive sideNavImg" /> Article</a></li><?php } ?>
		<?php if($db->check_permission("Banner","w","")){ ?><li><a href="<?=$EWT_PATH; ?>BannerMgt/"><img src="images/banner.png" class="img-responsive sideNavImg" /> Banner</a></li><?php } ?>
		<?php if($db->check_permission("calendar","w","")){ ?><li><a href="<?=$EWT_PATH; ?>CalendarMgt/"><img src="images/calendar1.png" class="img-responsive sideNavImg" /> CalendarMgt</a></li><?php } ?>
		<?php if($db->check_permission("complain","w","")){ ?><li><a href="<?=$EWT_PATH; ?>ComplainMgt/"><img src="images/webboard.png" class="img-responsive sideNavImg" /> Complain</a></li><?php } ?>
		<?php if($db->check_permission("newsl","w","")){ ?><li><a href="<?=$EWT_PATH; ?>EnewsLetterMgt/"><img src="images/E-Newsletter.png" class="img-responsive sideNavImg" /> E-Newsletter</a></li><?php } ?>
		<?php if($db->check_permission("Ebook","w","")){ ?><li><a href="<?=$EWT_PATH; ?>EbookMgt/"><img src="images/e-book.png" class="img-responsive sideNavImg" /> E-Book</a></li><?php } ?>
		<?php if($db->check_permission("faq","w","")){ ?><li><a href="<?=$EWT_PATH; ?>FaqMgt/"><img src="images/FAQ.png" class="img-responsive sideNavImg" /><span class="text-center"> FAQ</span></a></li>	<?php } ?>			
		<?php if($db->check_permission("survey","w","")){ ?><li><a href="<?=$EWT_PATH; ?>SurveyMgt/"><img src="images/Form Generator.png" class="img-responsive sideNavImg" /> Form Generator</a></li><?php } ?>
		<?php if($db->check_permission("Gallery","w","")){ ?><li><a href="<?=$EWT_PATH; ?>GalleryNewMgt/"><img src="images/Gallery.png" class="img-responsive sideNavImg" /> Gallery</a></li><?php } ?>
		<?php /*if($db->check_permission("graph","w","")){ ?><li><a href="<?=$EWT_PATH; ?>GrapMgt/"><img src="images/Graph.png" class="img-responsive sideNavImg" /> Graph</a></li><?php } */ ?>
		<?php if($db->check_permission("menu","w","")){ ?><li><a href="<?=$EWT_PATH; ?>MenuMgt/menu_index.php"><img src="images/Menu.png" class="img-responsive sideNavImg" /> Menu</a></li><?php } ?>
		<?php if($db->check_permission("org","w","")){ ?><li><a href="<?=$EWT_PATH; ?>MemberOrgMgt/"><img src="images/Artboard 20.png" class="img-responsive sideNavImg" /> Organization</a></li><?php } ?>
		<?php if($db->check_permission("poll","w","")){ ?><li><a href="<?=$EWT_PATH; ?>PollMgt/"><img src="images/Polls.png" class="img-responsive sideNavImg" /> Polls</a></li><?php } ?>
		<?php if($db->check_permission("vdo","w","")){ ?><li><a href="<?=$EWT_PATH; ?>vdoMgt/"><img src="images/Artboard 22.png" class="img-responsive sideNavImg" /> Video</a></li><?php } ?>
		<?php if($db->check_permission("webboard","w","")){ ?><li><a href="<?=$EWT_PATH; ?>WebboardNewMgt/"><img src="images/webboard.png" class="img-responsive sideNavImg" /> Webboard</a></li><?php } ?>
	</ul>
	</div>
	<div id="navbar" class="navbar-collapse collapse">
	<div class="collapse navbar-collapse navbar-right">
	<div class="home-cms ">
	<p class="aBiz "><span class="icon-notification text-larger text-white "></span><span class="text-dark"> Site  :  <?=$_SESSION["EWT_SUSER"]; ?></span></p>
	<!--<p class="aBiz ">
	<i class="fas fa-user-cog text-larger text-white "></i>		
	<span class="text-dark"> User : <?=$_SESSION["EWT_SMUSER"]; ?></span>
	</p>-->
	
	
	
	<p class="aBiz dropdown-toggle" id="menu1" type="button" data-toggle="dropdown" >
	<a href=""><i class="fas fa-user-cog text-larger text-white "></i><span class="caret text-white"></span></a>		
	<span class="text-dark"> User : <?=$_SESSION["EWT_SMUSER"]; ?></span>
	</p>
    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
    <?php if($_SESSION['EWT_SMTYPE'] == 'N'){?>
	<?/*<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $EWT_PATH; ?>ewt_logout.php"><i class="fas fa-sign-out-alt"></i> Profile</a></li> */?>
<?php } ?>
<?php if($_SESSION['EWT_SMTYPE'] == 'Y'){?>
	<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $EWT_PATH; ?>SystemLogMgt/"><i class="far fa-caret-square-right"></i> System Log</a></li> 
<?php } ?>

	<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $EWT_PATH; ?>VisitorStatMgt/"><i class="far fa-caret-square-right"></i> Visitor Stat</a></li>    
	<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $EWT_PATH; ?>ewt_logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>    
    </ul>
	
	
	</div>

	

	
	
	</div>
	
	</div>
	
</nav> 
</section><!--End Menu-->
<?php 
//include('menu.php');
//include('navbar.php');
?>

<!-- START CONTAINER  -->
<div class="container-fluid" >

<div class="row m-b" style="padding-top:65px;">
<div class="col-md-12 col-sm-12 col-xs-12"  >
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<div class="card" >
<div class="card-body" >

<img src="<?=$IMG_PATH ;?>images/visitor1.png" class="animated fadeInDown " style="height: 60px;width: 60px;">  
<span class="animated fadeInDown text-large "><?="Dashboard";?></span>
</div>
</div>
</div>
</div>
</div>
</div>


<div class="row ">
<div class="col-md-12 col-sm-12 col-xs-12 " >
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="card ">
<div class="card-header ewt-bg-color m-b-sm" >
<div class="card-title text-left">
<div class="title" ><i class="fas fa-hashtag"></i> <?="ผู้เข้าใช้งานระบบล่าสุด";?></div>

</div>
</div>
<div class="card-body" id="tab3">

<div class="panel-group" id="accordion">
<?php
$s_sql = $db->query("SELECT log_user,log_detail,log_date,log_time,log_ip,log_module_detail FROM log_user WHERE log_module = 'login' ORDER BY  log_date DESC,log_time DESC LIMIT 0,5 ");			  
$a_rows = $db->db_num_rows($s_sql);
if($a_rows > 0){
$i = 0;
while($a_data = $db->db_fetch_row($s_sql)){
?>
<div class="panel panel-default ">
            <div class="panel-heading ewt-bg-success">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?=$i;?>">
					<i class="fas fa-chalkboard-teacher color-ewt"></i>
					<?=$a_data[0];?> 
				
					</a>					
                </h4>
            </div>
		
            <div id="collapseOne<?=$i;?>" class="panel-collapse collapse">
                <div class="panel-body">
                   	<div><b><?="วันที่เข้าใช้งาน";?> :</b> <?=$a_data[2];?> <?=$a_data[3];?></div><br> 
					<div><b><?="IP";?> :</b> <?=$a_data[4];?></div><br> 
                </div>
				<div class="panel-footer ewt-bg-white text-right">

				<div class="ewt-icon-wrap ewt-icon-effect-1 ewt-icon-effect-1b">
				</div>
				</div>
            </div>
        </div>
<?php $i++;} }else{?>

       <div class="panel panel-default ">
            <div class="panel-heading text-center">
                <h4 class="panel-title">
                   <p class="text-danger"><?=$txt_ewt_data_not_found;?></p>
                </h4>
            </div>
        </div>
<?php } ?>	
</div>

<div class="hi-icon-wrap hi-icon-effect-7 hi-icon-effect-7b  text-right">
<a href="#View more"  class="hi-icon hi-icon-list text-dark" title="View more" onclick="window.location.href='../DashboardMgt/systemlog_list_view.php'">View more</a>
</div>
</div>				
</div>
</div>


</div>
</div>
</div>


<div class="row">
<!--<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<div class="card">
<!--start card-header ->
<div class="card-header">
<h2><?="Dashboard";?></h2>
<p></p>             
<ol class="breadcrumb">
<li><a href="banner_group.php"><?="Dashboard";?></a></li>
<li class=""></li>       
</ol>

<div class="row m-b-sm">
<div class="col-md-12 col-sm-12 col-xs-12 " ></div>	
</div>
</div>
<!--END card-header ->

<!--start card-body ->
<div class="card-body">

</div>
<!--END card-body ->

</div>
</div>-->

<div class="col-md-12 col-sm-12 col-xs-12 " >
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12 m-b-sm" >
<div class="card ">
<div class="card-header ewt-bg-color m-b-sm" >
<div class="card-title text-left">
<div class="title" ><i class="fas fa-hashtag"></i> <?="ข่าวสาร/บทความใหม่รายวัน";?></div>

</div>
</div>
<div class="card-body" id="tab1">

<ul class="list-group">
<?php
$date = new DateTime();
$Y = $date->format('Y')+543; 
$MD = $date->format('-m-d');

$s_art_new = $db->query("SELECT n_id,n_topic,n_owner 
FROM article_list WHERE n_id != '' AND  n_approve = 'Y' AND n_date = '".$Y.$MD."'
ORDER BY n_id DESC LIMIT 0,5");

while($a_art_new = $db->db_fetch_row($s_art_new)){
?>
<li class="list-group-item "><i class="far fa-newspaper"></i> <?=$a_art_new[1];?></li>

<?php } ?>
</ul>

<div class="hi-icon-wrap hi-icon-effect-7 hi-icon-effect-7b  text-right">
<a href="#View more"  class="hi-icon hi-icon-list text-dark" title="View more" onclick="window.location.href='../DashboardMgt/article_list_view.php?tap=1'">View more</a>
</div>
</div>				
</div>
</div>



<div class="col-md-6 col-sm-6 col-xs-12 m-b-sm" >
<div class="card ">
<div class="card-header ewt-bg-color m-b-sm" >
<div class="card-title text-left">
<div class="title" ><i class="fas fa-hashtag"></i> <?="ข่าวสาร/บทความที่รอการอนุมัติ";?></div>


</div>
</div>
<div class="card-body" id="tab2">

<ul class="list-group">
<?php
$s_art_approve = $db->query("SELECT n_id,n_topic,n_owner 
FROM article_list WHERE n_id != '' AND n_approve = ''
ORDER BY n_id DESC LIMIT 0,5");

while($a_approve = $db->db_fetch_row($s_art_approve)){
?>
<li class="list-group-item "><i class="far fa-newspaper"></i> <?=$a_approve[1];?></li>

<?php } ?>
</ul>

<div class="hi-icon-wrap hi-icon-effect-7 hi-icon-effect-7b  text-right">
<a href="#View more"  class="hi-icon hi-icon-list text-dark" title="View more" onclick="window.location.href='../DashboardMgt/article_list_view.php?tap=2'">View more</a>
</div>
</div>				
</div>
</div>

</div>
</div>
</div>



<div id="box_popup" class="layer-modal"></div>
</div>
<!-- END CONTAINER  -->

<div  style="padding-bottom:30px;"></div>

<?php include("panel-footer.php");?>
<style>
<!--
.panel-default > .panel-heading {
    /*color: #FFFFFF;*/
    /*background-color: #FFC153 ;*/
	background-color: #FFFFFF ;
    border-color: #ddd;
}
    .faqHeader {
        font-size: 27px;
        margin: 20px;
    }
    .panel-heading [data-toggle="collapse"]:after {
		font-family: 'Font Awesome 5 Free';
		font-weight: 900;
        content: "\f105"; /* "play" icon */
        float: right;
        color: #FFC153;
        font-size: 24px;
        line-height: 22px;
        /* rotate "play" icon from > (right arrow) to down arrow */
        -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
        -ms-transform: rotate(-90deg);
        -o-transform: rotate(-90deg);
        transform: rotate(-90deg);
	
    }
    .panel-heading [data-toggle="collapse"].collapsed:after {
        /* rotate "play" icon from > (right arrow) to ^ (up arrow) */
        -webkit-transform: rotate(90deg);
        -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        transform: rotate(90deg);
        color: #454444;
    }
	
.ewt-icon-wrap {
	margin: 0 auto;
}
.ewt-icon {
	display: inline-block;
	font-size: 0px;
	cursor: pointer;
	_margin: 15px 15px;
	width: 30px;
	height: 30px;
	border-radius: 50%;
	text-align: center;
	position: relative;
	z-index: 1;
	color: #fff;
}

.ewt-icon:after {
	pointer-events: none;
	position: absolute;
	width: 100%;
	height: 100%;
	border-radius: 50%;
	content: '';
	-webkit-box-sizing: content-box; 
	-moz-box-sizing: content-box; 
	box-sizing: content-box;
}
.ewt-icon:before {
	font-family: 'Font Awesome 5 Free';
	font-weight: 900;
	speak: none;
	font-size: 18px;
	line-height: 30px;
	font-style: normal;
	_font-weight: normal;
	font-variant: normal;
	text-transform: none;
	display: block;
	-webkit-font-smoothing: antialiased;
}
.ewt-icon-edit:before {
	content: "\f044";
}
.ewt-icon-del:before {
	content: "\f2ed";
}
.ewt-icon-view:before {
	content: "\f06e";
}
.ewt-icon-print:before {
	content: "\f02f";
}
/* Effect 1 */
.ewt-icon-effect-1 .ewt-icon {
	background: rgba(255,255,255,0.1);
	-webkit-transition: background 0.2s, color 0.2s;
	-moz-transition: background 0.2s, color 0.2s;
	transition: background 0.2s, color 0.2s;
}
.ewt-icon-effect-1 .ewt-icon:after {
	top: -7px;
	left: -7px;
	padding: 7px;
	box-shadow: 0 0 0 4px #fff;
	-webkit-transition: -webkit-transform 0.2s, opacity 0.2s;
	-webkit-transform: scale(.8);
	-moz-transition: -moz-transform 0.2s, opacity 0.2s;
	-moz-transform: scale(.8);
	-ms-transform: scale(.8);
	transition: transform 0.2s, opacity 0.2s;
	transform: scale(.8);
	opacity: 0;
}
/* Effect 1a */
.ewt-icon-effect-1a .ewt-icon:hover {
	background: rgba(255,255,255,1);
	color: #41ab6b;
}
.ewt-icon-effect-1a .ewt-icon:hover:after {
	-webkit-transform: scale(1);
	-moz-transform: scale(1);
	-ms-transform: scale(1);
	transform: scale(1);
	opacity: 1;
}
/* Effect 1b */
.ewt-icon-effect-1b .ewt-icon:hover{
	background: rgba(255,255,255,1);
	color: #41ab6b;
}
.ewt-icon-effect-1b .ewt-icon:after {
	-webkit-transform: scale(1.2);
	-moz-transform: scale(1.2);
	-ms-transform: scale(1.2);
	transform: scale(1.2);
}
.ewt-icon-effect-1b .ewt-icon:hover:after {
	-webkit-transform: scale(1);
	-moz-transform: scale(1);
	-ms-transform: scale(1);
	transform: scale(1);
	opacity: 1;
}
.drop-placeholder {
	background-color: #f6f3f3 !important;
	height: 3.5em;
	padding-top: 12px;
	padding-bottom: 12px;
	line-height: 1.2em;
	border: 3px dotted #cccccc !important;
}
-->
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/gnmenu-js/js/gnmenu.js"></script>
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
<script>
$(document).ready(function(){
  $(".dropdown-toggle").dropdown();
});
</script>
<!-- Counter -->
<script type="text/javascript" src="<?=$IMG_PATH;?>assets/js/waypoints.js"></script>
<script type="text/javascript" src="<?=$IMG_PATH;?>assets/js/jquery.counterup.js"></script>

<!-- Slick Slider -->
<script type="text/javascript" src="<?=$IMG_PATH;?>assets/js/slick.js"></script> 
<!-- Custom js -->
<script type="text/javascript" src="<?=$IMG_PATH;?>assets/js/custom.js"></script>
</body>
</html>
