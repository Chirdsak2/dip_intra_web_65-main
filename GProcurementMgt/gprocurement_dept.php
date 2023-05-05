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

<h4><?php echo $txt_egp_dept;?></h4>
<p></p> 
</div>

<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><?php echo $txt_egp_dept;?></li>
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	  
<a onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_dept.php?proc=AddProc');"   target="_self">
<button type="button" class="btn btn-info  btn-ml"  title="<?php echo $txt_egp_dept_add;;?>" >
<i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_egp_dept_add;?> 
</button>
</a>
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
            <li class=""><a onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_dept.php?proc=AddProc');" ><i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_menu_add;;?></a></li>
          	<li class=""><a onClick="boxPopup('<?php echo linkboxPopup();?>pop_search.php');" ><i class="fas fa-search"></i>&nbsp;<?php echo $txt_menu_search;?></a></li>
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

$_sql = $db->query("SELECT * FROM egp_dept WHERE egp_dept_status = 'Y' AND egp_dept_sub = '0' {$wh} ORDER BY egp_dept_id DESC LIMIT {$start} , {$perpage} ");

$statement = "SELECT count(egp_dept_id) AS b
			  FROM egp_dept 
			  WHERE egp_dept_status = 'Y' AND egp_dept_sub = '0'
			  {$wh} ";
			  
$a_rows = $db->db_num_rows($_sql);		
$s_count = $db->query($statement);
$a_count = $db->db_fetch_array($s_count);
$total_record = $a_count['b'];
$total_page = (int)ceil($total_record / $perpage);
?>
<div class="table-responsive">
<table class="table table-bordered" >
    <thead>
	<tr class="info"> 
		<th style="width:5%;"  class="text-center">#</th>
        <th style="width:15%;" class="text-center"><?php echo $txt_egp_dept_code;?></th>
        <th style="width:70%;" class="text-center"><?php echo $txt_egp_dept_name;?> </th> 
        <th style="width:10%;" class="text-center"></th>
      </tr>
    </thead>
    <tbody>
<?php
if($a_rows)
{	
if($start==0){
$i=1;
}else{
$i=$start+1;	
}
	
while($a_data = $db->db_fetch_array($_sql))
{
?>
<tr>
<td class="text-center"><?php echo $i.".";?></td>
<td class="text-center"><?php echo $a_data['egp_dept_code'];?></td>
<td><?php echo $a_data['egp_dept_name'];?></td>
<td class="text-center">
<a href="#!" onclick="boxPopup('<?php echo linkboxPopup();?>pop_add_dept.php?proc=EditProc&egp_id=<?php echo $a_data['egp_dept_id'];?>');" data-toggle="tooltip" data-placement="top" title="<?php echo $txt_egp_dept_edit;?>">
<button type="button" class="btn btn-warning  btn-circle  btn-xs " >
<i class="fas fa-edit" aria-hidden="true"></i>
</button>
</a>
	  
<!--<a  onclick="boxPopup('<?//=linkboxPopup();?>pop_view_survey.php?s_id=<?php echo $a_survey['s_id']; ?>');" _onClick="window.open('view_survey.php?s_id=<?php echo $a_survey['s_id']; ?>','newwin','scrollbars=yes,resizable=yes,width=650,height=500');" data-toggle="tooltip" data-placement="top" title="<?php echo $lang_survey_result1;?>">
<button type="button" class="btn btn-success btn-circle  btn-xs " >
<i class="fas fa-search" aria-hidden="true"></i>
</button>
</a>-->
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
	<td class="text-center" colspan="3">
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