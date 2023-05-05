<?php
include("../EWT_ADMIN/comtop.php");
?>  
<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");
?>
<div class="row m-b-sm">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<!--start card -->
<div class="card">
<!--start card-header -->
<div class="card-header">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<h4><?php echo $txt_egp_menu_main;?></h4>
<p></p> 
</div>

<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><?php echo $txt_egp_menu_main;?></li>
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	  
<!--<a onClick="boxPopup('<?//=linkboxPopup();?>pop_add_menu.php');"   target="_self">
<button type="button" class="btn btn-info  btn-ml"  title="<?//=$txt_menu_add;;?>" >
<i class="fas fa-plus-circle"></i>&nbsp;<?//=$txt_menu_add;?>
</button>
</a>-->
<a  target="_self" onclick="boxPopup('<?php echo linkboxPopup();?>pop_search.php');" >
<button type="button" class="btn btn-info  btn-ml "  title="<?php echo $txt_menu_search;?>"  >
<i class="fas fa-search"></i>&nbsp;<?php echo $txt_menu_search;?>
</button>
</a>
</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right pointer">
          	<li class=""><a onClick="boxPopup('<?php echo linkboxPopup();?>pop_search_menu.php');" ><i class="fas fa-search"></i>&nbsp;<?php echo $txt_menu_search;?></a></li>
		</ul>
</div>
</div>	
</div>
</div>

</div>
<!--END card-header -->

<!--start card-body -->
<div class="card-body">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<?php
$perpage = 10;
$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
if($page <= 0) $page = 1;
$start = ($page * $perpage) - $perpage;

$wh = "AND egp_list_dept = '1906' OR egp_list_dept = '1900600000'";  

$_sql = $db->query("SELECT *  FROM egp_list WHERE 1=1 {$wh} GROUP BY  egp_list_title ORDER BY egp_list_pubdate DESC LIMIT {$start} , {$perpage} ");

$statement 	= "SELECT count(DISTINCT egp_list_title) AS b
			  FROM egp_list 
			  WHERE 1=1
			  {$wh} ";
			  
$a_rows 	= $db->db_num_rows($_sql);		
$s_count 	= $db->query($statement);
$a_count 	= $db->db_fetch_array($s_count);
$total_record = $a_count['b'];
$total_page = (int)ceil($total_record / $perpage);
?>
<div class="table-responsive">
<table width="100%" border="0" align="center" class="table table-bordered" >
    <thead>
	<tr class="info">
		<th width="5%" 	class="text-center" >&nbsp;</th>
        <th width="55%" class="text-center" >หัวข้อ</th>
		<th width="15%" class="text-center" >วันที่</th>
        <th width="25%" class="text-center" >รายละเอียด</th>
	
      </tr>
    </thead>
    <tbody>
<?php
if($start==0)
{
	$i=1;
}
else
{
	$i=$start+1;	
}
	
if($a_rows)
{	
while($a_data = $db->db_fetch_array($_sql))
{
?>
<tr>
<td class="text-center"><?php echo $i.".";?></td>
<td style="text-align:left;"><?php echo $a_data['egp_list_title'];?></td>
<td class="text-center"><?php echo $a_data['egp_list_pubdate'];?></td>
<td class="text-center">
<a onclick="boxPopup('<?php echo linkboxPopup();?>pop_system.php?id=<?php echo $a_data['egp_list_id']; ?>');" data-toggle="tooltip" data-placement="right" title="รายละเอียด" >
<button type="button" class="btn btn-info" >
<span class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;รายละเอียด
</button>
</a>
</td>
</tr>
<?php 
	$i++;
	} 
}
else
{ 
?>
	<tr>
	<td class="text-center">
    <p class="text-danger"><?php echo $txt_ewt_data_not_found;?></p>
	</td>
	</tr>
<?php } ?>	
</tbody> 
</table> 
</div>
<?php echo pagination_ewt($statement,$perpage,$page,$url='?');?>	
</div>
</div>

</div>
<!--END card-body -->
</div>
<!--END card -->
</div>
</div>
</div>
<!-- END CONTAINER  -->
<?php
include("../EWT_ADMIN/combottom.php");
?>
<script>


</script>

