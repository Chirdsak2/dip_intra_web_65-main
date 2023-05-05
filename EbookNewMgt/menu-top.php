
<div class="row m-b" style="padding-top:65px;">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm"  >
<div class="card" >
<div class="card-body" >

<div class="row">

<div class="col-md-6 col-sm-6 col-xs-12" >	
<img src="<?php echo $IMG_PATH ;?>images/e-book.png" class="animated fadeInDown " style="height: 60px;width: 60px;">  
<span class="animated fadeInDown text-large hidden-xs"><?php echo $txt_ebook_module;?></span>
</div>

<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right hidden-xs" style="top:18px;"> 
<a href="../EWT_ADMIN/main.php" >
<button type="button" class="btn btn-default btn-sm" >
          <i class="fas fa-home"></i>&nbsp;<?php echo $txt_ewt_home;?> 
</button>
</a>
<a href="ebook_cate.php">
<button type="button" class="btn btn-default btn-sm" >
          <i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php echo $txt_ebook_menu_cate;?>
</button>
</a>
<?php if($_SESSION['EWT_SMTYPE'] == 'Y'){?>
<a href="ebook_file_size.php">
<button type="button" class="btn btn-default btn-sm" >
          <i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php echo $txt_ebook_menu_file_size;?>
</button>
</a>
<a href="ebook_page_size.php"> 
<button type="button" class="btn btn-default btn-sm" > 
          <i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php echo $txt_ebook_menu_page_size;?>
</button>
</a>
<?php } ?>
</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right  visible-xs row m-b-sm ">
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle"><i class="fas fa-bars"></i>  <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right "> 
            <li class=""><a href="../EWT_ADMIN/main.php" ><i class="fas fa-home"></i>&nbsp;<?php echo $txt_ewt_home;?></a></li>
            <li class=""><a href="ebook_cate.php"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php echo $txt_ebook_menu_cate;?></a></li>
			<?php if($_SESSION['EWT_SMTYPE'] == 'Y'){?>
			<li class=""><a href="ebook_file_size.php"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php echo $txt_ebook_menu_file_size;?></a></li>
			<li class=""><a href="ebook_page_size.php"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php echo $txt_ebook_menu_page_size;?></a></li>
			<?php } ?>
		</ul>
</div>
</div>


</div>

</div>
</div>
</div>
</div>