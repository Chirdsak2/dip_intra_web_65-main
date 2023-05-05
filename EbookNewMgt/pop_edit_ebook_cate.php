<?php
include("../EWT_ADMIN/comtop_pop.php");

$c_id 	= (int)(!isset($_GET['c_id']) ? '' : $_GET['c_id']);

$s_sql 	= $db->query("SELECT * FROM ebook_group WHERE g_ebook_id = '{$c_id}' ");
$a_data = $db->db_fetch_array($s_sql);  
?>

<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_edit_ebook_cate')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Edit_EbookCate">
<input type="hidden" name="c_id" id="c_id"  value="<?php echo $c_id;?>">
<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x  color-white"></i></button>
<h4 class="modal-title color-white"><i class="fas fa-plus-circle"></i> <?php echo $txt_ebook_cate_edit ;?></h4> 
</div>

<div class="modal-body">
<div class="card ">
<div class="card-body" >

<div class="scrollbar scrollbar-near-moon thin">

<div class="form-group row " >
<div class="col-md-12 col-sm-12 col-xs-12" >
<label for="e_cate_status"><b>สถานะ</b></label> :  
<div >
<label class="switch">
  <input type="checkbox" value="Y" name="e_cate_status" id="e_cate_status" <?php if($a_data['g_ebook_status'] == 'Y'){ echo 'checked="checked"'; } ?> />
  <span class="slider round"></span>
  <span class="absolute-no">NO</span> 
</label>
</div>
</div>
</div>

<div class="form-group row " >
<label for="e_cate_name" class="col-sm-12 control-label"><b><?php echo $txt_ebook_cate_name;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<textarea class="form-control" placeholder="<?php echo $txt_ebook_cate_name;?>"  rows="6" id="e_cate_name" name="e_cate_name"  required="required" ><?php echo $a_data['g_ebook_name'];?></textarea>
</div>
</div>

</div>		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQEdit_EbookCate($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
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
function JQEdit_EbookCate(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({ 
						title: '<?php echo $txt_ebook_cate_edit;?>',
						content: '<?php echo $txt_ewt_confirm_alert;?> ',
						//content: 'url:form.html',
						boxWidth: '30%',
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