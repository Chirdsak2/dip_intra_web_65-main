<?php
$s_code = 'ecard'; 
$s_module = sys::getPage();
?>
<div class="row m-b" style="padding-top:65px;">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm"  >
<div class="card" >
<div class="card-body" >
<div class="row">

<div class="col-md-4 col-sm-4 col-xs-12" >	 
<img src="<?php echo $IMG_PATH ;?><?php echo sys::getModuleImage($s_code);?>" class="animated fadeInDown" style="height: 60px;width: 60px;">  
<span class="animated fadeInDown text-large hidden-xs"><?php echo 'e-Card Management';?></span> 
</div>

<div class="col-md-8 col-sm-8 col-xs-12 float-right text-right hidden-xs" style="top:18px;"> 
<a href="../EWT_ADMIN/main.php" >
<button type="button" class="btn btn-default btn-sm" >
<i class="fas fa-home"></i>&nbsp;<?php echo $txt_ewt_home ;?>
</button> 
</a>

<a href="ecard_dashboard.php"  target="_self" >  
<button type="button" class="btn btn-default btn-sm <?php if(preg_match('@^ecard_dashboard@i', $s_module)) echo ' active'; ?>"  >
<i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php echo 'หน้าหลัก e-Card';?>
</button> 
</a>
<a href="ecard_list.php" target="_self">
<button type="button" class="btn btn-default btn-sm <?php if(preg_match('@^ecard_list@i', $s_module)) echo ' active'; ?>" >
<i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php echo 'การ์ดอวยพร';?> 
</button>
</a>
<a href="ecard_greeting.php" target="_self">
<button type="button" class="btn btn-default btn-sm <?php if(preg_match('@^ecard_greeting@i', $s_module)) echo ' active'; ?>" >
<i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php echo 'คำอวยพร';?> 
</button>
</a>

</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right  visible-xs row m-b-sm ">
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle"><i class="fas fa-bars"></i> menu <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
            <li><a href="../EWT_ADMIN/main.php" ><i class="fas fa-home"></i>&nbsp;<?php echo $txt_ewt_home ;?></a></li>
            <li><a href="ecard_dashboard.php"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php echo 'หน้าหลัก e-Card';?></a></li>
			<li><a href="ecard_list.php"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php echo 'การ์ดอวยพร';?> </a></li>
			<li><a href="ecard_greeting.php"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php echo 'คำอวยพร';?> </a></li>
		
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