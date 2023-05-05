<?php
include("../EWT_ADMIN/comtop_pop.php");
?>

<form id="form_main" name="form_main" method="POST" action="<?=getLocation('func_add_group')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Add_Org_Group">

<div class="container" >   
<div class="modal-dialog modal-lg"  >

<div class="modal-content ">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6" >
<button type="button" class="close"  onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x  color-white"></i></button>
<h4 class="modal-title color-white"> <i class="fas fa-plus-circle"></i> <?=$txt_org_add_group;?></h4>
</div>

<div class="modal-body">

<div class="card ">
<div class="scrollbar scrollbar-near-moon thin">


<div class="card-body" >

<div class="form-group row " >
<label for="org_group_name" class="col-sm-12 control-label"><b><?=$txt_org_group_name;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<textarea class="form-control" placeholder="<?=$txt_org_group_name;?>"  rows="6" id="org_group_name" name="org_group_name"  required="required" ></textarea>
</div>
</div>
<div class="form-group row " >
<label for="org_group_name_short" class="col-sm-12 control-label"><b><?=$txt_org_group_name_short;?>  :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<textarea class="form-control" placeholder="<?=$txt_org_group_name_short;?>"  rows="6" id="org_group_name_short" name="org_group_name_short"  ></textarea>
</div>
</div>
<div class="form-group row " >
<label for="org_group_tel" class="col-sm-12 control-label"><b><?=$txt_org_group_tel;?>  :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input class="form-control checknumber" placeholder="<?=$txt_org_group_tel;?>" id="org_group_tel" name="org_group_tel"  type="text">
</div>
</div>
<div class="form-group row " >
<label for="org_group_fax" class="col-sm-12 control-label"><b><?=$txt_org_group_fax;?>  :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input class="form-control checknumber" placeholder="<?=$txt_org_group_fax;?>" id="org_group_fax" name="org_group_fax"  type="text">
</div>
</div>
<div class="form-group row " >
<label for="org_group_email" class="col-sm-12 control-label"><b><?=$txt_org_group_email;?>  :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input class="form-control checkmail" placeholder="<?=$txt_org_group_email;?>" id="org_group_email" name="org_group_email"  type="text"  >
</div>
</div>

<div class="form-group row " >
<label for="org_group_use" class="col-sm-12 control-label"><b><?=$txt_org_group_set_use;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="radio">
  <label><input type="radio" name="org_group_use" value="Y" checked><?=$txt_org_status_y;?>
  <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
  </label>
</div>
<div class="radio">
  <label><input type="radio" name="org_group_use" value="N" ><?=$txt_org_status_n;?>
  <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
  </label>
</div>
</div>
</div>



</div>
</div>	
</div>
		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQAdd_Org_Group($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
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
function CKupdate()
{
  for ( instance in CKEDITOR.instances )
    CKEDITOR.instances[instance].updateElement();
}    
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

function JQAdd_Org_Group(form)
{	
var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: '<?=$txt_org_add_group;?>',
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