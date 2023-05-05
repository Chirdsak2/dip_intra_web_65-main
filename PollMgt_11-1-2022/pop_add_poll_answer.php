<?php
include("../EWT_ADMIN/comtop_pop.php");

$c_id = (int)(!isset($_GET['c_id']) ? 0 : $_GET['c_id']);
?>

<form id="form_main" name="form_main" method="POST" action="<?=getLocation('func_add_poll_answer')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Add_Poll_Answer" />
<input type="hidden" name="c_id" id="c_id"  value="<?=$c_id;?>" />
<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x color-white"></i></button>
<h4 class="modal-title  color-white"><i class="fas fa-plus-circle"></i>  <?='เพิ่มคำตอบแบบสำรวจ';?></h4>
</div>
<div class="modal-body">

<div class="card ">
<div class="scrollbar scrollbar-near-moon thin">
<div class="card-body" >

<div class="form-group row " >
<label for="poll_ans_title" class="col-sm-12 control-label"><b><?='คำตอบแบบสำรวจ';?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<textarea class="form-control" placeholder="<?='คำตอบแบบสำรวจ';?>"  rows="6" id="poll_ans_title" name="poll_ans_title"  required="required" ></textarea>
</div>
</div>

</div>
</div>	
</div>
		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQAdd_Poll_Ans($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?=$txt_ewt_save ;?>
</button>
</div>
</div>
</div>

</div>

</div>
</div>	 
</form>	
<script>  
function JQAdd_Poll_Ans(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: '<?='เพิ่มคำตอบแบบสำรวจ';?>',
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
												var cdata= JSON.stringify(eval("("+data+")"));
												var jsonObject = jQuery.parseJSON(cdata);
												console.log(jsonObject);
												$.alert({
													title: '',
													theme: 'modern',
													content: 'บันทึกข้อมูลเรียบร้อย',
													boxWidth: '30%',
													onAction: function () {
														
														//self.location.href="poll_builder.php?c_id="+jsonObject;	
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
