<?php
include("../EWT_ADMIN/comtop_pop.php");
?>

<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_add_complain_form')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Add_Cate">

<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x color-white"></i></button>
<h4 class="modal-title color-white"> <?php echo $txt_complain_add_form;?></h4>
</div>

<div class="modal-body">

<div class="card ">
<div class="scrollbar scrollbar-near-moon thin">
<div class="card-header  m-b-sm" >
<div class="card-title text-left"><b></b></div>
</div>

<div class="card-body" >

<div class="form-group row " >
<label for="com_form_title" class="col-sm-12 control-label"><b><?php echo $txt_complain_form_title;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input class="form-control" placeholder="<?php echo $txt_complain_form_title;?>" name="com_form_title" type="text" id="com_form_title"  value="" required="required" />
</div>
</div>
<div class="form-group row " >
<label for="com_form_type" class="col-sm-12 control-label"><b><?php echo $txt_complain_form_type;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="radio">
  <label><input type="radio" name="com_form_type" id="ck_form_type0"  value="0" <?php echo 'checked="checked"';?> onclick="JQCheck_Cate($('#ck_form_type0'));"/><?php echo $txt_complain_form_type_0;?>
  <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
  </label>
</div>
<div class="radio">
  <label><input type="radio" name="com_form_type"  id="ck_form_type1"  value="1" onclick="JQCheck_Cate($('#ck_form_type1'));"  /><?php echo $txt_complain_form_type_1;?>
  <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
  </label>
</div>
</div>
</div>

<div class="form-group row " id='show_complain_category' style="display:none;" >
<label for="complain_category" class="col-sm-12 control-label"><b><?php echo $txt_complain_hidden_cate;?> <span class="text-danger"><code>*</code></span> :</label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<select name="complain_category" id="complain_category" class="form-control" disabled >
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
</div>
</div>

</div>
</div>	
</div>
		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQAdd_Complain_Form($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?php echo $txt_ewt_save;?>
</button>
</div>
</div>
</div>

</div>
 
</div>
</div>	 
</form>

<script> 

function JQCheck_Cate(form){
	var name  = form.attr('name'); 
	var type_data = $('input:radio[name='+name+']:checked').val();
	
	if(type_data == '0'){
		$('#show_complain_category').hide();
		$('#complain_category').attr("disabled",true);
		$('#complain_category').attr("required",false);
		}else{
			$('#show_complain_category').show();
			$('#complain_category').attr("disabled",false);
			$('#complain_category').attr("required",true);
		}	
	console.log(type_data);
}
 
function JQAdd_Complain_Form(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: '<?php echo $txt_complain_add_form;?>',
						content: 'คุณต้องการบันทึกข้อมูลนี้หรือไม่',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'far fa-question-circle',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: 'ยืนยันการบันทึก',
									btnClass: 'btn-blue',
									action: function () {
										$.ajax({
											type: method,
											url: action,					
											data: formData ? formData : form.serialize(),
											async: true,
											processData: false,
											contentType: false,
											success: function (data) {												
												console.log(data);
												$.alert({
													title: '',
													theme: 'modern',
													content: 'บันทึกข้อมูลเรียบร้อย',
													boxWidth: '30%',
													onAction: function () {
														self.location.href="complain_builder.php?com_fid="+data;			
														//location.reload(true);			
														//$('#box_popup').fadeOut();
													}		
												});
												//$("#frm_edit_s").load(location.href + " #frm_edit_s");
												//alert("Data Save: " + data);												
												//self.location.href="complain_builder.php?com_cid="+data;											
												//$('#box_popup').fadeOut();
												
											}
										});																										
									}								
							
								},
								cancel: {
									text: 'ยกเลิก',
									action: function () {
									//$('#box_popup').fadeOut(); 	
									}									
								}
							},                          
                            animation: 'scale',
                            type: 'blue'
						
						});
					} 
								
}
</script>