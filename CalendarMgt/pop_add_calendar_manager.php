<?php
include("../EWT_ADMIN/comtop_pop.php"); 

$_sql = $db->query("SELECT * 
					FROM cal_category 
					WHERE webname_site = '{$_SESSION['EWT_SUSER']}' {$wh} 
					ORDER BY cat_id DESC");
$s_cat_color = array();

while($a_data = $db->db_fetch_array($_sql)){
	
	array_push($s_cat_color,$a_data['cat_color']);
	
}

?>

<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_add_calendar_manager')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Add_Manager">

<div class="container" >    
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">    
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x color-white"></i></button>
<h4 class="modal-title color-white"><i class="fas fa-plus-circle"></i> <?php echo 'เพิ่มผู้บริหาร';?></h4> 
</div>

<div class="modal-body">
<div class="card ">
<div class="card-body" >
<div class="form-group row " >
<div class="col-md-12 col-sm-12 col-xs-12" >
<label for="m_status"><b><?php echo "สถานะการเปิด/ปิดการใช้งาน";?> </b></label> :   
<div >
<label class="switch">
  <input type="checkbox" value="Y" name="m_status" id="m_status" <?php if($a_data['m_status'] == 'Y' || $a_data['m_status'] == ''){ echo 'checked="checked"'; } ?> />
  <span class="slider round"></span>
  <span class="absolute-no">NO</span>
</label>
</div>
</div>
</div>
<div class="form-group row " >
<div class="col-md-6 col-sm-6 col-xs-12">
<label for="m_name" class="col-sm-12 control-label"><b><?php echo ' ชื่อ';?> <span class="text-danger"><code>*</code></span> :</b></label>
<input class="form-control" placeholder="<?php echo 'ชื่อ';?>" name="m_name" type="text" id="m_name"  value="" required="required" > 
</div>
<div class="col-md-6 col-sm-6 col-xs-12">
<label for="m_surname" class="col-sm-12 control-label"><b><?php echo 'นามสกุล';?> <span class="text-danger"><code>*</code></span> :</b></label>
<input class="form-control" placeholder="<?php echo 'นามสกุล';?>" name="m_surname" type="text" id="m_surname"  value="" required="required" > 
</div>
</div>
<div class="form-group row " >
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="m_pos" class="col-sm-12 control-label"><b><?php echo 'ตำแหน่ง';?> <span class="text-danger"><code>*</code></span> :</b></label>
<input class="form-control" placeholder="<?php echo 'ตำแหน่ง';?>" name="m_pos" type="text" id="m_pos"  value="" required="required" > 
</div>
</div>

<div class="form-group row " >
<label for="m_images" class="col-sm-12 control-label"><b><?php echo ' รูปภาพ';?>  :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="file-upload-drag ">
  <div class="image-upload-wrap"> 
    <input class="file-upload-input" name="m_images" id="m_images" type="file" onchange="readURL(this);JSCheck_Img(this.id,this.value);" accept="image/*" />
    <div class="drag-icon"> 
	<i class="fas fa-cloud-upload-alt fa-5x"></i>
	</div>	
	<div class="drag-text"> 
      <h4>Drag and Drop your files or Browse</h4>
    </div>	
  </div>
<div class="file-upload-content">
<img class="file-upload-image" src="#" alt="your image" />
    <!--<div class="image-title-wrap">
      <button type="button" onclick="removeUpload();" class="remove-image"><i class="fas fa-trash-alt"></i> Remove </button>
    </div>-->
<div style="padding-top:10px;text-align:left;">
<button type="button" class="btn btn-danger  btn-circle  btn-sm " onclick="removeUpload();" data-toggle="tooltip" data-placement="top" title="Remove"   >
<i class="far fa-trash-alt" aria-hidden="true"></i>
</button>
</div>
</div>
		
</div> 

<span class="text-danger">
<code>
ประเภทไฟล์ที่สามารถใช้ได้คือ <?php echo EwtTypefile('img');?>
</code>
</span>
<br>
<span class="text-danger"><code>
ขนาดไฟล์ต้องไม่เกิน <?php echo EwtMaxfile('img');?> MB.
</code>
</span>
</div>
</div>
<!--<div class="form-group row " >
<label for="category_order" class="col-sm-12 control-label"><b><?php echo '';?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-2 col-sm-2 col-xs-12" >
<input class="form-control checknumber" placeholder="<?php echo '';?>" name="category_order" type="text" id="category_order"  value="" required="required" />
</div>
</div>-->

</div>
</div>
</div>	
	
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQAdd_Calendar_Manage($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
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

function JQCheck_Cate(form){
	var name  = form.attr('name'); 
	var check = $('input:checkbox[name='+name+']:checked').val();	
	if(check == 'Y'){
		$('#category_parent').attr("disabled",false);
		$('#category_parent').attr("required",false);
		}else{
			$('#category_parent').attr("disabled",true);
			$('#category_parent').attr("required",true);
		}	
	console.log(check);
}

function JQAdd_Calendar_Manage(form){ 	
$('#loader').fadeIn();	
var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: '<?php echo "เพิ่มผู้บริหาร";?>', 
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
												$("#loader").fadeOut(5000);  
												console.log(data);
												$.alert({
													title: '',
													theme: 'modern',
													content: 'ส่งข้อมูลตอบกลับเรียบร้อย',
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