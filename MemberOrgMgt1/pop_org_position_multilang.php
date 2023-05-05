<?php
include("../EWT_ADMIN/comtop_pop.php");

$db->query("USE ".$EWT_DB_USER);
$s_list = $db->query("SELECT * FROM `position_name` WHERE `pos_id` = '{$_GET[id]}' ");
$a_data = $db->db_fetch_array($s_list);
$a_num 	= $db->db_num_rows($s_list);
?>	
<form id="form_main" name="form_main" method="POST" action="<?=getLocation('func_set_org_position_multilang')?>" enctype="multipart/form-data" >
      <input type="hidden" name="proc" id="proc"  value="set_lang_org_position">
	  <input type="hidden" name="num"  id="num" value="2">
      <input type="hidden" name="c_id" id="c_id" value="<?=$_GET['id']?>">
	  <input type="hidden" name="lang_name"  id="lang_name" value="<?=$_GET['langid']?>">
	  <input type="hidden" name="module" id="module" value="position_name">
<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6" >
<button type="button" class="close" onclick="$('#box_popup').fadeOut()" ><i class="far fa-times-circle fa-1x color-white"></i></button>
<h4 class="modal-title color-white"><?=$txt_org_menu_postion;?><?=$txt_ewt_foreign_language;?></h4>
</div>

<div class="modal-body">
<div class="card ">
<div class="scrollbar scrollbar-near-moon thin">
<div class="card-header  m-b-sm" >
<div class="card-title text-left"><b>&bull;&nbsp;<?=$txt_ewt_please_select_language;?> &nbsp;</b><?=show_icon_setlang_ewt($a_data['pos_id'],'position_name');?></div>
</div>

<div class="card-body" >

<div class="form-group row " >
<label for="" class="col-sm-6 control-label"><b><?=$txt_org_pos_name;?><?=$txt_ewt_language_main;?> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<span class="text-primary bg-primary"><mark><?=$a_data['pos_name'];?></mark></span>
</div>
</div>
<div class="form-group row" >
<label for="lang_detail0" class="col-sm-6 control-label"><b><?=$txt_org_pos_name;?><?=$txt_ewt_language_of_choice;?> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<textarea class="form-control" placeholder="<?=$txt_org_pos_name;?>"  rows="6" id="lang_detail0" name="lang_detail[0]"  ><?=select_lang_detail_ewt($_GET['id'],$_GET['langid'],'pos_name','position_name');?></textarea>
<input type="hidden" name="lang_field[0]" value="pos_name">
</div>
</div>

<div class="form-group row " >
<label for="" class="col-sm-6 control-label"><b><?=$txt_org_pos_name_short;?><?=$txt_ewt_language_main;?> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<span class="text-primary bg-primary" ><mark><?=$a_data['pos_short_name'];?></mark></span>
</div>
</div>
<div class="form-group row" >
<label for="lang_detail1" class="col-sm-6 control-label"><b><?=$txt_org_pos_name_short;?><?=$txt_ewt_language_of_choice;?> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<textarea class="form-control" placeholder="<?=$txt_org_pos_name_short;?>"  rows="6" id="lang_detail1" name="lang_detail[1]"  ><?=select_lang_detail_ewt($_GET['id'],$_GET['langid'],'pos_short_name','position_name');?></textarea>
<input type="hidden" name="lang_field[1]" value="pos_short_name">
</div>
</div>

</div>
</div>	
</div>
</div>		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQSet_lang_pos($('#form_main'));"  type="button"   class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?=$txt_ewt_save;?>
</button>
</div>
</div>
</div>
 
</div>
</div>	 
</form>	
<script>  
function JQSet_lang_pos(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: '<?=$txt_org_menu_postion;?><?=$txt_ewt_foreign_language;?>',
						content: '<?=$txt_ewt_confirm_alert;?>',
						//content: 'url:form.html',
						boxWidth: '50%',
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
														//self.location.href="complain_builder.php?com_fid="+data;			
														location.reload(true);	
														//$("#frm_edit_s").load(location.href + " #frm_edit_s");
														$('#box_popup').fadeOut();
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