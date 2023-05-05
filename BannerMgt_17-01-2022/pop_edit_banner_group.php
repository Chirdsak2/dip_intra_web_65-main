<?php
include("../EWT_ADMIN/comtop_pop.php");
include("../language/banner_language.php");

$ban_cid = (int)(!isset($_GET['ban_cid']) ? 0 : $_GET['ban_cid']);

$s_group = $db->query("SELECT * FROM banner_group  WHERE  banner_gid = '{$ban_cid }' ");
$a_group = $db->db_fetch_array($s_group);
?>	
<form id="form_main" name="form_main" method="POST" action="<?=getLocation('func_edit_banner_group')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Edit_Cate_Banner">
<input type="hidden" name="banner_gid" id="banner_gid"  value="<?=$ban_cid;?>">
<input type="hidden" name="banner_cate_order" id="banner_cate_order"  value="<?=$a_group['banner_cate_order'];?>">
<div class="container" >    
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x color-white"></i></button>
<h4 class="modal-title  color-white"><i class="fas fa-plus-circle"></i> <?=$txt_banner_edit_cate;?></h4>
</div>

<div class="modal-body">
<div class="card ">
<div class="scrollbar scrollbar-near-moon thin">

<div class="card-body" >

<div class="form-group row " >
<label for="banner_name" class="col-sm-6 control-label"><b><?=$txt_banner_cate_name;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input class="form-control" placeholder="<?=$txt_banner_cate_name;?>" name="banner_name" type="text" id="banner_name"  value="<?=$a_group['banner_name'];?>" required="required"/>
</div>
</div>
<div class="form-group row " >
<label for="banner_detail" class="col-sm-6 control-label"><b><?=$txt_banner_cate_detail;?> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<textarea class="form-control" placeholder="<?=$txt_banner_cate_detail;?>"  rows="5" id="banner_detail" name="banner_detail"  ><?=$a_group['banner_detail'];?></textarea>
</div>
</div>

<div class="form-group row">
<div class="col-md-6 col-sm-6 col-xs-12">
<label for="banner_w"><b><?=$txt_banner_set_w ;?> <span class="text-danger"><code>*</code></span> : </b></label>
<input type="text" class="form-control" placeholder="<?=$txt_banner_w_placeholder;?>"  id="banner_w" name="banner_w"  value="<?=$a_group['banner_w'];?>" required="required" /> 
<p class="text-danger"><code>Ex. 1000</code></p>
</div>

<div class="col-md-6 col-sm-6 col-xs-12">
<label for="banner_h"><b><?=$txt_banner_set_h;?> <span class="text-danger"><code>*</code></span> : </b></label>
<input type="text" class="form-control" placeholder="<?=$txt_banner_w_placeholder;?>"  id="banner_h" name="banner_h" value="<?=$a_group['banner_h'];?>" required="required" /> 
<p class="text-danger"><code>Ex. 480</code></p>
</div>
</div>

</div>
</div>	
</div>
		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQEdit_Banner_Cate($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
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
function JQEdit_Banner_Cate(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: '<?=$txt_banner_edit_cate;?>',
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
												try
												{
												var cdata= JSON.stringify(eval("("+data+")"));
												var jsonObject = jQuery.parseJSON(cdata);												
											console.log(jsonObject.faq_cate_parent);	
											$.alert({
													title: '',
													theme: 'modern',
													content: 'บันทึกข้อมูลเรียบร้อย',
													boxWidth: '30%',
													onAction: function () {
														$('#box_popup').fadeOut();
														if(jsonObject.faq_cate_status_parent == 'Y'){
														self.location.href="faq_subgroup.php?faq_cid="+jsonObject.faq_cate_parent;
														}else{		
														self.location.href="faq_group.php";														
															document.location.reload();		
														}														
													}																					
												});
												//$("#frm_edit_s").load(location.href + "frm_edit_s");
												//alert("Data Save: " + location.href);												
												//self.location.href="article_list.php?cid="+data;											
												//$('#box_popup').fadeOut();
												//document.location.reload();
												//window.location.reload();												
											}									
											catch(e){
												}															
											}
										});																										
									}								
							
								},
								cancel: {
									text: 'ยกเลิก',
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