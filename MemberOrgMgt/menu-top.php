
<div class="row m-b" style="padding-top:65px;">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm"  >
<div class="card" >
<div class="card-body" >

<div class="row">

<div class="col-md-4 col-sm-4 col-xs-12" >	
<img src="<?php echo $IMG_PATH ;?>images/Artboard 20.png" class="animated fadeInDown " style="height: 60px;width: 60px;">  
<span class="animated fadeInDown text-large hidden-xs"><?php echo $txt_org_module ;?></span>
</div>

<div class="col-md-8 col-sm-8 col-xs-12 float-right text-right hidden-xs" style="top:18px;"> 
<a href="../EWT_ADMIN/main.php" >
<button type="button" class="btn btn-default btn-sm" >
          <i class="fas fa-home"></i>&nbsp;<?php echo $txt_ewt_home ;?>
</button>
</a>
<a href="org_dashboard.php"  target="_self">
<button type="button" class="btn btn-default btn-sm" >
          <i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php echo $txt_org_menu_main;?>
</button>
</a>
<?php if($db->check_permission("org","u","")){ ?>
<a href="org_list.php"  target="_self">
<button type="button" class="btn btn-default btn-sm" >
          <i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php echo $txt_org_menu_list;?>
</button>
</a>
<!-- <a href="org_chart.php"  target="_self">
<button type="button" class="btn btn-default btn-sm" >
         <i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php echo '';?>
</button>
</a> -->
<?php } if($db->check_permission("org","o","")){ ?>
<!-- <a href="org_group.php" target="_self">
<button type="button" class="btn btn-default btn-sm" >
           <i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php echo $txt_org_menu_group;?>
</button>
</a> -->
<?php } if($db->check_permission("org","p","")){ ?>
<!-- <a href="org_position.php"  target="_self">
<button type="button" class="btn btn-default btn-sm" >
          <i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php echo $txt_org_menu_postion;?>
</button>
</a> -->
<?php } if($db->check_permission("org","g","")){ ?>
<?php /*<a href="GroupList_in.php"  target="_self">
<button type="button" class="btn btn-default btn-sm" >
           <i class="far fa-arrow-alt-circle-right"></i>&nbsp; กลุ่มบุคลากร
</button>
</a>*/?>
<?php } if($db->check_permission("org","m","")){ ?>
<!-- <a href="org_title.php"  target="_self">
<button type="button" class="btn btn-default btn-sm" >
         <i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php echo $txt_org_menu_nametitle;?>
</button>
</a> -->
<?php } 

if($db->check_permission("org","tq","")){ ?>
<a href="org_type_list.php"  target="_self">
<button type="button" class="btn btn-default btn-sm" >
         <i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php echo "ประเภทบุคลากร";?>
</button>
</a>
<?php } ?>

</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right  visible-xs row m-b-sm ">
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle"><i class="fas fa-bars"></i> menu <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
            <li><a href="../EWT_ADMIN/main.php" ><i class="fas fa-home"></i>&nbsp;<?php echo $txt_ewt_home ;?></a></li>
            <li><a href="org_dashboard.php"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php echo $txt_org_menu_main;?></a></li>
			<li><a href="org_list.php"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php echo $txt_org_menu_list;?></a></li>
			<!-- <li><a href="org_position.php"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php echo $txt_org_menu_group;?></a></li>
			<li><a href="org_title.php"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php echo $txt_org_menu_postion;?></a></li>
			<li><a href="org_chart.php"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php echo $txt_org_menu_chart;?></a></li> -->
			<li><a href="org_type_list.php"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php echo "ประเภทบุคลากร";?></a></li>
			
			<!--<li><a href="permission_group.php"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php echo $txt_permission_menu_group;?></a></li>	-->
		</ul>
</div>
</div>


</div>

</div>
</div>
</div>
</div>