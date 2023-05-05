<?php
include("../EWT_ADMIN/comtop_pop.php"); 

$vul_id = (int)(!isset($_GET['vul_id']) ?  : $_GET['vul_id']);
if(empty($vul_id))
{
	exit();
}
$_sql = $db->query("SELECT * 
					FROM w_vulgar 
					WHERE  vulgar_id = '{$vul_id}'
					");					
$a_data = $db->db_fetch_array($_sql);
?>

<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_edit_webboard_vul')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Edit_Vul">
<input type="hidden" name="vul_id" id="vul_id"  value="<?php echo $vul_id;?>"> 

<div class="container" >    
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">    
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x color-white"></i></button>
<h4 class="modal-title color-white"><i class="fas fa-plus-circle"></i> <?php echo 'แก้ไขคำไม่สุภาพ/โฆษณา';?></h4>  
</div>

<div class="modal-body">
<div class="card ">
<div class="card-body" >
<div class="form-group row " >
<div class="col-md-12 col-sm-12 col-xs-12" > 
<label for="vulgar_status"><b><?php echo "สถานะการเปิด/ปิดการใช้งาน";?> </b></label> :   
<div >
<label class="switch">
  <input type="checkbox" value="Y" name="vulgar_status" id="vulgar_status" <?php if($a_data['vulgar_status'] == 'Y'){ echo 'checked="checked"'; } ?>>
  <span class="slider round"></span>
  <span class="absolute-no">NO</span>
</label>
</div>
</div>
</div>
<div class="form-group row " > 
<label for="vulgar_text" class="col-sm-12 control-label"><b><?php echo ' คำไม่สุภาพ/โฆษณา';?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<textarea class="form-control" placeholder="<?php echo' คำไม่สุภาพ/โฆษณา';?>"  rows="2" id="vulgar_text" name="vulgar_text"  required="required" ><?php echo $a_data['vulgar_text'];?></textarea>
</div>
</div>
<div class="form-group row " >
<label for="ip_add" class="col-sm-12 control-label"><b><?php echo 'ประเภท';?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" > 
<div class="radio b-sm">  
  <label><input type="radio" name="ip_add" id="ip_add" value="1"  <?php if($a_data['ip_add'] == '1'){ echo 'checked="checked"'; } ?> ><?php echo 'คำไม่สุภาพ';?> 
  <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
  </label>

  <label><input type="radio" name="ip_add" id="ip_add"  value="2" <?php if($a_data['ip_add'] == '2'){ echo 'checked="checked"'; } ?> ><?php echo 'โฆษณา';?>  
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
<button onclick="JQEdit_Vul($('#form_main'));" type="button" class="btn btn-success  btn-ml">
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

	var img = $('#emotion_img_old').val(); 
	if(img == '' || img == 'undefined') 
	{
		$('#news-image').show();
		$('#old-image').hide();
		$('.checkbox').hide();
			
	}
			
});
function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('.image-upload-wrap').hide();
      $('.file-upload-image').attr('src', e.target.result);
      $('.file-upload-content').show();
      $('.image-title').html(input.files[0].name);
    };
    reader.readAsDataURL(input.files[0]);
  } else {
    removeUpload(); 
  }
}
function removeUpload() {
  $('.file-upload-input').replaceWith($('.file-upload-input').clone());
  $('.file-upload-content').hide();
  $('.image-upload-wrap').show();
}
$('.image-upload-wrap').bind('dragover', function () {
		$('.image-upload-wrap').addClass('image-dropping');
	});
$('.image-upload-wrap').bind('dragleave', function () {
		$('.image-upload-wrap').removeClass('image-dropping');
});

function JSChange(ID) {
	if($('#'+ID).is(':checked') == true){	
			$('#old-image').hide();
			$('#news-image').show();
		}else if($('#'+ID).is(':checked') == false){
			$('#news-image').hide();
			$('#old-image').show(); 
		}
} 
function JQEdit_Vul(form){  	
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
						title: 'แก้ไขคำที่ไม่สุภาพ/โฆษณา',  
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