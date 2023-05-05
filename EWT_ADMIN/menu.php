  <!-- Start menu section -->
    <section id="menu-area">
    <nav class="navbar navbar-default main-navbar" role="navigation" >  

        <div class="navbar-header">
          <!-- FOR MOBILE VIEW COLLAPSED BUTTON -->
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <!-- LOGO -->                                               
                     
        </div>
		<div id="navbar-logo"><a class="navbar-brand logo animated fadeInLeft" href="<?=$MAIN_PATH; ?>ewt_main.php"><img src="<?=$IMG_PATH;?>images/EWT_logo.png"  alt="logo" /></a> </div> 
        <div id="navbar" class="navbar-collapse collapse">
		 
          <ul id="top-menu" class="nav navbar-nav main-nav menu-scroll">
           <!-- li class="active"><a href="index.php">หน้าหลัก</a></li> -->
		     <li class="dropdown" rule="menu">		
				<a class="dropdown-toggle" data-toggle="dropdown" href="#" >Site		
					<span style="border-top: 4px solid;" class="caret"></span></a>
					<ul class="dropdown-menu">
					<?php if($_SESSION["EWT_SMTYPE"] == "Y"){ ?>
					<!--<li><a href="#">Site Properties</a> </li>-->
					<li><a href="<?php echo $EWT_PATH; ?>ewt_info_site.php">Site Properties</a> </li>	
					<li><a href="<?php echo $EWT_PATH; ?>SiteMgt/ewt_permission0.php">Permission</a> </li>				
					<li><a href="<?php echo $EWT_PATH; ?>StatMgt/log_index.php">System Logs</a> </li>
					<?php } ?>
					<?php  if($db->check_permission("visitstats","w","")){?><li><a href="<?php echo $EWT_PATH; ?>StatMgt/stat_index.php">Visitor Stats</a> </li><?php } ?>
					<!--<li><a href="#">Keyword Stats</a> </li>-->
					<li><a href="<?php echo $EWT_PATH; ?>ewt_logout.php">Logout</a> </li>
					</ul>
					
	
			</li> 
            <li class="dropdown" rule="menu">		
				<a class="dropdown-toggle" data-toggle="dropdown" href="#" >Tools		
					<span style="border-top: 4px solid;" class="caret"></span></a>
					<ul class="dropdown-menu">
					  <?php if($db->check_permission("art","","")){ ?><li><a href="<?=$EWT_PATH; ?>ArticleMgt/">Article</a> </li>
					  <?php } if($db->check_permission("Banner","w","")){?><li><a href="<?php echo $EWT_PATH; ?>BannerMgt/">Banner</a> </li>
					  <?php } if($db->check_permission("newsl","w","")){?><li><a href="<?php echo $EWT_PATH; ?>NewsLetterMgt/">E-Newsletter</a> </li>
					  <li><a href="<?=$EWT_PATH; ?>EbookMgt/index.php">E-Book</a> </li>
					  <!--<li><a href="<?=$EWT_PATH; ?>GrapMgt/">Graph</a> </li>-->
					  <?php } if($db->check_permission("survey","w","")){ ?><li><a href="<?php echo $EWT_PATH; ?>SurveyMgt_">Form Survey</a> </li>
					
					  <?php } if($db->check_permission("complain","w","")){ ?><li><a href="<?php echo $EWT_PATH; ?>ComplainMgt/">Complain</a> </li>
					  <?php } if($db->check_permission("menu","w","")){ ?><li><a href="<?php echo $EWT_PATH; ?>MenuMgt/menu_index.php">Menu</a> </li>
					 
					  <?php } if($_SESSION['EWT_SMUSER'] == $_SESSION['EWT_SUSER']){  if($db->check_permission("org","w","")){?><li><a href="<?php echo $EWT_PATH; ?>MemberMgt/index_member.php">Organization</a> </li>
					  <?php } } if($db->check_permission("poll","w","")){ ?><li><a href="<?php echo $EWT_PATH; ?>PollMgt">Poll</a> </li>
				
					 
					  <?php } if($_SESSION["EWT_VDOMGT"] == 'Y' OR $_SESSION["EWT_SMTYPE"] == 'Y'){ if($db->check_permission("vdo","w","")){ ?><li><a href="<?php echo $EWT_PATH; ?>vdoMgt/index.php">VDO</a> </li>	<?php } ?>				  				  
					  <li><a href="<?php echo $EWT_PATH; ?>">Gallery Image</a> </li>	<?php ?>	
					  <?php if($_SESSION["EWT_SMID"] != ""){?>
					<li><a href="<?php echo $EWT_PATH; ?>MemberMgt/index_member_out2.php">Edit Password</a> </li>	
					
					<?php
}else{
?>					
					  <li><a href="../ewt_password_edit.php">Edit Password</a> </li>						
						
<?php } } ?>
					</ul>
			</li> 
			<!-- use style="white-space: normal;" if text long -->
			
            <li><a href="#">Help</a></li>
 
          </ul>                            
        </div>
       
    </nav> 
</section>

  <!-- End menu section -->