<?php
include("../EWT_ADMIN/comtop_pop.php");

?>

<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_add_ebook_page_size')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="AddPageSize">

<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x  color-white"></i></button>
<h4 class="modal-title color-white"><i class="fas fa-plus-circle"></i> <?php echo $txt_ebook_page_size_add ;?></h4>
</div>

<div class="modal-body">
<div class="card ">
<div class="card-body" >

<div class="scrollbar scrollbar-near-moon thin">

<div class="form-group row " >
<div class="col-md-12 col-sm-12 col-xs-12" >
<label for="e_page_size_show"><b>สถานะ</b></label> :  
<div >
<label class="switch">
  <input type="checkbox" value="Y" name="e_page_size_show" id="e_page_size_show" <?php if($a_data['size_show'] == 'Y' || $a_data['size_show'] == ''){ echo 'checked="checked"'; } ?> />
  <span class="slider round"></span>
  <span class="absolute-no">NO</span> 
</label>
</div>
</div>
</div>

<div class="form-group row " >
<label for="e_page_size_title" class="col-sm-12 control-label"><b><?php echo $txt_ebook_page_size_title;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<textarea class="form-control" placeholder="<?php echo $txt_ebook_page_size_title;?>"  rows="6" id="e_page_size_title" name="e_page_size_title"  required="required" ></textarea>
</div>
</div>
<div class="form-group row " >
<div class="col-md-6 col-sm-6 col-xs-12" >
<label for="e_page_size_width" class=""><b><?php echo $txt_ebook_page_size_width;?> <span class="text-danger"><code>*</code></span> :</b></label>
<!--<input class="form-control" placeholder="<?php echo $txt_ebook_page_size_width;?>" name="e_page_size_width" type="text" id="e_page_size_width"  value="" required="required" />-->
<div class="input-group">
<input class="form-control" placeholder="<?php echo $txt_ebook_page_size_width;?>" name="e_page_size_width" type="text" id="e_page_size_width"  value="<?php echo $a_data['ebook_preset_w'];?>" required="required" aria-describedby="basic-addon2" />
 <span class="input-group-addon" id="basic-addon2">pixels</span>
</div>
<p class="text-danger"><code>Ex. 1200 pixels</code></p>
</div>

<div class="col-md-6 col-sm-6 col-xs-12" >
<label for="e_page_size_height" class=""><b><?php echo $txt_ebook_page_size_height;?> <span class="text-danger"><code>*</code></span> :</b></label> 
<!--<input class="form-control" placeholder="<?php echo $txt_ebook_page_size_height;?>" name="e_page_size_height" type="text" id="e_page_size_height"  value="" required="required" />-->
<div class="input-group">
<input class="form-control" placeholder="<?php echo $txt_ebook_page_size_height;?>" name="e_page_size_height" type="text" id="e_page_size_height"  value="<?php echo $a_data['ebook_preset_w'];?>" required="required" aria-describedby="basic-addon2" />
 <span class="input-group-addon" id="basic-addon2">pixels</span>
</div>
<p class="text-danger"><code>Ex. 1200 pixels</code></p>
</div>
</div>

</div>		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQAdd_PageSize($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?php echo $txt_ewt_save;?> 
</button>
</div>
</div>
</div>
</div>
</div>
 </div>
</div>
</div>	 
</form>
	
<script>  
function JQAdd_PageSize(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: '<?php echo $txt_ebook_page_size_add;?>',
						content: '<?php echo $txt_ewt_confirm_alert;?> ',
						boxWidth: '50%',
						icon: 'far fa-question-circle',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: '<?php echo $txt_ewt_confirm_submit;?>',
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
													title: '<?php echo $txt_ewt_action_alert;?>',
													theme: 'modern',
													content: '',
													boxWidth: '30%',
													onAction: function () {
														//self.location.href="menu_builder.php?m_id="+data;		
														location.reload(true);	
														//$("#frm_edit_s").load(location.href + " #frm_edit_s");
														$('#box_popup').fadeOut();
													}		
												});
																										
												
											}
										});																										
									}								
							
								},
								cancel: {
									text: '<?php echo $txt_ewt_cancel;?>',
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