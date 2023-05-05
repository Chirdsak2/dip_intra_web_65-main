<?php
$s_code = 'km'; 
$s_module = sys::getPage();
?>
<div class="row m-b" style="padding-top:65px;">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm"  >
<div class="card" >
<div class="card-body" >
<div class="row">

<div class="col-md-4 col-sm-4 col-xs-12" >	 
<img src="<?php echo $IMG_PATH ;?><?php echo sys::getModuleImage($s_code);?>" class="animated fadeInDown" style="height: 60px;width: 60px;">  
<span class="animated fadeInDown text-large hidden-xs"><?php echo 'Km Management';?></span> 
</div>

<div class="col-md-8 col-sm-8 col-xs-12 float-right text-right hidden-xs" style="top:18px;"> 
<a href="../EWT_ADMIN/main.php" >
<button type="button" class="btn btn-default btn-sm" >
<i class="fas fa-home"></i>&nbsp;<?php echo $txt_ewt_home ;?>
</button> 
</a>

<a href="km_dashboard.php"  target="_self" >  
<button type="button" class="btn btn-default btn-sm <?php if(preg_match('@^km_dashboard@i', $s_module)) echo ' active'; ?>"  >
<i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php echo 'หน้าหลัก KM';?>
</button> 
</a>
<a href="km_setting.php" target="_self">
<button type="button" class="btn btn-default btn-sm <?php if(preg_match('@^km_setting@i', $s_module)) echo ' active'; ?>" >
<i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php echo 'ตั้งค่าคะแนน KM';?> 
</button>
</a>
<a href="km_user.php" target="_self">
<button type="button" class="btn btn-default btn-sm <?php if(preg_match('@^km_user@i', $s_module)) echo ' active'; ?>" >
<i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php echo 'รายชื่อผู้ที่ได้รับคะแนน';?> 
</button>
</a>
</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right  visible-xs row m-b-sm ">
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle"><i class="fas fa-bars"></i> menu <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
            <li><a href="../EWT_ADMIN/main.php" ><i class="fas fa-home"></i>&nbsp;<?php echo $txt_ewt_home ;?></a></li>
            <li><a href="km_dashboard.php"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php echo 'หน้าหลัก KM';?></a></li>
			<li><a href="km_setting.php"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php echo 'ตั้งค่าคะแนน KM';?> </a></li>
            <li><a href="km_user.php"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php echo 'รายชื่อผู้ที่ได้รับคะแนน';?> </a></li>
		</ul>
</div>
</div>

</div>
</div>
</div>
</div>
</div>
<?php
$db->query("USE ".$EWT_DB_NAME);
?>