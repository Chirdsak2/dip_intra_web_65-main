<?php
$s_code = 'webboard'; 
$s_module = sys::getPage();
?>
<div class="row m-b" style="padding-top:65px;">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm"  >
<div class="card" >
<div class="card-body" >

<div class="row">

<div class="col-md-4 col-sm-4 col-xs-12" >	 
<img src="<?php echo $IMG_PATH ;?><?php echo sys::getModuleImage($s_code);?>" class="animated fadeInDown " style="height: 60px;width: 60px;">  
<span class="animated fadeInDown text-large hidden-xs"><?php echo $txt_webboard_module ;?></span> 
</div>

<div class="col-md-8 col-sm-8 col-xs-12 float-right text-right hidden-xs" style="top:18px;"> 
<a href="../EWT_ADMIN/main.php" >
<button type="button" class="btn btn-default btn-sm" >
<i class="fas fa-home"></i>&nbsp;<?php echo $txt_ewt_home ;?>
</button>
</a>
<a href="webboard_dashboard.php" title="<?php echo $txt_webboard_menu_main;?>"  target="_self"> 
<button type="button" data-toggle="tooltip" data-placement="top" title="<?php echo $txt_webboard_menu_main;?>" class="btn btn-default btn-sm <?php if(preg_match('@^webboard_dashboard@i', $s_module)) echo ' active'; ?>" >
<i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php echo $txt_webboard_menu_main;?>
</button>
</a>
<a href="webboard_main.php" title="<?php echo 'หมวดกระทู้';?>"  target="_self">
<button type="button" data-toggle="tooltip" data-placement="top" title="<?php echo 'หมวดกระทู้'; ?>" class="btn btn-default btn-sm <?php if(preg_match('@^webboard_main@i', $s_module)) echo ' active'; ?>" >
<i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php echo 'หมวดกระทู้';?>
</button>
</a>
<!--<a href="webboard_subadmin.php" title="<?php //echo 'ผู้ดูแลหมวดกระทู้';?>" target="_self">
<button type="button" class="btn btn-default btn-sm <?php //if(preg_match('@^webboard_subadmin@i', $s_module)) echo ' active'; ?>" >
<i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php //echo 'ผู้ดูแลหมวดกระทู้';?> 
</button>
</a>-->

<a href="webboard_config.php" title=""  target="_self">  
<button type="button" data-toggle="tooltip" data-placement="top" title="<?php echo 'ตั้งค่าเว็บบอร์ด'; ?>" class="btn btn-default btn-sm  <?php if(preg_match('@^webboard_config@i', $s_module)) echo ' active'; ?>" >
<i class="far fa-arrow-alt-circle-right"></i>&nbsp;ตั้งค่าเว็บบอร์ด
</button>
</a>
<a href="webboard_del_noti.php" title=""  target="_self">   
<button type="button" data-toggle="tooltip" data-placement="top" title="<?php echo 'แจ้งลบ'; ?>"  class="btn btn-default btn-sm  <?php if(preg_match('@^webboard_del_noti@i', $s_module)) echo ' active'; ?>" >
<i class="far fa-arrow-alt-circle-right"></i>&nbsp;แจ้งลบ
</button>
</a>
<a href="webboard_report.php" title=""  target="_self">   
<button type="button" data-toggle="tooltip" data-placement="top" title="<?php echo 'รายงาน'; ?>" class="btn btn-default btn-sm  <?php if(preg_match('@^webboard_report@i', $s_module)) echo ' active'; ?>" >
<i class="far fa-arrow-alt-circle-right"></i>&nbsp;รายงาน
</button>
</a>
<a href="webboard_emotion.php" title=""  target="_self">
<button type="button" data-toggle="tooltip" data-placement="top" title="<?php echo 'Emotion'; ?>" class="btn btn-default btn-sm <?php if(preg_match('@^webboard_emotion@i', $s_module)) echo ' active'; ?>" >
<i class="far fa-arrow-alt-circle-right"></i>&nbsp;Emotion
</button>
</a>
<a href="webboard_vul.php" title=""  target="_self">
<button type="button" data-toggle="tooltip" data-placement="top" title="<?php echo 'คำไม่สุภาพ'; ?>" class="btn btn-default btn-sm <?php if(preg_match('@^webboard_vul@i', $s_module)) echo ' active'; ?>"  >
          <i class="far fa-arrow-alt-circle-right"></i>&nbsp;คำไม่สุภาพ
</button>
</a>

<!--<a href="webboard_report_usage.php" title=""  target="_self">
<button type="button" class="btn btn-default btn-sm" >
<i class="far fa-arrow-alt-circle-right"></i>&nbsp;Webboard Usage Report
</button>
</a>

<a href="webboard_report_user_stat.php" title=""  target="_self">
<button type="button" class="btn btn-default btn-sm" >
          <i class="far fa-arrow-alt-circle-right"></i>&nbsp;Webboard User Stats
</button>
</a>

<a href="webboard_report_reader_stat.php" title=""  target="_self">
<button type="button" class="btn btn-default btn-sm" >
          <i class="far fa-arrow-alt-circle-right"></i>&nbsp;Webboard Reader Stats
</button>
</a>

<a href="webboard_subadmin.php" title=""  target="_self">
<button type="button" class="btn btn-default btn-sm" >
          <i class="far fa-arrow-alt-circle-right"></i>&nbsp;Webboard Admin Management
</button>
</a>

<a href="webboard_delete_notify.php" title=""  target="_self">
<button type="button" class="btn btn-default btn-sm" >
          <i class="far fa-arrow-alt-circle-right"></i>&nbsp;Delete Notification
</button>
</a>

<a href="webboard_user_noused.php" title=""  target="_self">
<button type="button" class="btn btn-default btn-sm" >
          <i class="far fa-arrow-alt-circle-right"></i>&nbsp;Restricted Name
</button>
</a>

<a href="webboard_vul_index.php" title=""  target="_self">
<button type="button" class="btn btn-default btn-sm" >
          <i class="far fa-arrow-alt-circle-right"></i>&nbsp;Rude Word
</button>
</a>

<!-- <a href="webboard_config.php" title=""  target="_self">
<button type="button" class="btn btn-default btn-sm" >
          <i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php //echo $txt_site_menu_setting;?>
</button>
</a> -->


</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right  visible-xs row m-b-sm ">
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle"><i class="fas fa-bars"></i> menu <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
            <li><a href="../EWT_ADMIN/main.php" ><i class="fas fa-home"></i>&nbsp;<?php echo $txt_ewt_home ;?></a></li>
            <li><a href="webboard_main.php"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php echo $txt_webboard_menu_main;?></a></li>
			<!-- <li><a href="webboard_list.php"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php echo $txt_webboard_menu_user;?></a></li> -->
			<!--<li><a href="webboard_group.php"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php echo $txt_webboard_menu_group;?></a></li>	-->
		</ul>
</div>
</div>


</div>


</div>
</div>
</div>
</div>
<?php
//echo substr(user::encryptPassword(trim('K@nokwan')),0,30);
$db->query("USE ".$EWT_DB_NAME);
?>