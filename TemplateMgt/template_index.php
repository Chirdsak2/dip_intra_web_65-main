<?php
include("../EWT_ADMIN/comtop.php");
 


$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
if ($page <= 0) $page = 1;

$per_page = 10;

$startpoint = ($page * $per_page) - $per_page;


if($_SESSION["EWT_SMTYPE"] == "Y"){
	
$statement = "p_survey  WHERE s_pos <> '' ";

}else{
	
$statement = "p_survey WHERE s_uid = '{$_SESSION['EWT_SMID']}' ";

}

if($do == "2"){
$statement .= " AND s_approve = 'Y' AND ( '{$dn}' BETWEEN s_start AND s_end )";
	}elseif($do == "3"){
		$statement .= " AND s_approve = 'Y' ";
		}elseif($do == "4"){
			$statement .= " AND s_approve = 'N' ";
			}
			
			$statement.= " ORDER BY s_pos ASC";
			

$s_survey = "SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}";
			
$r_survey = $db->query($s_survey);
?>
<div class="container-fluid" >
<?php
include("menu-top.php");
?>
<!-- START CONTAINER  -->
<div class="row m-b-sm">

<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<div class="card">
<div class="card-header">

<div class="container-fluid" >
<span class="text-x-large">Templates Lists</span>
<p></p> 
              
<ol class="hidden-xs breadcrumb">
<li><a href="index.php">Templates Lists</a></li>
<li class=""></li>       
</ol>
</div>

<div class="hidden-xs row m-b-sm">
<div class="col-md-6 col-sm-6 col-xs-12" >
</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right"  >	  
<!--<a href="add_survey1.php" target="_self">
<button type="button" class="btn btn-info  btn-md " >
<i class="fas fa-plus-circle" aria-hidden="true"></i>&nbsp;&nbsp;เพิ่มแบบฟอร์มออนไลน์
</button>
</a>
<a href="" target="_self">
<button type="button" class="btn btn-info  btn-ml " >
       <span class="glyphicon glyphicon-backward"></span>&nbsp;&nbsp;<?//="ย้อนกลับ";?>
</button>
</a>  -->
<a  target="_self" onclick="boxPopup('<?=linkboxPopup();?>pop_search.php');">
<button type="button" class="btn btn-info  btn-ml " >
<i class="fas fa-search"></i>&nbsp;<?="Search";?>
</button>
</a>
<a  target="_self" onclick="boxPopup('<?=linkboxPopup();?>pop_add_template.php');">
<button type="button" class="btn btn-info  btn-ml " >
<i class="fas fa-plus-square"></i>&nbsp;<?="Create Templates";?>
</button>
</a>
</div>
</div>
<div class="visible-xs row m-b-sm text-right">
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle">Action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
            <li><a href="#<?="Search";?>" onclick="boxPopup('<?=linkboxPopup();?>pop_search.php');"><i class="fas fa-search"></i>&nbsp;<?="Search";?></a></li>
            <li><a href="#<?="Create Templates";?>" onclick="boxPopup('<?=linkboxPopup();?>pop_add_template.php');" ><i class="fas fa-plus-square"></i>&nbsp;<?="Create Templates";?></a></li>
        </ul>
    </div>
</div>

</div>

<div class="card-body">

<div class="row ">
<?php for($i=1;$i <= 8;$i++){ ?>
<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 m-b-sm" >

<div class="blog-card spring-fever m-b-sm ">
<div class="title-content">

<h3>Template-Mots-<?=$i;?></h3>
<hr class="hr-blog-card" />
<div class="intro">Template-Mots-<?=$i;?></div>
</div>
<div class="card-info" >
<div class="view_details" onclick="boxPopup('<?=linkboxPopup();?>pop_view_template.php');"><i class="far fa-eye fa-1x"></i>&nbsp;View</div>
<div class="view_details" onclick="self.location.href='template_edit.php'"><i class="fas fa-cogs fa-1x"></i>&nbsp;Edit</div>

</div>

<div class="utility-info">
    <ul class="utility-list">
      <li class="date"><i class="far fa-calendar-alt"></i> 03-12-2018</li>
    </ul>
</div>
  
<div class="gradient-overlay"></div>
<div class="color-overlay"></div>
</div>

</div>
<?php } ?>
<?=pagination($statement,$per_page,$page,$url='?');?>
</div>  




</div>
</div>
</div>
</div>

</div>
<!-- END CONTAINER  -->
<?php
include("../EWT_ADMIN/combottom.php");
?>