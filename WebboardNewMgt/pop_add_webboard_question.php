<?php
include("../EWT_ADMIN/comtop_pop.php"); 
$c_id = (int)(!isset($_GET['c_id']) ? '' : $_GET['c_id']); 
?>
<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_add_webboard_question')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Add_Ques"> 
<input type="hidden" name="c_id" id="c_id"  value="<?php echo $c_id;?>"> 
<div class="container" >    
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">    
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x color-white"></i></button>
<h4 class="modal-title color-white"><i class="fas fa-plus-circle"></i> <?php echo $txt_webboard_new_question;?></h4> 
</div>

<div class="modal-body">
<div class="card ">
<div class="card-body" >
<div class="form-group row " >
<div class="col-md-12 col-sm-12 col-xs-12" >
<label for="q_status"><b><?php echo "สถานะการเปิด/ปิดการใช้งาน";?> </b></label> :   
<div >
<label class="switch"> 
  <input type="checkbox" value="1" name="q_status" id="q_status" <?php if($a_data['q_status'] == '1' || $a_data['q_status'] == ''){ echo 'checked="checked"'; } ?>>
  <span class="slider round"></span>
  <span class="absolute-no">NO</span>
</label>
</div>
</div>
</div>
<div class="form-group row " >
<label for="q_name" class="col-sm-12 control-label"><b><?php echo ' หัวข้อกระทู้';?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<textarea class="form-control" placeholder="<?php echo 'หัวข้อกระทู้';?>"  rows="3" id="q_name" name="q_name"  required="required" ></textarea>
</div>
</div>
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12"> 
<label for="q_detail" class="col-sm-12 control-label"><b><?php echo 'รายละเอียด';?>  :</b></label>
<textarea class="form-control" placeholder="<?php echo 'รายละเอียด';?>"  rows="5" id="q_detail" name="q_detail" ></textarea>
</div>
</div>


</div>
</div>
</div>	
	
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQAdd_Ques($('#form_main'));" type="button" class="btn btn-success  btn-ml">
<i class="fas fa-save"></i>&nbsp;<?php echo $txt_ewt_save;?>
</button>
</div>
</div>

</div>
 
</div>
</div>	 
</form> 
<script>  
$(document).ready(function() {

});

function JQAdd_Ques(form){  	
//$('#loader').fadeIn();	
var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: '<?php echo $txt_webboard_new_question;?>',  
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
												//$("#loader").fadeOut(5000);  
												console.log(data);
												/*$.alert({
													title: '',
													theme: 'modern',
													content: 'ส่งข้อมูลตอบกลับเรียบร้อย',
													boxWidth: '30%',
													onAction: function () {
														//self.location.href="complain_builder.php?com_cid=6";	
														location.reload(true);			
														$('#box_popup').fadeOut();
													}		
												});*/
												
												$.alert({
													title: 'บันทึกข้อมูลเรียบร้อย',
													theme: 'modern',
													icon: 'far fa-check-circle',
													content: 'Success! ',
													type: 'green',
													typeAnimated: true,
													boxWidth: '30%',	
													buttons: {
														ok: {
															btnClass: 'btn-green'
															}     
														},
													onAction: function () {
														//self.location.href="complain_builder.php?com_cid=6";	
														location.reload(true);			
														$('#box_popup').fadeOut();
													}		
												});																																
												
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