<?php
include("../EWT_ADMIN/comtop_pop.php");

$u_id = (int)(!isset($_GET['u_id']) ? 0 : $_GET['u_id']);

$db->query("USE ".$EWT_DB_USER);
$s_sql = $db->query("SELECT *
		FROM `gen_user`
		LEFT JOIN `emp_type` ON (`gen_user`.`emp_type_id` = `emp_type`.`emp_type_id`)
		LEFT JOIN `org_name` ON (`gen_user`.`org_id` = `org_name`.`org_id`)  
		LEFT JOIN `position_name` ON (`gen_user`.`posittion` = `position_name`.`pos_id`)  
		WHERE `gen_user`.`gen_user_id` = '{$u_id}' ");
$a_data = $db->db_fetch_array($s_sql);		

$path_image = $a_data['path_image'];
$uploaddir = "../ewt/pic_upload/";
if($path_image != ''){
	$path_image22 = $uploaddir.$path_image;
	if(file_exists($path_image22)){
		$path_image2 = $path_image22;
		}else{
		$path_image2 = "../images/ImageFile.gif";
			}
	}else{
	$path_image2 = "../images/ImageFile.gif";
	}			
?>

<form id="form_main" name="form_main" method="POST" action="<?=getLocation('func_edit_temp_csscode')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Edit_csscode">

<div class="container" >   
<div class="modal-dialog modal-lg"  >

<div class="modal-content ">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6" >
<button type="button" class="close" style="opacity: 0.9;" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x  color-white"></i></button>
<h4 class="modal-title color-white"> <i class="fab fa-css3-alt " aria-hidden="true"></i> CSS Coding</h4>
</div>

<div class="modal-body">
<div class="scrollbar scrollbar-near-moon thin">



<div class="col-xs-12 col-sm-12 col-md-12 m-t-md">     

<textarea name="code"  id="code" class="lined" style="background-color: #000000;color:#FFFFFF">
<?php
$myfile = fopen("../Login/assets/css/style.css", "r") or die("Unable to open file!");
while(!feof($myfile)) {
  //$css .= fgets($myfile);
  echo html_entity_decode(fgets($myfile), ENT_QUOTES, "UTF-8");
}
fclose($myfile);
?>
<?//=html_entity_decode(fgets($myfile).'<br>', ENT_QUOTES, "UTF-8");?>
</textarea>      

</div>

</div>	
</div>
		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQEdit_Csscode($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?=$txt_ewt_save;?>
</button>
</div>
</div>

</div>

</div>
 
</div>
</div>	 
</form>
	<!-- Custom js -->
<script type="text/javascript" src="<?=$IMG_PATH;?>assets/js/custom.js"></script>
