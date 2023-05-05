
<div class="row m-b" style="padding-top:65px;">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm"  >
<div class="card" >
<div class="card-body" >

<div class="row">

<div class="col-md-4 col-sm-4 col-xs-12" >	
<img src="<?=$IMG_PATH ;?>images/E-Newsletter.png" class="animated fadeInDown " style="height: 60px;width: 60px;">  
<span class="animated fadeInDown text-large hidden-xs"><?=$txt_enews_module;?></span>
</div>

<div class="col-md-8 col-sm-8 col-xs-12 float-right text-right hidden-xs" style="top:18px;"> 
<a href="../EWT_ADMIN/main.php" >
<button type="button" class="btn btn-default btn-sm" >
          <i class="fas fa-home"></i>&nbsp;<?=$txt_ewt_home ;?>
</button>
</a>
<a href="enews_main.php" title="<?=$txt_calendar_menu_main;?>"  target="_self">
<button type="button" class="btn btn-default btn-sm" >
          <i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?=$txt_enews_menu_main;?>
</button>
</a>
<a href="enews_cate.php" title="<?=$txt_calendar_menu_cate;?>"  target="_self">
<button type="button" class="btn btn-default btn-sm" >
          <i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?=$txt_enews_menu_cate;?>
</button>
</a>
<a href="news_index.php?proc=1" title="<?=$text_genrss_modulesub_attact;?>" class="btn btn-default btn-sm" ><li class="far fa-arrow-alt-circle-right"></li> <?php echo $text_genrss_modulesub_attact;?></a>
<a href="news_index.php?proc=2" title="<?=$text_genrss_modulesub_news;?>" class="btn btn-default btn-sm" ><li class="far fa-arrow-alt-circle-right"></li> <?php echo $text_genrss_modulesub_news;?></a> 
<a href="news_index.php?proc=3" title="<?=$text_genrss_modulesub_email;?>" class="btn btn-default btn-sm" ><li class="far fa-arrow-alt-circle-right"></li> <?php echo $text_genrss_modulesub_email;?></a>
<!--<a href="enews_drafts.php" title="<?=$txt_enews_menu_drafts;?>"  target="_self">
<button type="button" class="btn btn-default btn-sm" >
          <i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?=$txt_enews_menu_drafts;?>
</button>
</a>-->
<a href="enews_member.php" title="<?=$txt_enews_menu_member;?>"  target="_self">
<button type="button" class="btn btn-default btn-sm" >
          <i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?=$txt_enews_menu_member;?>
</button>
</a>

</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right  visible-xs row m-b-sm ">
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle"><i class="fas fa-bars"></i> menu <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
            <li><a href="../EWT_ADMIN/main.php" ><i class="fas fa-home"></i>&nbsp;<?=$txt_ewt_home ;?></a></li>
            <li><a href="enews_main.php"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?=$txt_enews_menu_main;?></a></li>
			<li><a href="enews_cate.php"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?=$txt_enews_menu_cate;?></a></li>
			<li><a href="enews_drafts.php"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?=$txt_enews_menu_drafts;?></a></li>
			<li><a href="enews_member.php"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?=$txt_enews_menu_member;?></a></li>
		</ul>
</div>
</div>


</div>

</div>
</div>
</div>
</div>