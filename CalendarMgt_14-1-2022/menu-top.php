
<div class="row m-b" style="padding-top:65px;">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm"  >
<div class="card" >
<div class="card-body" >

<div class="row">

<div class="col-md-6 col-sm-6 col-xs-12" >	
<img src="<?=$IMG_PATH ;?>images/calendar1.png" class="animated fadeInDown " style="height: 60px;width: 60px;">  
<span class="animated fadeInDown text-large hidden-xs"><?=$txt_calendar_module;?></span>
</div>

<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right hidden-xs" style="top:18px;"> 
<a href="../EWT_ADMIN/main.php" >
<button type="button" class="btn btn-default btn-sm" >
          <i class="fas fa-home"></i>&nbsp;<?=$txt_ewt_home ;?>
</button>
</a>
<a href="calendar_list.php" title="<?=$txt_calendar_menu_main;?>"  target="_self">
<button type="button" class="btn btn-default btn-sm" >
          <i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?=$txt_calendar_menu_main;?>
</button>
</a>
<a href="calendar_group.php" title="<?=$txt_calendar_menu_cate;?>"  target="_self">
<button type="button" class="btn btn-default btn-sm" >
          <i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?=$txt_calendar_menu_cate;?>
</button>
</a>
<a href="calendar_visit.php" title="ปฏิทินเยี่ยมชม"  target="_self">
<button type="button" class="btn btn-default btn-sm" >
          <i class="far fa-arrow-alt-circle-right"></i>&nbsp;ปฏิทินเยี่ยมชม
</button>
</a>

<?php /*
<a href="calendar_visit_topic.php" title="หัวข้อการเยี่ยมชม"  target="_self">
<button type="button" class="btn btn-default btn-sm" >
          <i class="far fa-arrow-alt-circle-right"></i>&nbsp;หัวข้อการเยี่ยมชม
</button>
</a>
*/ ?>

<a href="calendar_google.php" title="<?=$txt_calendar_menu_google;?>"  target="_self">
<button type="button" class="btn btn-default btn-sm" >
          <i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?=$txt_calendar_menu_google;?>
</button>
</a>
</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right  visible-xs row m-b-sm ">
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle"><i class="fas fa-bars"></i> menu <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
            <li><a href="../EWT_ADMIN/main.php" ><i class="fas fa-home"></i>&nbsp;<?=$txt_ewt_home ;?></a></li>
            <li><a href="calendar_list.php"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?=$txt_calendar_menu_main;?></a></li>
			<li><a href="calendar_group.php"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?=$txt_calendar_menu_cate;?></a></li>
			<li><a href="calendar_visit.php"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;ปฏิทินเยี่ยมชม</a></li>
            <?php /*
            <li><a href="calendar_visit_topic.php"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;หัวข้อการเยี่ยมชม</a></li>
            */ ?>
		</ul>
</div>
</div>


</div>

</div>
</div>
</div>
</div>