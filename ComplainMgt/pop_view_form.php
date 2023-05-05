<?php
include("../EWT_ADMIN/comtop_pop.php");

$com_fid = (int)(!isset($_GET['com_fid']) ? 0 : $_GET['com_fid']);

function complain_form($com_fid){
	 global $db,$EWT_DB_NAME;
	 $s_category = $db->query("SELECT * FROM m_complain_form WHERE com_form_id = '{$com_fid}' ");	
	 if($db->db_num_rows($s_category)){
		$a_category = $db->db_fetch_array($s_category);											
		$a_data = $a_category['com_form_title'];
			
	 	}		
		return $a_data;
}


$_sql = $db->query("SELECT *
					FROM m_complain_form_element 
					INNER JOIN m_complain_form_item ON (m_complain_form_item.com_item_id = m_complain_form_element.com_ele_id)
					WHERE m_complain_form_element.com_ele_fid = '{$com_fid}'
					ORDER BY m_complain_form_element.com_ele_order ASC");
$a_rows = $db->db_num_rows($_sql);
?>
<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_add_faq')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Edit_Faq">

<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6 ">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x color-white"></i></button>
<h4 class="modal-title color-white"><?php //echo $txt_complain_cate_builder;?><?php echo complain_form($com_fid);?></h4>
</div>

<div class="modal-body">

<div class="card ">
<div class="scrollbar scrollbar-near-moon thin">
<div class="card-header  m-b-sm " >
<!--<div class="card-title text-left"><b><?php //echo complain_form($com_fid);?></b></div>-->
</div>

<div class="card-body" >

<?php
if($a_rows > 0){
$i = 0;
while($a_data = $db->db_fetch_array($_sql)){
	echo $a_data['com_item_type'];	
$_sql_info = $db->query("SELECT * FROM  m_complain_form_info WHERE m_complain_form_info.com_ele_fid = '{$a_data['com_ele_fid']}' AND m_complain_form_info.com_ele_id = '{$a_data['com_ele_id']}' ");			  
$a_data_info = $db->db_fetch_array($_sql_info);

if(!empty($a_data_info['com_info_label'])){	
	$com_item_title = $a_data_info['com_info_label'];	
}else{	
	$com_item_title = $a_data['com_item_title'];	
}	
$com_info_required = $a_data_info['com_info_required'];
$com_info_help = $a_data_info['com_info_help'];

if($a_data['com_item_type'] == 'text'){
		
?>
<div class="form-group row " >
<label for="<?php echo $a_data['com_item_name'];?>" class="col-sm-12 control-label"><b><?php echo $com_item_title;?> <?php if($com_info_required == 'Y'){ echo '<span class="text-danger"><code>*</code></span>'; }?> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input class="form-control" placeholder="<?php echo $com_item_title;?>" name="<?php echo $a_data['com_item_name'];?>" type="text" id="<?php echo $a_data['com_item_name'];?>"  value="" 	<?php if($com_info_required == 'Y'){ echo 'required="required"'; }?> />
<?php 
if(isset($com_info_help)){
	echo '<span class="text-danger">'.$com_info_help.'</span>';
}?>
</div>
</div>

<?php }else if($a_data['com_item_type'] == 'textarea'){
		
?>

<div class="form-group row " >
<label for="<?php echo $a_data['com_item_name'];?>" class="col-sm-12 control-label"><b><?php echo $com_item_title;?> <?php if($com_info_required == 'Y'){ echo '<span class="text-danger"><code>*</code></span>'; }?> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<textarea class="form-control" placeholder="<?php echo $com_item_title;?>"  rows="6" id="<?php echo $a_data['com_item_name'];?>" name="<?php echo $a_data['com_item_name'];?>"  <?php if($com_info_required == 'Y'){ echo 'required="required"';} ?> ></textarea>
<?php 
if(isset($com_info_help)){
	echo '<span class="text-danger">'.$com_info_help.'</span>';
}?>
</div>
</div>

<?php }else if($a_data['com_item_type'] == 'select'){ ?>

<div class="form-group row "  >
<label for="<?php echo $a_data['com_item_name'];?>" class="col-sm-12 control-label"><b><?php echo $com_item_title;?> <?php if($com_info_required == 'Y'){ echo '<span class="text-danger"><code>*</code></span>'; }?> : </b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<select name="<?php echo $a_data['com_item_name'];?>" id="<?php echo $a_data['com_item_name'];?>" class="form-control"  >
<option value=""selected="" disabled="disabled" ><?php echo $txt_complain_select_cate;?></option> 
<?php
$_sql_faq = $db->query("SELECT 
Complain_lead_ID,
Complain_lead_name
FROM m_complain_info 
WHERE Complain_status_use != 'N'
ORDER BY Complain_lead_ID ASC ");
while($a_data_faq = $db->db_fetch_row($_sql_faq)){
	$sel = ($a_data_faq[0] == trim($faq_cid)) ? "selected":"";
?>
<option value="<?php echo $a_data_faq[0];?>" <?php echo $sel;?> ><?php echo $a_data_faq[1];?></option>
<?php
	}
?>		  
</select>
<?php 
if(isset($com_info_help)){
	echo '<span class="text-danger">'.$com_info_help.'</span>';
}?>
</div>
</div>
<?php }else if($a_data['com_item_type'] == 'file'){ ?>

<div class="form-group row "  >
<label for="<?php echo $a_data['com_item_name'];?>" class="col-sm-12 control-label"><b><?php echo $com_item_title;?> <?php if($com_info_required == 'Y'){ echo '<span class="text-danger"><code>*</code></span>'; }?> : </b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input placeholder="<?php echo $com_item_title;?>"  name="<?php echo $a_data['com_item_name'];?>" id="<?php echo $a_data['com_item_name'];?>" type="file"  class="form-control"  <?php if($com_info_required == 'Y'){ echo 'required="required"'; }?> /> 
<?php 
if(isset($com_info_help)){
	echo '<span class="text-danger">'.$com_info_help.'</span>';
}?>
</div>
</div>

<?php }else{ ?>

<div class="form-group row " >
<label for="<?php echo $a_data['com_item_name'];?>" class="col-sm-12 control-label"><b><?php echo $com_item_title;?> <?php if($com_info_required == 'Y'){ echo '<span class="text-danger"><code>*</code></span>'; } ?> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input class="form-control" placeholder="<?php echo $com_item_title;?>" name="<?php echo $a_data['com_item_name'];?>" type="text" id="<?php echo $a_data['com_item_name'];?>"  value="" <?php if($com_info_required == 'Y'){ echo 'required="required"'; }?> />
<?php 
if(isset($com_info_help)){
	echo '<span class="text-danger">'.$com_info_help.'</span>';
}?>
</div>
</div>		
	
	<?php } } }  ?>	



</div>
</div>	
</div>
		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="$('#box_popup').fadeOut();" type="button" class="btn btn-danger  btn-ml " >
<i class="far fa-times-circle fa-1x"></i>&nbsp;<?php echo $txt_ewt_close;?>
</button>
</div>
</div>
</div>

</div>
 
</div>
</div>	 
</form>
<!-- Custom js -->
<script type="text/javascript" src="<?php echo $IMG_PATH;?>assets/js/custom.js"></script>	
<script>  

function JQCheck_Cate(form){
	var name  = form.attr('name'); 
	var check = $('input:checkbox[name='+name+']:checked').val();	
	if(check == 'Y'){
		$('#category_sub').attr("disabled",false);
		}else{
			$('#category_sub').attr("disabled",true);
		}	
	console.log(check);
}
</script>