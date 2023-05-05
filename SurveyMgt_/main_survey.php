<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../ewt_block_function.php");
include("lang_config.php"); 

include("../lib/config_path.php");
include("../header.php");
?>
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<link href="../js/x0popup-master/dist/x0popup.min.css" rel="stylesheet" type="text/css">
<?php include('../EWT_ADMIN/link.php'); ?>
<script src="../js/ckeditor/ckeditor.js"></script> 
<script src="../js/x0popup-master/dist/x0popup.min.js"></script> 
<link rel="stylesheet" type="text/css" href="../js/jquery-confirm-master/css/jquery-confirm.css"/>
 
<?php
function datetime($str){
  $y=substr($str,0,4);
  if($y)$y=($y*1)+543;
  $m=substr($str,4,2);
  $d=substr($str,6,2);
  $h=substr($str,8,2);
  $i=substr($str,10,2);
  $s=substr($str,12,2);
  
  $str="$d/$m/$y [$h:$i:$s]";
  if(trim($str)=="// [::]"){ return '-'; }else{ return  $str;}
}

function CountAnswer($s_id,$type){
     global $db;
     $query = $db->query("SELECT * FROM p_survey WHERE s_id = '$s_id' ");
	 $res=$db->db_fetch_array($query);
	 $table=$res[s_table];
	 if($type=='Member'){
	 	$query = $db->query("SELECT count(survey_id) as ans FROM $table  WHERE person_answer > '0' "); 
	 	$res=$db->db_fetch_array($query);
		 $data=$res[ans];
	 }else if($type=='User'){
		 $query = $db->query("SELECT count(survey_id) as ans FROM $table  WHERE person_answer = '0' "); 
		 $res=$db->db_fetch_array($query);
		 $data=$res[ans];
	}else{
		$query = $db->query("SELECT count(survey_id) as ans FROM $table"); 
	 	$res=$db->db_fetch_array($query);
		 $data=$res[ans];
	}
	  return $data;
}

?>
<script >
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->

function approve(c){
var a = confirm('คุณแน่ใจที่จะอนุมัติแบบสอบถามนี้  ?');
if(a==true){
window.location.href="function_approve.php?s_id="+c;
}
}
</script>
<?php
$Yn = date("Y")+543;
$dn = date("m-d");
$dn = $Yn."-".$dn;


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
			
			$statement.= "AND s_approve <>''  ORDER BY s_pos ASC";
			

$s_survey = "SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}";
			
$r_survey = $db->query($s_survey);
?>

<body leftmargin="0" topmargin="0">
<?php include('top.php');?>

<div class="panel panel-default" style="border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<!--<div class="panel-heading" style="background-color:#FFC153;border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<h4 style="color:#FFFFFF;">Form Generator</h4>
</div>-->
<div class="container" style="width:98%;">
<h2>บริหารแบบฟอร์มออนไลน์ (Form Generator)</h2>
<p></p> 
              
<ol class="breadcrumb">
<li><a href="index.php">บริหารแบบฟอร์มออนไลน์ (Form Generator)</a></li>
<li class=""></li>       
</ol>

</div>

<div class="panel-body">
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12" >
</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right" style="text-align:right;" >	  
<a href="add_survey1.php" target="_self">
<button type="button" class="btn btn-info  btn-md " >
<i class="fas fa-plus-circle" aria-hidden="true"></i>&nbsp;&nbsp;เพิ่มแบบฟอร์มออนไลน์
</button>
</a>
<!--<a href="" target="_self">
<button type="button" class="btn btn-info  btn-ml " >
       <span class="glyphicon glyphicon-backward"></span>&nbsp;&nbsp;<?//="ย้อนกลับ";?>
</button>
</a>  -->
</div>	
</div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12" id="table-view" >
<hr>
<div class="table-responsive">
<form name="form1" method="post" action="add_function.php" >
<table width="100%" border="0" align="center" class="table table-bordered" >
<thead>
<tr class="success">
<th width="5%" > </th>
<th width="20%" class="text-center" ><?=$lang_add_subject;?></th>
<th width="5%"  class="text-center" ><?=$lang_survey_mystatus;?></th>
<th width="10%" class="text-center" ><?=$lang_add_start2;?></th>
<th width="10%" class="text-center" ><?=$lang_add_end2;?></th>
<th width="5%"  class="text-center" ><?=$text_genpoll_Vote_User;?></th>
<th width="10%" class="text-center" ><?=$text_genpoll_Vote_Create;?></th>
<th width="10%" class="text-center" ><?=$text_genpoll_Vote_Update;?></th>
<th width="10%" class="text-center" ><?=$text_genpoll_Vote_Count;?></th>	  
<!--<th width="5%"  class="text-center" ><?//=$lang_survey_delete;?></th>-->
<th width="15%" ></th>
</tr>
</thead>
<tbody>
<?php
if($a_rows = $db->db_num_rows($r_survey)){
$i = 1+$startpoint;
	while($a_survey = $db->db_fetch_array($r_survey)){ 
?>
<tr> 
<td class="text-center" ><?=$i;?></td>
<td>
<a  onclick="boxPopup('<?=linkboxPopup();?>pop_survey.php?s_id=<?=$a_survey['s_id']; ?>');" data-toggle="tooltip" data-placement="right" title="ดูแบบสอบถาม" ><?=$a_survey['s_title'];?></a>
</td>
<td class="text-center">
<?php 
 if($a_survey['s_approve']=="N"){ 
?>
<a href="#app" onClick="JQApprove_Survey('<?=$a_survey['s_id']; ?>');" data-toggle="tooltip" data-placement="right" title="<?=$lang_survey_approve2;?>" >
<h5 ><span class="label label-info"><i class="fa fa-cogs" aria-hidden="true"></i> <span><?=$lang_survey_approve2;?></span></span></h5> 
</a>
<?php 
	  }else{
?>
<h5 ><span class="label label-success"><i class="fa fa-check-circle" aria-hidden="true"></i> <span><?=$lang_survey_approve1;?></span></span></h5> 
<?php
	  } 
?>
</td>
<td class="text-center">
<h5 class=""><?php $st = explode("-",$a_survey['s_start']); echo $st[2]."-".$st[1]."-".$st[0]; ?></h5> 
</td>
<td class="text-center">
<h5 class=""><?php $en = explode("-",$a_survey['s_end']); echo $en[2]."-".$en[1]."-".$en[0]; ?></h5> 
</td>
		
<td class="text-center"><h5 class="text-warning"><?=$a_survey['s_creater'];?></h5> </td>
<td class="text-center"><h5 class=""><?=datetime($a_survey['s_timestamp']) ;?></h5></td>
<td class="text-center"><h5 class=""><?=datetime($a_survey['s_lastupdate']);?></h5></td> 
<td class="text-center">
	  <?php if($a_survey['s_approve']!="N"){?>
	  <a href="#view" _onClick="window.open('view_survey_stat.php?s_id=<?=$a_survey['s_id'];?>&type=m','newwin','scrollbars=yes,resizable=yes,width=650,height=500');">
	  <span class="label label-primary"><?=CountAnswer($a_survey['s_id'],'Member');  ?></span></a> /  
	  <a href="#view" _onClick="window.open('view_survey_stat.php?s_id=<?= $a_survey['s_id']; ?>','newwin','scrollbars=yes,resizable=yes,width=650,height=500');">
	  <span class="label label-success"><?=CountAnswer($a_survey['s_id'],'ALL');  ?></span> </a>
	 <?php } ?>
</td>
<!--<td class="text-center">
<?php
/*$allow_del=''; 
$db->query("USE ".$EWT_DB_NAME);

$allow_del_sql = "SELECT * 
				  FROM block 
				  inner join block_function on block.BID = block_function.BID 
				  WHERE block_type ='survey' AND block_link = '{$a_survey[s_id]}'" ;
				  
      if($db->db_num_rows($db->query($allow_del_sql)) > 0){
		  
	      $allow_del='disabled title="แบบสอบถามนี้ถูกใช้อยู่ ไม่สามารถลบได้"';
		  
	  }	*/
	  $s_alldel = "SELECT * 
				  FROM p_survey 
				  WHERE s_approve = 'Y' AND ( '{$dn}' BETWEEN s_start AND s_end ) AND s_id = '{$a_survey[s_id]}'" ;
				  $q_alldel = $db->query($s_alldel);
				  $a_rows = $db->db_num_rows($q_alldel);
	  
?>
<input name="del<?=$i;?>" type="checkbox" id="del<?=$i;?>" value="<?=$a_survey['s_id'];?>" <?php if($a_rows > 0){ echo "disabled";}?> />
<input name="dbn<?=$i;?>" type="hidden" id="dbn<?=$i;?>" value="<?=$a_survey['s_table'];?>" />


</td>-->
<td class="text-left"> 
<nobr>
<a href="save_survey.php?s_id=<?=$a_survey['s_id']; ?>" data-toggle="tooltip" data-placement="right" title="<?=$lang_survey_app;?>" >
<!--<img src="../theme/main_theme/g_saveas.gif" width="16" height="16" border="0" align="absmiddle" alt="<?=$lang_survey_app; ?>">-->
<button type="button" class="btn btn-info btn-circle  btn-xs " >
<i class="fas fa-clone" aria-hidden="true"></i>
</button>
</a> 

<a href="edit_survey.php?s_id=<?=$a_survey['s_id']; ?>" data-toggle="tooltip" data-placement="right" title="<?=$lang_survey_edit;?>">
<button type="button" class="btn btn-warning  btn-circle  btn-xs " >
<i class="fas fa-edit" aria-hidden="true"></i>
</button>
<!-- <img src="../theme/main_theme/g_edit.gif" width="16" height="16" border="0" align="absmiddle" alt="<?//=$lang_survey_edit; ?>">-->
</a>
	  
<?php if($a_survey['s_approve']=="Y"){ ?>
<a  onclick="boxPopup('<?=linkboxPopup();?>pop_view_survey.php?s_id=<?=$a_survey['s_id']; ?>');" _onClick="window.open('view_survey.php?s_id=<?=$a_survey['s_id']; ?>','newwin','scrollbars=yes,resizable=yes,width=650,height=500');" data-toggle="tooltip" data-placement="right" title="<?=$lang_survey_result1;?>">
<button type="button" class="btn btn-success btn-circle  btn-xs " >
<i class="fas fa-search" aria-hidden="true"></i>
</button>
<!--<img src="../theme/main_theme/g_view.gif" width="16" height="16" border="0" align="absmiddle" alt="<?=$lang_survey_result1;?>">-->
</a> 
<?php } ?>
<?php if($a_survey['s_approve']=="N"){ ?>
<a href="#app" onClick="JQApprove_Survey('<?=$a_survey['s_id'];?>');" data-toggle="tooltip" data-placement="right" title="<?=$lang_survey_approve2;?>">
<button type="button" class="btn btn-info btn-circle  btn-xs " >
<i class="fas fa-cogs" aria-hidden="true"></i>
</button>
<!--<img src="../theme/main_theme/g_approve.gif" width="16" height="16" border="0" align="absmiddle" alt="<?=$lang_survey_approve2; ?>" >-->
</a> 
<?php } ?>

<a href="#app" data-toggle="tooltip" data-placement="right" title="<?=$lang_survey_group;?>" onClick="win3=window.open('site_s_member.php?ug=<?=$a_survey['s_id']; ?>','users','width=600,height=400,scrollbars=1,resizable=1');win3.focus();">
<button type="button" class="btn btn-default btn-circle btn-xs" >
<i class="fa fa-user-cog" aria-hidden="true"></i>
</button>
<!--<img src="../theme/main_theme/g_group.gif" width="16" height="16" border="0" align="absmiddle" alt="<?=$lang_survey_group; ?>" onClick="win3=window.open('site_s_member.php?ug=<?=$a_survey['s_id']; ?>','users','width=600,height=400,scrollbars=1,resizable=1');win3.focus();">-->
</a>
		
<?php if($a_survey['s_approve'] != "N"){ ?>
<a href="survey_question.php?s_id=<?=$a_survey['s_id']; ?>&su_id=0" target="_blank" data-toggle="tooltip" data-placement="right" title="<?="Export PDF";?>">
<button type="button" class="btn btn-danger btn-circle   btn-xs " >
<i class="fa fa-file-pdf fa-1x" aria-hidden="true"></i>
</button>
<!--<img src="../theme/main_theme/g_view_bk.gif" width="16" height="16" border="0" align="absmiddle" alt="<?php echo 'Question' ?>"    >-->
</a>
<?php } ?>
<a href="#delete" onClick="JQDelete_Survey('<?=$a_survey['s_id'];?>');" data-toggle="tooltip" data-placement="right" title="<?="ลบ";?>">
<button type="button" class="btn btn-danger btn-circle  btn-xs " >
<i class="fas fa-trash-alt fa-1x" aria-hidden="true" ></i>
</button>
</a> 
</nobr>
</td>
</tr>
<?php
$i++;
   } 
?>
<!--<tr bgcolor="#FFFFFF"> 
<td colspan="9">&nbsp;</td>
<td>
<input name="Flag" type="hidden" id="Flag2" value="DROP">
<input name="all" type="hidden" id="all2" value="<?=$i;?>">
<a href="#app" onClick=" JQDelete_Survey('<?=$a_survey['s_id']; ?>');" data-toggle="tooltip" data-placement="right" title="<?=$lang_survey_approve2;?>" >
<button type="button" class="btn btn-danger  btn-ml " _onClick="if(confirm('Are you sure to delete selected form generator?')){ form1.submit(); }" >
<i class="fa fa-trash-alt" aria-hidden="true"></i>&nbsp;<?=$lang_survey_delete; ?>
</button> 
</a>
</td>
</tr>-->
<?php }else{ ?>
<tr bgcolor="#FFFFFF"> 
<td colspan="11"><p class="text-center text-danger"><?php echo $lang_survey_nodata; ?></p></td>
</tr>
<?php } ?>
<tbody>
</table>
</div>
</form>

</div>

<?=pagination($statement,$per_page,$page,$url='?');?>


</div>
</div>
</div>
<div id="box_popup" class="layer-modal"></div>
<?php
include('footer.php');
?>

</body>
</html>
<?php $db->db_close(); ?>