<?php
include("../EWT_ADMIN/comtop_pop.php");

$faq_cid = (int)(!isset($_GET['faq_cid']) ? 0 : $_GET['faq_cid']);
?>

<form id="form_main" name="form_main" method="POST" action="<?=getLocation('func_add_poll')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Add_Poll">

<div class="container" >    
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x color-white"></i></button>
<h4 class="modal-title  color-white"><i class="fas fa-plus-circle"></i> <?=$txt_poll_add;?></h4>
</div>

<div class="modal-body">

<div class="card ">
<div class="scrollbar scrollbar-near-moon thin">


<div class="card-body" >

<div class="form-group row " >
<label for="poll_title" class="col-sm-12 control-label"><b><?=$txt_poll_title;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<textarea class="form-control" placeholder="<?=$txt_poll_title;?>"  rows="6" id="poll_title" name="poll_title"  required="required" ></textarea>
</div>
</div>
<div class="form-group row " >
<label for="poll_detail" class="col-sm-12 control-label"><b><?=$txt_poll_detail;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<textarea class="form-control" placeholder="<?=$txt_poll_detail;?>"  rows="6" id="poll_detail" name="poll_detail"  required="required" ></textarea>
</div>
</div>

<div class="form-group row">
<div class="col-md-6 col-sm-6 col-xs-12">
<label for="start_date"><b><?=$txt_poll_statdate;?> <span class="text-danger"><code>*</code></span>: </b></label>
            <div class='input-group date datepicker' id='datetimepicker1'>
                <input readonly type='text' class="form-control " placeholder="<?=$txt_poll_statdate;?>" name="start_date"  id="start_date" value="" required="required">
                <span class="input-group-addon ewt-bg-color color-white border-ewt">
                    <i class="far fa-calendar-alt"></i>
                </span>
            </div>
	</div>



<div class="col-md-6 col-sm-6 col-xs-12">
<label for="end_date"><b><?=$txt_poll_enddate;?> <span class="text-danger"><code>*</code></span>: </b></label>
            <div class='input-group date datepicker' id='datetimepicker2'>
                <input readonly  type='text' class="form-control " placeholder="<?=$txt_poll_enddate;?>"  name="end_date"  id="end_date" value="" required="required">
                <span class="input-group-addon ewt-bg-color color-white border-ewt">
                    <i class="far fa-calendar-alt"></i>
                </span>
            </div>
	</div>
</div>

<div class="form-group row " >
<label for="poll_show" class="col-sm-12 control-label"><b><?=$txt_faq_show;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="radio">
  <label><input type="radio" name="poll_show" value="Y" checked><?=$txt_faq_status_show;?>
  <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
  </label>
</div>
<div class="radio">
  <label><input type="radio" name="poll_show" value="N" ><?=$txt_faq_status_notshow;?>
  <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
  </label>
</div>
</div>
</div>

<div class="form-group row " >
<label for="poll_show" class="col-sm-12 control-label"><b><?="กำหนดระยะเวลาในการตอบแบบสำรวจ";?>  :</b></label>
<div class="col-md-5 col-sm-5 col-xs-5" >
<input class="form-control" placeholder="" name="poll_H" type="text" id="poll_H"  value=""  />
</div>
<div class="col-md-1 col-sm-1 col-xs-1" >
: ชั่วโมง
</div>
<div class="col-md-5 col-sm-5 col-xs-5" >
<input class="form-control" placeholder="" name="poll_M" type="text" id="poll_M"  value=""  />
</div>
<div class="col-md-1 col-sm-1 col-xs-1" >
: นาที
<br>
</div>
<div class="col-md-12 col-sm-12 col-xs-12" >
<p class="text-danger"> # ถ้าไม่ต้องการกำหนดเวลาให้ใส่ค่าเป็น '0' </p>
</div>
</div>




</div>
</div>	
</div>
		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQAdd_Poll($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?=$txt_ewt_save ;?>
</button>
</div>
</div>
</div>

</div>
 
</div>
</div>	 
</form>
<!-- Custom js -->
<script type="text/javascript" src="<?=$IMG_PATH;?>assets/js/custom.js"></script>	
<script>  

$(document).ready(function() {
 var today = new Date();
 $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
			todayHighlight: true,
           // language: 'th-th',
			//thaiyear: true,
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
 
function JQAdd_Poll(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: '<?=$txt_poll_add;?>',
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
														
														self.location.href="poll_builder.php?c_id="+jsonObject;	
														//location.reload(true);			
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
