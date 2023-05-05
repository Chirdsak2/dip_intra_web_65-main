
<div class="row m-b" style="padding-top:65px;">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm"  >
<div class="card" >
<div class="card-body" >

<div class="row">

<div class="col-md-6 col-sm-6 col-xs-12" >	
<img src="<?=$IMG_PATH ;?>images/template.png" class="animated fadeInDown " style="height: 60px;width: 60px;">  
<span class="animated fadeInDown text-large hidden-xs"><?=$txt_temp_module;?></span>
</div>

<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right hidden-xs" style="top:18px;"> 
<a href="../EWT_ADMIN/main.php" >
<button type="button" class="btn btn-default btn-sm" >
          <i class="fas fa-home"></i>&nbsp;<?=$txt_ewt_home;?>
</button>
</a>
<a href="template_dashboard.php">
<button type="button" class="btn btn-default btn-sm" >
          <i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?=$txt_temp_menu_main;?>
</button>
</a>
<a href="template_list.php">
<button type="button" class="btn btn-default btn-sm" >
          <i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?=$txt_temp_menu_list;?>
</button>
</a>
<a href="page_list.php">
<button type="button" class="btn btn-default btn-sm" >
          <i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?=$txt_temp_menu_page;?>
</button>
</a>
<a href="template_backend.php">
<button type="button" class="btn btn-default btn-sm" >
          <i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?=$txt_temp_menu_backend;?>
</button>
</a>
</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right  visible-xs row m-b-sm ">
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle"><i class="fas fa-bars"></i> menu <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
            <li><a href="../EWT_ADMIN/main.php" ><i class="fas fa-home"></i>&nbsp;<?=$txt_ewt_home ;?></a></li>
            <li><a href="template_dashboard.php"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?=$txt_temp_menu_main;?></a></li>
			<li><a href="template_list.php"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?=$txt_temp_menu_list;?></a></li>
			<li><a href="page_list.php"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?=$txt_temp_menu_page;?></a></li>
			<li><a href="template_backend.php"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?=$txt_temp_menu_backend;?></a></li>
		</ul>
</div>
</div>


</div>

</div>
</div>
</div>
</div>