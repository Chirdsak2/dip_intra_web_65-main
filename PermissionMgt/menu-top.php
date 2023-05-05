
<div class="row m-b" style="padding-top:65px;">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm"  >
<div class="card" >
<div class="card-body" >

<div class="row">

<div class="col-md-4 col-sm-4 col-xs-12" >	
<img src="<?=$IMG_PATH ;?>images/OrgManager.png" class="animated fadeInDown " style="height: 60px;width: 60px;">  
<span class="animated fadeInDown text-large hidden-xs"><?=$txt_permission_module ;?></span>
</div>

<div class="col-md-8 col-sm-8 col-xs-12 float-right text-right hidden-xs" style="top:18px;"> 
<a href="../EWT_ADMIN/main.php" >
<button type="button" class="btn btn-default btn-sm" >
          <i class="fas fa-home"></i>&nbsp;<?=$txt_ewt_home ;?>
</button>
</a>
<a href="permission_main.php" title="<?=$txt_permission_menu_main ;?>"  target="_self">
<button type="button" class="btn btn-default btn-sm" >
          <i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?=$txt_permission_menu_main;?>
</button>
</a>
<a href="permission_user.php" title="<?=$txt_permission_menu_user ;?>"  target="_self">
<button type="button" class="btn btn-default btn-sm" >
          <i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?=$txt_permission_menu_user;?>
</button>
</a>
<!--<a href="permission_group.php" title="<?=$txt_permission_menu_group;?>"  target="_self">
<button type="button" class="btn btn-default btn-sm" >
          <i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?=$txt_permission_menu_group;?>
</button>
</a>-->

<!-- <a href="permission_org.php" title="รายการสิทธิ์กลุ่มหน่วยงาน"  target="_self">
<button type="button" class="btn btn-default btn-sm" >
          <i class="far fa-arrow-alt-circle-right"></i>&nbsp;รายการสิทธิ์กลุ่มหน่วยงาน
</button>
</a> -->

</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right  visible-xs row m-b-sm ">
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle"><i class="fas fa-bars"></i> menu <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
            <li><a href="../EWT_ADMIN/main.php" ><i class="fas fa-home"></i>&nbsp;<?=$txt_ewt_home ;?></a></li>
            <li><a href="permission_main.php"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?=$txt_permission_menu_main;?></a></li>
			<li><a href="permission_list.php"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?=$txt_permission_menu_user;?></a></li>
			<!--<li><a href="permission_group.php"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?=$txt_permission_menu_group;?></a></li>	-->
		</ul>
</div>
</div>


</div>

</div>
</div>
</div>
</div>