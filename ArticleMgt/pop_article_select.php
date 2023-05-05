<?php
include("../EWT_ADMIN/comtop_pop.php");

function countparent($c){
global $db,$ptype,$ppms1,$ppms2,$y,$EWT_DB_USER;
$ptype = "Ag";
$ppms1 = "w";
$ppms2 = "a";

$sql = $db->query_db("SELECT c_parent FROM article_group WHERE c_id = '$c'   ",$_SESSION["EWT_SDB"]);
  while($U = $db->db_fetch_array($sql)){
	$c = countparent($U["c_parent"]);
	$y += $c;
	$sql2 = $db->query_db("SELECT s_id FROM permission WHERE p_type = 'U' AND pu_id = '".$_SESSION["EWT_SMID"]."' AND UID = '".$_SESSION["EWT_SUID"]."' 
	AND   (s_type = '".$ptype."' AND s_permission = '".$ppms1."'  AND s_id = '".$U["c_parent"]."' )   ",$EWT_DB_USER);
	if($db->db_num_rows($sql2) > 0){
	$y++;
	}
  }
  return $y;
}

if($db->check_permission('Ag','w',"0")){
  //$sql_article = $db->query_db("SELECT * FROM article_group WHERE c_parent = '0' ORDER BY c_id ASC",$_SESSION["EWT_SDB"]);
  $sql = $db->query_db("SELECT * FROM article_group WHERE c_parent = '0' ORDER BY c_id ASC ",$_SESSION["EWT_SDB"]);
}else{
		$sql_supadmin = $db->query_db("SELECT s_id FROM permission WHERE p_type = 'U' AND pu_id = '".$_SESSION["EWT_SMID"]."' AND UID = '".$_SESSION["EWT_SUID"]."'  AND (s_type = 'Ag' AND s_permission = 'w'  AND s_id != '0' )   ",$EWT_DB_USER);
		
			 $sql_text = "WHERE ( 0 ";
			while($G = $db->db_fetch_row($sql_supadmin)){
			$y = 0;
				if(countparent($G[0]) == 0){
				$sql_text .= " OR c_id = '".$G[0]."' ";
				}
			}
			$sql_text .= " ) ";
		//$sql_group = $db->query_db("SELECT * FROM gallery_category ".$sql_text." ORDER BY category_id ASC ",$_SESSION["EWT_SDB"]);
		$sql = $db->query_db("SELECT * FROM article_group  ".$sql_text." ORDER BY c_id ASC",$_SESSION["EWT_SDB"]);
}

function GenPic($data){
	for($i=0;$i<$data;$i++){
		echo "<img src=\"../images/o.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\">";
	}
}

function child($c,$x,$decho){
global $db,$i,$txt;
$y = $x+1;
$sql = $db->query_db("SELECT * FROM article_group WHERE c_parent = '$c' ORDER BY c_id ASC ",$_SESSION["EWT_SDB"]);
  while($U = $db->db_fetch_array($sql)){
  ?>
<div class="col-md-12 col-sm-12 col-xs-12 text-left">
<img src="../images/o.gif" width="20" height="20" border="0" align="absmiddle"><?php GenPic($y); ?>
<a class="pointer" onClick="JQarticle_group('<?=$U['c_id'];?>','<?=$U['c_name'];?>');$('#box_popup').fadeOut();">
	<?php if($y>=1 and $y<10){?>
	<img src="../images/folder_closed<?php echo $y;?>.gif" width="16" height="16" border="0" align="absmiddle">
	<?php }else{?>
	<img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle">
	<?php }?>
 <?=$U['c_name'];?>
 </a>
</div>
    <?php
	$i++; 
	child($U["c_id"],$y,$decho);
  }
}
?>

<form id="form_main" name="form_main" method="POST" action="<?=getLocation('func_add_faq_group')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Add_Cate">

<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x"></i></button>
<h4 class="modal-title"> <?="Article Group";?></h4>
</div>

<div class="modal-body">

<div class="card ">
<div class="scrollbar scrollbar-near-moon thin">
<div class="card-header ewt-bg-success m-b-sm" >
<div class="card-title text-left"><b></b></div>
</div>

<div class="card-body" >
<?php
$i=1;
$txt = "";
	while($U = $db->db_fetch_array($sql)){
?>
<div class="col-md-12 col-sm-12 col-xs-12 text-left">
<img src="../images/o.gif" width="20" height="20" border="0" align="absmiddle">
<a class="pointer" onClick="JQarticle_group('<?=$U['c_id'];?>','<?=$U['c_name'];?>');$('#box_popup').fadeOut();">
<img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle">&nbsp; 
<?php echo $U['c_name']; ?>
</a>
</div>
<?php 
	$i++;
	child($U['c_id'],0,$decho);
 }
?>	

</div>
</div>
</div>
	
</div>
		
<div class="modal-footer ">
<!--<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQAdd_faq_group($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?="บันทึก";?>
</button>
</div>-->
</div>
</div>

</div>
 
</div>	 
</form>
	
<script>  
$(document).ready(function() {
 var today = new Date();
 $('.datepicker')		
        .datepicker({
            format: 'dd/mm/yyyy',
            language: 'th-th',
			thaiyear: true,
			leftArrow: '<i class="fas fa-angle-double-left"></i>',
            rightArrow: '<i class="fas fa-angle-double-right"></i>',
        })
		//.datepicker("setDate", "0"); 
		//.datepicker("setDate", today.toLocaleDateString());  	
});

function JQarticle_group(cid,cname){
	//alert(cname);
	document.getElementById('cid').value = cid;
	document.getElementById('txtshow').innerHTML = cname;
	
}

function JQCheck_Cate(form){
	var name  = form.attr('name'); 
	var check = $('input:checkbox[name='+name+']:checked').val();	
	if(check == 'Y'){
		$('#category_parent').attr("disabled",false);
		$('#category_parent').attr("required",false);
		}else{
			$('#category_parent').attr("disabled",true);
			$('#category_parent').attr("required",true);
		}	
	console.log(check);
}
</script>