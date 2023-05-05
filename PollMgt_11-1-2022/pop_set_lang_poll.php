<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
include("../language/language_TH.php");
include("../lib/config_path.php");

$id = (int)(!isset($_GET['id']) ? '' : $_GET['id']);

$s_lang_config = $db->query("SELECT lang_config_name,lang_config_id,lang_config_suffix,lang_config_img 
		FROM lang_config 
		WHERE lang_config_status = 'O'");

$a_rows = $db->db_num_rows($s_lang_config);
$Globals_Dir = '../ewt/'.$EWT_FOLDER_USER;
$Globals_Dir1 = 'language';	
?>	
<form action="" method="post" enctype="multipart/form-data" name="form" >
<div class="dContainer" >   
<div class="modal-dialog modal-ml">

<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" onclick="$('#box_popup').fadeOut()" ><i class="far fa-times-circle fa-1x"></i></button>
<h4 class="modal-title"><?=$txt_ewt_multilang;?> </h4>
</div>

<div class="modal-body">
<?="เลือกภาษา...";?>
<div class="form-group row" >
<div class="col-md-12 col-sm-12 col-xs-12">
<table width="100%" >
<?php
for($i=1;$i<=$a_rows;$i++){
	$a_data = $db->db_fetch_array($s_lang_config);	
	$s_status = set_lang_use($_GET['id'],$a_data['lang_config_id'],'poll');
	if($s_status == true){
		$disabled = 'disabled';
		}else{
			$disabled = '';
		}
		if($i%6 == 0 && $i==1) { 
			echo " <tr>"; 
			}
?>
<td class="text-center">
<button  type="button" class="btn btn-default  btn-ml" <?=$disabled?> data-toggle="tooltip" data-placement="top" title="<?=$a_data['lang_config_name'];?>" onClick="JQAdd_Lang_Poll('<?=$id;?>','<?=$a_data['lang_config_id'];?>','<?=$a_data['lang_config_suffix'];?>');" >
<?php if($a_data['lang_config_img'] != ''){ ?>
<img src="<?=$Globals_Dir.'/'.$Globals_Dir1.'/'.$a_data['lang_config_img'];?>" border="0" />
<?php } ?>
<?=$a_data['lang_config_suffix'];?>
</button>
</td>
<?php
		if($i%6 == 0 ) { 
			 echo "</tr>";
			}
		}
?>
</table>
</div>
</div>	
</div>
		
        <div class="modal-footer">
        </div>
      </div>
	 
    </div>
 </div>	 
 </form>	
<script>  
$(document).ready(function(){
	
    $('[data-toggle="tooltip"]').tooltip();   
	
});
</script>