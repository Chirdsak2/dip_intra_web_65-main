<?php
$s_data = array();
$_sql = $db->query("SELECT *
					FROM permission 
					WHERE pu_id = '{$pu_id}' AND p_type = 'U' AND s_type = 'Ag'  AND UID = '{$UID}' AND s_permission = '{$p_type}' AND s_id != '0' AND s_name = ''
					ORDER BY p_id ASC ");
$a_rows = $db->db_num_rows($_sql);	
while($a_data = $db->db_fetch_array($_sql)){
	array_push($s_data,$a_data['s_id']); 
}

$_sql_sup = $db->query("SELECT *
					FROM permission 
					WHERE pu_id = '{$pu_id}' AND p_type = 'U' AND s_type = 'Ag'  AND UID = '{$UID}' AND s_permission = '{$p_type}' AND s_id = '0' AND s_name = ''
					");
$a_rows_sup = $db->db_num_rows($_sql_sup);	
if($a_rows_sup > 0){ 

$supcheck = 'checked="checked"';

}

//print_r($s_data);
$db->query("USE ".$EWT_DB_NAME);


function cateList($s_id){	
	global $db,$s_data,$a_rows_sup;			 
				$s_sql = $db->query("SELECT c_id,c_name FROM article_group WHERE c_parent = '{$s_id}' ");
				$a_rows = $db->db_num_rows($s_sql);
echo '<ul>';
	
	if($a_rows){
		
				while($_item = $db->db_fetch_array($s_sql)){
					if($a_rows_sup == 0){
					$s_chk = (in_array($_item['c_id'], $s_data))?' checked="checked"':'';
						unset($s_data[$_item['c_id']]);	  
					}else{	
						$s_chk = 'checked="checked"';
						}
			
echo '<li>';
echo '<div class="checkbox">&nbsp;&nbsp;';
echo '<label>';
echo '<input type="checkbox" '.$s_chk.' id="c_cate'.$_item['c_id'].'" name="c_cate['.$_item['c_id'].']"  value="'.$_item['c_id'].'" />';
echo '<span class="cr1"><i class="cr-icon fas fa-check color-ewt"></i></span>&nbsp;<b>&nbsp;'.$_item['c_name'].'</b>';
echo '</label>';
echo '</div>';
	     cateList($_item['c_id']);		
echo '</li>';				
						
				}
				
			 }
	echo '</ul>';		 
	
		}
?>

<input type="hidden" name="proc" id="proc"  value="Add_Admission_Article">
<input type="hidden" name="p_type" id="p_type"  value="<?=$p_type;?>">
<input type="hidden" name="p_code" id="p_code"  value="<?=$s_type;?>">
<input type="hidden" name="code" id="code"  value="Ag">
<div class="card ">
<div class="card-header" >
<div class="form-inline text-danger ">คำชี้แจง : เลือก
<div class="checkbox">
		<label>
		<input name="1" id="1" type="checkbox" value="0" checked />
        <span class="cr1" ><i class="cr-icon fas fa-check color-ewt"></i></span>
        </label></div>หมวดข่าวที่ท่านต้องการที่จะให้สิทธิ์การเข้าถึงแก่ผู้ใช้งานระบบ
</div>
</div>
<div class="scrollbar scrollbar-near-moon thin">
<div class="card-body" >

<!--<ul id="sortableLv1" class="sortableLv1 connectedSortable " style="width: 100%;">
<li class="productCategoryLevel1 ewt-bg-color ui-state-disabled text-left " id="0" >

<div class="checkbox">&nbsp;&nbsp;
          <label>
			<input name="chk" id="chk0"  type="checkbox" value="0" <?=$check;?> _onClick="chkdis(this,'0',0,<?=$numfolder?>);" />
            <span class="cr1" ><i class="cr-icon fas fa-check color-white"></i></span>&nbsp;<b class="text-white"> <i class="fas fa-folder"></i> All Group</b>
          </label>
</div>
</li>
</ul>-->



<ul id="ditp_tree" class="demo1"  style="width: 100%;">

<li class="expanded " data-value="0" >
<div class="checkbox">&nbsp;&nbsp;
          <label>
			<input name="chk" id="chk"  type="checkbox" value="0" <?=$supcheck;?>  />
            <span class="cr1" ><i class="cr-icon fas fa-check color-ewt"></i></span>&nbsp;<b > <i class="fas fa-folder"></i> All Group</b>
          </label>
</div>
<ul>

<?php
$s_group = $db->query("SELECT * FROM  article_group WHERE c_parent = '0' ");
$a_rows = $db->db_num_rows($s_group);
if($a_rows){
while($_item = $db->db_fetch_array($s_group)){
	if($a_rows_sup == 0){
	 $s_chk = (in_array($_item['c_id'], $s_data))?' checked="checked"':'';
	  unset($s_data[$_item['c_id']]);
	  
	}else{
		
		$s_chk = 'checked="checked"';
	}
?>
<li>
<div class="checkbox">&nbsp;&nbsp;
<label>
<input type="checkbox" <?=$s_chk; ?>  id="c_cate<?php echo $_item['c_id']; ?>" name="c_cate[<?php echo $_item['c_id']; ?>]"  value="<?php echo $_item['c_id']; ?>" />
<span class="cr1"><i class="cr-icon fas fa-check color-ewt"></i></span>&nbsp;<b> <?php echo $_item['c_name']; ?></b>
</label>
</div>

<?php cateList($_item['c_id']);  ?>

</li>

<?php
      }
}

?>
</ul>
</li>
</ul>



</div>
</div>	
</div>

<script src="../js/Tree-Generator-jQuery-Bonsai/jquery.qubit.js"></script>
<link href="../js/Tree-Generator-jQuery-Bonsai/jquery.bonsai.css" rel="stylesheet">
<script src="../js/Tree-Generator-jQuery-Bonsai/jquery.bonsai.js"></script>

<!--<script type='text/javascript' src='../js/jquery-ui-1.10.3.custom/js/jquery-1.9.1.js'></script>
<script type='text/javascript' src='../js/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js'></script>
<link rel="stylesheet" type="text/css" href="../js/jquery-ui-1.10.3.custom/development-bundle/themes/base/jquery-ui.css" media="all" />-->
<script>

//$('#ditp_tree').bonsai();
$('#ditp_tree').bonsai({
  expandAll: true,
  checkboxes: true // depends on jquery.qubit plugin
  //createInputs: 'checkbox' // takes values from data-name and data-value, and data-name is inherited
});
$(document).ready(function() {
	$('#chk0').change(function () {
		var name  = $(this).attr('name'); 
		$('input:checkbox[name='+name+']').prop('checked',$(this).prop('checked'));	
		
		if($( this ).is(':checked') == true){
		$('input:checkbox[name='+name+']:checked').attr("disabled",true);
		$('#chk0').attr("disabled",false);
			}else if($( this ).is(':checked') == false){
				$('input:checkbox[name='+name+']').attr("disabled",false);
			}
		//console.log(v);
	});
		
/*jQuery("#ditp_tree ul").hide();	
$("#ditp_tree li").each(function() {
        var handleSpan = jQuery("<span></span>").addClass("handle").prependTo(this);

        if(jQuery("ul", this).size() > 0) {
            handleSpan.addClass("collapsed").click(function() {
                jQuery(this).toggleClass("expanded").siblings("ul").toggle();
            });
        }
    });*/
	
 });
</script>
<style>

</style>