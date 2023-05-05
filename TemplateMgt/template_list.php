<?php
include("../EWT_ADMIN/comtop.php");
 
$perpage = 10;
$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
if($page <= 0) $page = 1;
$start = ($page * $perpage) - $perpage;

$_sql = $db->query("SELECT *
					FROM m_complain
					WHERE status = ''
					{$wh} 
					ORDER BY m_complain.id DESC LIMIT {$start} , {$perpage} ");

$statement = "SELECT count(id) AS b
			  FROM m_complain 
			  WHERE status = ''
			  {$wh} ";
			  
$a_rows = $db->db_num_rows($_sql);		
$s_count = $db->query($statement);
$a_count = $db->db_fetch_array($s_count);
$total_record = $a_count['b'];
$total_page = (int)ceil($total_record / $perpage);
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
<span class="text-x-large">Page List</span>
<p></p> 
              
<ol class="hidden-xs breadcrumb">
<li><a href="template_dashboard.php">หน้าหลัก Templates</a></li>
<li class="">Page List</li>       
</ol>
</div>

<div class="hidden-xs row m-b-sm">
<div class="col-md-6 col-sm-6 col-xs-12" >
</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right"  >	  

<a  target="_self" onclick="boxPopup('<?=linkboxPopup();?>pop_search.php');">
<button type="button" class="btn btn-info  btn-ml " >
<i class="fas fa-search"></i>&nbsp;<?="";?>
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
<!--END card-header -->

<!--start card-body -->
<div class="card-body">
<div class="row ">
<div class="col-md-12 col-sm-12 col-xs-12" id="table-view" >

<div class="row ">

<div class="col-md-3 col-sm-3 col-xs-6"  >
<div class="blog-card spring-fever m-b-sm">
<div class="title-content">
<h3>Footer</h3>
<hr class="hr-blog-card" />
<div class="intro"></div>
</div>
<div class="card-info" >
<div class="view_details" >
<i class="fas fa-cogs " aria-hidden="true"></i>
</div>
</div>
<div class="gradient-overlay"></div>
<div class="color-overlay"></div>
</div>
</div>

</div>

<?=pagination_ewt($statement,$perpage,$page,$url='?');?>	
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