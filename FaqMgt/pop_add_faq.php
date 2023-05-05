<?php
include("../EWT_ADMIN/comtop_pop.php");

$faq_cid = (int)(!isset($_GET['faq_cid']) ? 0 : $_GET['faq_cid']);
?>

<form id="form_main" name="form_main" method="POST" action="<?=getLocation('func_add_faq')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Add_Faq">

<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x color-white"></i></button>
<h4 class="modal-title  color-white"><i class="fas fa-plus-circle"></i> <?=$txt_faq_add;?></h4>
</div>
<div class="modal-body">

<div class="card ">
<div class="scrollbar scrollbar-near-moon thin">
<div class="card-body" >

<div class="form-group row " >
<label for="faq_title" class="col-sm-12 control-label"><b><?=$txt_faq_title;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<textarea class="form-control" placeholder="<?=$txt_faq_title;?>"  rows="6" id="faq_title" name="faq_title"  required="required" ></textarea>
</div>
</div>
<!-- <div class="form-group row " >
<label for="faq_detail" class="col-sm-12 control-label"><b><?=$txt_faq_detail;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<textarea class="form-control" placeholder="<?=$txt_faq_detail;?>"  rows="6" id="faq_detail" name="faq_detail"  required="required" ></textarea>
</div>
</div> -->
<div class="form-group row " >
<label for="faq_answer" class="col-sm-12 control-label"><b><?=$txt_faq_answer;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<textarea class="form-control" placeholder="<?=$txt_faq_answer;?>"  rows="6" id="faq_answer" name="faq_answer"  required="required" ></textarea>
</div>
</div>
<div class="form-group row " >
<label for="faq_category" class="col-sm-12 control-label"><b><?=$txt_faq_cate;?> <span class="text-danger"><code>*</code></span> :</label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<select name="faq_category" id="faq_category" class="form-control">
<option value=""selected="" disabled="disabled" ><?=$txt_faq_select_cate;?></option> 
<?php
$_sql_faq = $db->query("SELECT faq_cate_id,faq_cate_title 
FROM faq_category 
WHERE faq_cate_status = 'Y' 
ORDER BY faq_cate_order ASC,faq_cate_id ASC ");
while($a_data_faq = $db->db_fetch_row($_sql_faq)){
	$sel = ($a_data_faq[0] == trim($faq_cid)) ? "selected":"";
?>
<option value="<?=$a_data_faq[0];?>" <?=$sel;?> ><?=$a_data_faq[1];?></option>
<?php
	}
?>		  
</select>
</div>
</div>
<div class="form-group row " >
<label for="faq_show" class="col-sm-12 control-label"><b><?=$txt_faq_show;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="radio">
  <label><input type="radio" name="faq_show" value="Y" checked><?=$txt_faq_status_show;?>
  <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
  </label>
</div>
<div class="radio">
  <label><input type="radio" name="faq_show" value="N" ><?=$txt_faq_status_notshow;?>
  <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
  </label>
</div>
</div>
</div>

<div class="form-group row " >
<label for="faq_interesting" class="col-sm-12 control-label"><b><?=$txt_faq_interesting ;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="checkbox">
          <label>
			<input  name="faq_interesting" id="faq_interesting" type="checkbox" value="Y" >
            <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
			<?=$txt_faq_showinter;?>
          </label>
</div>
</div>
</div>

</div>
</div>	
</div>
		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQAdd_faq($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
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
  CKEDITOR.replace('faq_detail', {
		allowedContent: true,
	  	customConfig: '../../js/ckeditor/custom_config.js',
		on: {
        change: function( evt ) {
			var newContent = this.getData()			
				change_data('faq_detail',newContent);		   

				}
		}
  });
  CKEDITOR.replace('faq_answer', {
		allowedContent: true,
	  	customConfig: '../../js/ckeditor/custom_config.js',
		on: {
        change: function( evt ) {
			var newContent = this.getData()			
				change_data('faq_answer',newContent);		   

				}
		}
  });
  
function CKupdate(){
  for ( instance in CKEDITOR.instances )
    CKEDITOR.instances[instance].updateElement();
}    
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
		$('#category_sub').attr("disabled",false);
		}else{
			$('#category_sub').attr("disabled",true);
		}	
	console.log(check);
}
function JQAdd_faq(form){	
CKupdate();
var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: '<?=$txt_faq_add;?>',
						content: '<?=$txt_ewt_confirm_alert;?>',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'far fa-question-circle',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: '<?=$txt_ewt_confirm_submit;?>',
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
													content: '<?=$txt_ewt_action_alert;?>',
													boxWidth: '30%',
													onAction: function () {
														document.location.reload();
														$('#box_popup').fadeOut();
													}													
												});
												//$("#frm_edit_s").load(location.href + " #frm_edit_s");
												//alert("Data Save: " + data);												
												//self.location.href="article_list.php?cid="+data;											
												//$('#box_popup').fadeOut();
												
											}
										});																										
									}								
							
								},
								cancel: {
									text: '<?=$txt_ewt_cancel;?>',
									action: function () {
									$('#box_popup').fadeOut(); 	
									}									
								}
							},                          
                            animation: 'scale',
                            type: 'blue'
						
						});
					} 
								
}

</script>