<?php
include("../EWT_ADMIN/comtop_pop.php");

$s_group = $db->query("SELECT * FROM cal_category WHERE cat_id = '{$_GET['id']}' ");
$a_data = $db->db_fetch_array($s_group);
$a_num = $db->db_num_rows($s_group);
?>	
<form id="form_main" name="form_main" method="POST" action="<?=getLocation('func_set_cal_category_multilang')?>" enctype="multipart/form-data" >
      <input type="hidden" name="proc" id="proc"  value="set_lang_cal_category">
	  <input type="hidden" name="num"  id="num" value="1">
      <input type="hidden" name="c_id" id="c_id" value="<?=$_GET['id']?>">
	  <input type="hidden" name="lang_name"  id="lang_name" value="<?=$_GET['langid']?>">
	  <input type="hidden" name="module" id="module" value="cal_category">
<div class="container" >   
<div class="modal-dialog modal-ml" style="width:60%;">

<div class="modal-content">
<div class="modal-header ">
<button type="button" class="close" onclick="$('#box_popup').fadeOut()" ><i class="far fa-times-circle fa-1x"></i></button>
<h4 class="modal-title"><?=$txt_calendar_cate;?><?="ภาษาอื่นๆ";?></h4>
</div>

<div class="modal-body">
<div class="card ">
<div class="card-header ewt-bg-success m-b-sm" >
<div class="card-title text-left"><b>&bull;&nbsp;กรุณาใส่ภาษาตามที่เลือก &nbsp;</b><?=show_icon_setlang($a_data['cat_id'],'cal_category');?></div>
</div>

<div class="card-body" >

<div class="form-group row " >
<label for="" class="col-sm-6 control-label"><b><?=$txt_calendar_cate;?>ภาษาหลัก :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<h4><span class="label label-primary"><?=$a_data['cat_name'];?></span></h4>
</div>
</div>
<div class="form-group row" >
<label for="" class="col-sm-6 control-label"><b><?=$txt_calendar_cate;?>ภาษาตามที่เลือก :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input name="lang_detail[0]" type="text" class="form-control" value="<?=select_lang_detail($_GET['id'],$_GET['langid'],'cat_name','cal_category');?>">
<input type="hidden" name="lang_field[0]" value="cat_name">
</div>
</div>
</div>
</div>	
</div>
		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQSet_lang_group($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?="บันทึก";?>
</button>
</div>
</div>
</div>
 
</div>
</div>	 
</form>	
<script>  
function JQSet_lang_group(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: '<?=$txt_calendar_cate;?><?="ภาษาอื่นๆ";?>',
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