<?php
include("../EWT_ADMIN/comtop_pop.php");

$pdpa_id = (int)(!isset($_GET['pdpa_id']) ? 0 : $_GET['pdpa_id']);

$_sql = $db->query("SELECT * 
					FROM  m_complain_pdpa	
					WHERE pdpa_id = '{$pdpa_id}'
					");			  
$a_rows = $db->db_num_rows($_sql);	
$a_data = $db->db_fetch_array($_sql);
?>

<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_add_complain_pdpa')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Add_Pdpa">
<input type="hidden" name="pdpa_id" id="pdpa_id"  value="<?php echo $pdpa_id;?>">
<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x color-white"></i></button>
<h4 class="modal-title  color-white"><i class="fas fa-plus-circle"></i>  ข้อกำหนด PDPA<?php //echo $txt_complain_edit_cate;?></h4>
</div>

<div class="modal-body">

<div class="card ">
<div class="card-header" >
<div class="card-title text-left"><b></b></div>
</div>

<div class="card-body" >
<div class="form-group row " >
<div class="col-md-12 col-sm-12 col-xs-12" >
<label for="pdpa_status"><b>สถานะการใช้งาน</b></label> :  
<div >
<label class="switch">
  <input type="checkbox" value="Y" name="pdpa_status" id="pdpa_status" <?php  echo 'checked="checked"'; ?> />
  <span class="slider round"></span>
  <span class="absolute-no">NO</span> 
</label>
</div>
</div>
</div>

<div class="form-group row " >
<div class="col-md-12 col-sm-12 col-xs-12" > 
<label for="pdpa_checkbox"><b>มี Checkbox</b></label> :  
<div >
<label class="switch">
  <input type="checkbox" value="Y" name="pdpa_checkbox" id="pdpa_checkbox" <?php  echo 'checked="checked"'; ?> />
  <span class="slider round"></span>
  <span class="absolute-no">NO</span> 
</label>
</div>
</div>
</div>

<div class="form-group row " >
<label for="pdpa_detail" class="col-sm-12 control-label"><b><?php echo $txt_faq_cate_detail;?>  :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<textarea class="form-control" placeholder="<?php echo $txt_faq_cate_detail;?>"  rows="5" id="pdpa_detail" name="pdpa_detail"  ><?php echo $a_data['pdpa_detail'];?></textarea>
</div>
</div>

<div class="form-group row " >
<label for="pdpa_file" class="col-sm-12 control-label"><b><?php echo "ข้อกำหนด PDPA เพิ่มเติม";?>  :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input class="form-control" placeholder="<?php echo "";?>"  id="pdpa_file" name="pdpa_file" type="file" >
</div>
</div>

</div>	
</div>
		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQEdit_Complain_Group($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
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
function JQEdit_Complain_Group(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: 'ข้อกำหนด PDPA',
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
														//self.location.href="complain_builder.php?com_cid=6";	
														location.reload(true);			
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