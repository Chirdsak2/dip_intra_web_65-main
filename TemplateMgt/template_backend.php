<?php
include("../EWT_ADMIN/comtop.php");
$tid = (int)(!isset($_GET['tid']) ? '' : $_GET['tid']); 
?>
<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");
?>
<div class="row m-b-sm">

<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<div class="card">
<div class="card-header">

<div class="container-fluid" >
<span class="text-x-large"><?=$txt_temp_menu_backend;?></span>
<p></p> 
              
<ol class="hidden-xs breadcrumb">
<li><a href="template_dashboard.php"><?=$txt_temp_menu_main;?></a></li>
<li class=""><?=$txt_temp_menu_backend;?></li>       
</ol>
</div>

<div class="hidden-xs row m-b-sm">
<div class="col-md-6 col-sm-6 col-xs-12" >
</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right"  >	  



</div>
</div>
<div class="visible-xs row m-b-sm text-right">
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle">action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
           
        </ul>
    </div>
</div>

</div>
<!--END card-header -->

<!--start card-body -->
<div class="card-body">
<div class="row ">
<div class="col-md-12 col-sm-12 col-xs-12" id="table-view" >


<div class="col-gl-3 col-md-3 col-sm-3 col-xs-3 m-b-sm" >
<div class="card ">
<div class="card-header ewt-bg-color m-b-sm" >
<div class="card-title text-left">
<div class="title" ><i class="fab fa-elementor text-warning"></i><?='';?></div>
</div>
</div>
<div class="card-body" id="tab1">
<ul class="sortableLv1 connectedSortable ">
<li class="productCategoryLevel1"> Login Backend 
<div class="iconAction1">
<button type="button" class="btn btn-default btn-circle btn-sm " onclick="location.href='template_backend.php?tid=1'" data-toggle="tooltip" data-placement="top" title="" data-original-title="ตั้งค่า">
<i class="fas fa-cogs text-info" aria-hidden="true"></i>
</button>
</div>

</li>

</ul>


</div>				
</div>
</div>

<?php if(!empty($tid)){ ?>
<div class="col-gl-9 col-md-9 col-sm-9 col-xs-9 m-b-sm" >

<div class="card ">
<div class="card-body" id="">
<div class="text-right m-b-sm">
<button type="button" class="btn btn-info  btn-md " onclick="boxPopup('<?=linkboxPopup();?>pop_edit_temp_jscode.php?tid=');" data-toggle="tooltip" data-placement="top" title="<?='JS';?>"  >
<i class="fab fa-js-square" aria-hidden="true"> </i> JS
</button>
<button type="button" class="btn btn-warning  btn-md " onclick="boxPopup('<?=linkboxPopup();?>pop_edit_temp_csscode.php?tid=');" data-toggle="tooltip" data-placement="top" title="<?='CSS';?>"  >
<i class="fab fa-css3-alt " aria-hidden="true"></i> CSS
</button>
<button type="button" class="btn btn-default  btn-md " onclick="boxPopup('<?=linkboxPopup();?>pop_view_temp_backend.php?tid=');" data-toggle="tooltip" data-placement="top" title="<?=$txt_temp_preview;?>"  >
<i class="far fa-eye " aria-hidden="true"></i>
</button>
</div>
<div class="blog-card-item spring-fever m-b-sm">
<div class="title-content">
<h3>Logo</h3>
<hr class="hr-blog-card" />
<div class="intro"></div>
</div>
<div class="card-info" >
<div class="view_details" >
<button type="button" class="btn btn-default btn-circle btn-sm " onclick="boxPopup('<?=linkboxPopup();?>pop_edit_temp_backend.php?tid=&bid=');" >
<i class="fas fa-cogs " aria-hidden="true"></i>
</button>
</div>

</div>
<div class="gradient-overlay"></div>
<div class="color-overlay"></div>
</div>

<div class="blog-card-item spring-fever m-b-sm">
<div class="title-content">
<h3>Title TH</h3>
<hr class="hr-blog-card" />
<div class="intro"></div>
</div>
<div class="card-info" >
<div class="view_details" >
<button type="button" class="btn btn-default btn-circle btn-sm " onclick="boxPopup('<?=linkboxPopup();?>pop_edit_temp_backend.php?tid=&bid=');" >
<i class="fas fa-cogs " aria-hidden="true"></i>
</button>
</div>
</div>
<div class="gradient-overlay"></div>
<div class="color-overlay"></div>
</div>


<div class="blog-card-item spring-fever m-b-sm">
<div class="title-content">
<h3>Title EN</h3>
<hr class="hr-blog-card" />
<div class="intro"></div>
</div>
<div class="card-info" >
<div class="view_details" >
<button type="button" class="btn btn-default btn-circle btn-sm " onclick="boxPopup('<?=linkboxPopup();?>pop_edit_temp_backend.php?tid=&bid=');" >
<i class="fas fa-cogs " aria-hidden="true"></i>
</button>
</div>
</div>
<div class="gradient-overlay"></div>
<div class="color-overlay"></div>
</div>

<div class="blog-card-item spring-fever m-b-sm">
<div class="title-content">
<h3>Form Login</h3>
<hr class="hr-blog-card" />
<div class="intro"></div>
</div>
<div class="card-info" >
<div class="view_details" >
<button type="button" class="btn btn-default btn-circle btn-sm " onclick="boxPopup('<?=linkboxPopup();?>pop_edit_temp_backend.php?tid=&bid=');" >
<i class="fas fa-cogs " aria-hidden="true"></i>
</button>
</div>
</div>
<div class="gradient-overlay"></div>
<div class="color-overlay"></div>
</div>

<div class="blog-card-item spring-fever m-b-sm">
<div class="title-content">
<h3>Footer</h3>
<hr class="hr-blog-card" />
<div class="intro"></div>
</div>
<div class="card-info" >
<div class="view_details" >
<button type="button" class="btn btn-default btn-circle btn-sm " onclick="boxPopup('<?=linkboxPopup();?>pop_edit_temp_backend.php?tid=&bid=');" >
<i class="fas fa-cogs " aria-hidden="true"></i>
</button>
</div>
</div>
<div class="gradient-overlay"></div>
<div class="color-overlay"></div>
</div>

</div>				
</div>
</div>
<?php } ?>


</div>
</div>

</div>
<!--END card-body-->
</div>
<!--END card-->
</div>
</div>

</div>
<!-- END CONTAINER  -->
<?php
include("../EWT_ADMIN/combottom.php");
?>