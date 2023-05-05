<?php
include("../EWT_ADMIN/comtop_pop.php");

$m_id = (int)(!isset($_GET['m_id']) ?  : $_GET['m_id']);
if(empty($m_id))
{
	exit();
}
$_sql = $db->query("SELECT * 
					FROM cal_manager 
					WHERE  m_id = '{$m_id}'
					");					
$a_data = $db->db_fetch_array($_sql); 
$dir_base = "../ewt/".$_SESSION['EWT_SUSER']."/assets/images/calendar/"; 
?>
 
<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_edit_calendar_manager')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Edit_Manager"> 
<input type="hidden" name="m_id" id="m_id"  value="<?php echo $m_id;?>">
<input type="hidden" name="m_images_old" id="m_images_old"  value="<?php echo $a_data['m_images'];?>" > 
<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header  ewt-bg-color b-t-l-6 b-t-r-6"> 
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x color-white"></i></button>
<h4 class="modal-title color-white"><i class="far fa-edit" aria-hidden="true"></i> <?php echo 'แก้ไขผู้บริหาร';?></h4>
</div>

<div class="modal-body">

<div class="card ">
<div class="card-body" >

<div class="form-group row " >
<div class="col-md-12 col-sm-12 col-xs-12" >
<label for="m_status"><b><?php echo "สถานะการเปิด/ปิดการใช้งาน";?> </b></label> :   
<div >
<label class="switch">
  <input type="checkbox" value="Y" name="m_status" id="m_status" <?php if($a_data['m_status'] == 'Y'){ echo 'checked="checked"'; } ?> />
  <span class="slider round"></span>
  <span class="absolute-no">NO</span>
</label>
</div>
</div>
</div>
<div class="form-group row " >
<div class="col-md-6 col-sm-6 col-xs-12">
<label for="m_name" class="col-sm-12 control-label"><b><?php echo ' ชื่อ';?> <span class="text-danger"><code>*</code></span> :</b></label>
<input class="form-control" placeholder="<?php echo 'ชื่อ';?>" name="m_name" type="text" id="m_name"  value="<?php echo $a_data['m_name'];?>" required="required" > 
</div>
<div class="col-md-6 col-sm-6 col-xs-12">
<label for="m_surname" class="col-sm-12 control-label"><b><?php echo 'นามสกุล';?> <span class="text-danger"><code>*</code></span> :</b></label>
<input class="form-control" placeholder="<?php echo 'นามสกุล';?>" name="m_surname" type="text" id="m_surname"  value="<?php echo $a_data['m_surname'];?>" required="required" > 
</div>
</div>
<div class="form-group row " >
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="m_pos" class="col-sm-12 control-label"><b><?php echo 'ตำแหน่ง';?> <span class="text-danger"><code>*</code></span> :</b></label>
<input class="form-control" placeholder="<?php echo 'ตำแหน่ง';?>" name="m_pos" type="text" id="m_pos"  value="<?php echo $a_data['m_pos'];?>" required="required" > 
</div>
</div>

<div class="form-group row " >
<label for="m_images" class="col-sm-12 control-label"><b><?php echo 'รูปภาพ';?>  :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="checkbox">
  <label><input type="checkbox" name="show_image" id="show_image" value="1" onclick="JSChange(this.id);" >
  <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>เปลี่ยนรูปภาพ
  </label>
</div>
<div class="file-upload-drag " id="old-image" > 
<?php 
if(file_exists($dir_base.$a_data['m_images']) && $a_data['m_images'] != ''){
?>
<img src="<?php echo $dir_base.$a_data['m_images'];?>" alt="" class="img-rounded img-responsive file-upload-image-old" >
<?php } ?>
</div>

<div class="file-upload-drag " id="news-image" style="display:none;" >
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
</div>

<!--<div class="form-group row " >
<label for="category_order" class="col-sm-12 control-label"><b><?php //echo $text_genfaq_categorystep;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-2 col-sm-2 col-xs-12" >
<input class="form-control checknumber" placeholder="<?php //echo $text_genfaq_categorystep;?>" name="category_order" type="text" id="category_order"  value="" required="required" />
</div>
</div>-->

</div>
</div>	

</div>
		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQEdit_Calendar_Group($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
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

	var img = $('#m_images_old').val(); 
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

function JQEdit_Calendar_Group(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: '<?php echo $txt_calendar_edit_cate;?>',
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
												/*$.alert({
													title: '',
													theme: 'modern',
													content: 'บันทึกข้อมูลเรียบร้อย',
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