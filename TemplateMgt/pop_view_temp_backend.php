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

<form id="form_main" name="form_main" method="POST" action="<?=getLocation('func_add_org_list')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Add_Org">

<div class="container" >   
<div class="modal-dialog modal-lg"  >

<div class="modal-content ">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6" >
<button type="button" class="close" style="opacity: 0.9;" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x  color-white"></i></button>
<h4 class="modal-title color-white"> <i class="fas fa-search"></i> </h4>
</div>

<div class="modal-body">
<div class="scrollbar scrollbar-near-moon thin">



<div class="col-xs-12 col-sm-12 col-md-12 m-t-md">     
<div class="card ">
<div class="card-header m-b-sm visible-xs" >
<div class="card-title text-left"><b></b></div>
</div>
<div class="card-body" >

         
            </div>
        </div>
    </div>

</div>	
</div>
		
<!--<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQAdd_faq($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?//=$txt_ewt_save;?>
</button>
</div>
</div>-->

</div>

</div>
 
</div>
</div>	 
</form>
	
