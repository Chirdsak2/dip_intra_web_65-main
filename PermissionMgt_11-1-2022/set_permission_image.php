<?php
$s_data = array();
$_sql = $db->query("SELECT *
					FROM permission 
					WHERE pu_id = '{$pu_id}' AND p_type = 'U' AND s_type = 'imgFo'  AND UID = '{$UID}' AND s_permission = '{$p_type}' AND s_id = '0' AND s_name != ''
					ORDER BY p_id ASC ");
$a_rows = $db->db_num_rows($_sql);	
while($a_data = $db->db_fetch_array($_sql)){
	array_push($s_data,$a_data['s_name']); 
}

$_sql_sup = $db->query("SELECT *
					FROM permission 
					WHERE pu_id = '{$pu_id}' AND p_type = 'U' AND s_type = 'imgFo'  AND UID = '{$UID}' AND s_permission = '{$p_type}' AND s_id = '0' AND s_name = ''
					");
$a_rows_sup = $db->db_num_rows($_sql_sup);	
	if($a_rows_sup > 0){ 
	$supcheck = 'checked="checked"';
	}
//print_r($s_data);

$ptype = "imgFo";
$ppms = "w";

$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/images";
$folder = base64_decode($_REQUEST["myfolder"]);
$Current_Dir = $Globals_Dir."/".$folder;
//echo $Current_Dir;
if (!(file_exists($Current_Dir))) {
$Current_Dir = $Globals_Dir;
}

$array_folder = array();
$objFolder = opendir($Current_Dir);
rewinddir($objFolder);
$f = 0;

while($file = readdir($objFolder)){
			  if(!(($file == ".") or ($file == "..") or ($file == "Thumbs.db") )){
			  $FT= filetype($Current_Dir."/".$file);
			  if($FT == "dir"){
			  array_push ($array_folder,$file);
			  }else{
			  $array_file[$f][0] = $file;
				$f++;
			  }
			}
		}
closedir($objFolder);
$numfolder = count($array_folder);
?>

<input type="hidden" name="proc" id="proc"  value="Add_Admission_Article">
<input type="hidden" name="p_type" id="p_type"  value="<?=$p_type;?>">
<input type="hidden" name="p_code" id="p_code"  value="<?=$s_type;?>">
<input type="hidden" name="code" id="code"  value="<?=$ptype;?>">

<div class="card ">
<div class="card-header" >
<div class="form-inline text-danger ">คำชี้แจง : เลือก
<div class="checkbox">
		<label>
		<input name="1" id="1" type="checkbox" value="0" checked />
        <span class="cr1" ><i class="cr-icon fas fa-check color-ewt"></i></span>
        </label></div>โฟลเดอร์ ที่ท่านต้องการที่จะให้สิทธิ์การเข้าถึงแก่ผู้ใช้งานระบบ
</div>
</div>
<div class="scrollbar scrollbar-near-moon thin">
<div class="card-body" >

<? /*<ul id="sortableLv1" class="sortableLv1 connectedSortable " style="width: 100%;">
<li class="productCategoryLevel1 ewt-bg-color ui-state-disabled text-left " id="0" >

<div class="checkbox">&nbsp;&nbsp;
          <label>
			<input name="chk" id="chk0"  type="checkbox" value="0" <?=$check;?> _onClick="chkdis(this,'0',0,<?=$numfolder?>);" />
            <span class="cr1" ><i class="cr-icon fas fa-check color-white"></i></span>&nbsp;<b class="text-white"> <i class="fas fa-folder"></i> All Folder</b>
          </label>
</div>
</li>
</ul>
<ul id="sortableLv1-form" class="sortableLv1 connectedSortable " style="width: 100%;">
<?php
$i=1;
	for($y=0;$y<$numfolder;$y++){
		if($folder != ""){
			$preview_path = $folder."/".$array_folder[$y];
		}else{
			$preview_path = $array_folder[$y];
		}
		$preview_path_en = base64_encode($preview_path);
			
$sql_sadmin = $db->query_db("SELECT * 
FROM permission1 
WHERE p_type = '$mtype' 
AND pu_id = '$mid' 
AND UID = '$UID' 
AND s_type = '".$ptype."' 
AND s_permission = '".$ppms."'  
AND s_id = '0'  
AND s_name = '".$array_folder[$y]."' 
AND myFlag = '$myFlag' ",$EWT_DB_USER);

if($db->db_num_rows($sql_sadmin) > 0){
		$check = "checked";
	}else{
		$check = "";
	}
?>
<li class="productCategoryLevel1 ui-state-disabled text-left "  >
<div class="checkbox">&nbsp;&nbsp;
          <label>
			<input type="checkbox" name="c_cate[<?=$i;?>]" id="chk<?=$i;?>" _onClick="chkdis(this,'<?=$array_folder[$y]; ?>',<?=$i;?>,0);" value="<?=$array_folder[$y];?>" <?=$decho;?> <?=$check;?>>
            <span class="cr1"><i class="cr-icon fas fa-check color-ewt"></i></span>&nbsp;<b><i class="fas fa-folder"></i> <?=$array_folder[$y]; ?></b>
          </label>
</div>
</li>
<?php
 $i++; }
?>  
</ul>*/?>

<ul id="ditp_tree" class="demo1"  style="width: 100%;">

<li class="expanded " data-value="0" >
<div class="checkbox">&nbsp;&nbsp;
          <label>
			<input name="chk" id="chk"  type="checkbox" value="0" <?=$supcheck;?>  />
            <span class="cr1" ><i class="cr-icon fas fa-check color-ewt"></i></span>&nbsp;<b > <i class="fas fa-folder"></i> All Folder</b>
          </label>
</div>
<ul>
<?php
$i=1;
	for($y=0;$y<$numfolder;$y++){
		if($folder != ""){
			$preview_path = $folder."/".$array_folder[$y];
		}else{
			$preview_path = $array_folder[$y];
		}
		$preview_path_en = base64_encode($preview_path);
		
if($a_rows_sup == 0){
	  $s_chk = (in_array($array_folder[$y], $s_data))?' checked="checked"':'';
	  }else{		
		$s_chk = 'checked="checked"';
	}
?>
<li>
<div class="checkbox">&nbsp;&nbsp;
<label>
<input type="checkbox" <?=$s_chk; ?> name="c_cate[<?=$i;?>]" id="c_cate<?=$i;?>" _onClick="chkdis(this,'<?=$array_folder[$y]; ?>',<?=$i;?>,0);" value="<?=$array_folder[$y];?>" >

<span class="cr1"><i class="cr-icon fas fa-check color-ewt"></i></span>&nbsp;<b><i class="fas fa-folder"></i> <?=$array_folder[$y];?></b>
</label>
</div>

</li>

<?php
 $i++; }
?>
</ul>
</li>
</ul>

</div>
</div>
</div>	
</div>
<script src="../js/Tree-Generator-jQuery-Bonsai/jquery.qubit.js"></script>
<link href="../js/Tree-Generator-jQuery-Bonsai/jquery.bonsai.css" rel="stylesheet">
<script src="../js/Tree-Generator-jQuery-Bonsai/jquery.bonsai.js"></script>

<script>

//$('#ditp_tree').bonsai();
$('#ditp_tree').bonsai({
  expandAll: true,
  checkboxes: true // depends on jquery.qubit plugin
  //createInputs: 'checkbox' // takes values from data-name and data-value, and data-name is inherited
});
</script>