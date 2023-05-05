<?php
include("../EWT_ADMIN/comtop_pop.php");

$faq_cid = $_GET['faq_cid'];
$_sql = $db->query("SELECT * FROM faq_category  WHERE  faq_cate_id = '{$faq_cid}' ");
$a_data = $db->db_fetch_array($_sql);
?>
<form id="form_main" name="form_main" method="POST" action="<?=getLocation('func_edit_faq_group')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Edit_Cate">
<input type="hidden" name="category_id" id="category_id"  value="<?=$a_data['faq_cate_id'];?>" >
<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x color-white"></i></button>
<h4 class="modal-title  color-white"><i class="fas fa-plus-circle"></i> <?=$txt_faq_cate_edit;?></h4>
</div>
<div class="modal-body">
<div class="card ">
<div class="scrollbar scrollbar-near-moon thin">

<div class="card-body" >

<div class="form-group row " >
<label for="category_title" class="col-sm-12 control-label"><b><?=$txt_faq_cate_name;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input class="form-control" placeholder="<?=$txt_faq_cate_name;?>" name="category_title" type="text" id="category_title"  value="<?=$a_data['faq_cate_title'];?>" >
</div>
</div>
<!-- <div class="form-group row " >
 <label for="category_detail" class="col-sm-12 control-label"><b><?=$txt_faq_cate_detail;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<textarea class="form-control" placeholder="<?=$txt_faq_cate_detail;?>"  rows="5" id="category_detail" name="category_detail"  ><?=$a_data['faq_cate_detail'];?></textarea>
</div> 
</div> -->
<div class="form-group row " >
<label for="category_sub" class="col-sm-12 control-label"></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="checkbox">
          <label>
			<input onclick="JQCheck_Cate($('#faq_cate_subcheck'));" name="faq_cate_subcheck" id="faq_cate_subcheck" type="checkbox" value="Y" <?php if($a_data['faq_cate_status_parent'] == 'Y'){ echo 'checked="checked"';} ?>>
            <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
           <b><?="Creating a sub-category";?> :</b>
          </label>
</div>
<select name="category_parent" id="category_parent" class="form-control" <?php if($a_data['faq_cate_status_parent'] == 'N' OR $a_data['faq_cate_status_parent'] == ''){ echo "disabled"; } ?>  >
<option value=""selected="" disabled="disabled" ><?=$txt_faq_cate_select;?></option> 
 <?php
$_sql_faq = $db->query("SELECT faq_cate_id,faq_cate_title,faq_cate_parent FROM faq_category WHERE faq_cate_status = 'Y' ORDER BY faq_cate_order ASC,faq_cate_id ASC ");
while($a_data_faq = $db->db_fetch_row($_sql_faq)){
	$sel = ($a_data_faq[0] == trim($a_data['faq_cate_parent'])) ? "selected":"";
	if($a_data_faq[2] != '0'){
		$nbsp = "&nbsp;&nbsp;&nbsp;";
	}else{
		$nbsp = "";
	}
?>
<option value="<?=$a_data_faq[0];?>" <?=$sel;?> ><?=$nbsp.$a_data_faq[1];?></option>
<?php
}
?>		  
</select>
</div>
</div>
<div class="form-group row " >
<label for="category_order" class="col-sm-12 control-label"><b><?=$txt_faq_cate_order;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-2 col-sm-2 col-xs-12" >
<input class="form-control" placeholder="<?=$txt_faq_cate_order;?>" name="category_order" type="text" id="category_order"  value="<?=$a_data['faq_cate_order'];?>" >
</div>
</div>
</div>

</div>	
</div>
		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQEdit_faq_group($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?=$txt_ewt_save;?>
</button>
</div>
</div>
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

function JQCheck_Cate(form){
	var name  = form.attr('name'); 
	var check = $('input:checkbox[name='+name+']:checked').val();	
	if(check == 'Y'){
		$('#category_parent').attr("disabled",false);
		}else{
			$('#category_parent').attr("disabled",true);
		}	
	console.log(check);
}
</script>