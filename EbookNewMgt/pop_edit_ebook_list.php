<?php
include("../EWT_ADMIN/comtop_pop.php");

$ebook_code = (!isset($_GET['ebook_code']) ? '' : $_GET['ebook_code']);
$c_id = (int)(!isset($_GET['c_id']) ? '' : $_GET['c_id']);

$s_sql 	= $db->query("SELECT * FROM ebook_info WHERE ebook_code = '{$ebook_code}' ");
$a_data = $db->db_fetch_array($s_sql);  

$dest = "../ewt/".$_SESSION["EWT_SUSER"]."/ebook/".$ebook_code; //Source ebook
$destPage = $dest.'/pages/';
?>

<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_edit_ebook_list')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Edit_Ebook">
<input type="hidden" name="ebook_code" id="ebook_code"  value="<?php echo $ebook_code;?>">
<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x  color-white"></i></button>
<h4 class="modal-title color-white"><i class="fas fa-plus-circle"></i> <?php echo $txt_ebook_list_edit ;?></h4> 
</div>

<div class="modal-body">
<div class="card ">
<div class="card-body" >

<div class="form-group row " >
<div class="col-md-12 col-sm-12 col-xs-12" >
<label for="e_book_status"><b>สถานะ</b></label> :  
<div >
<label class="switch">
  <input type="checkbox" value="Y" name="e_book_status" id="e_book_status" <?php if($a_data['show_status'] == 'Y'){ echo 'checked="checked"'; } ?> />
  <span class="slider round"></span>
  <span class="absolute-no">NO</span> 
</label>
</div>
</div>
</div>

<div class="form-group row " > 
<label for="e_book_name" class="col-sm-12 control-label"><b><?php echo $txt_ebook_list_name;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<textarea class="form-control" placeholder="<?php echo $txt_ebook_list_name;?>"  rows="4" id="e_book_name" name="e_book_name"  required="required" ><?php echo $a_data['ebook_name'];?></textarea>
</div>
</div>

<div class="form-group row " >
<label for="e_book_desc" class="col-sm-12 control-label"><b><?php echo $txt_ebook_list_detail;?>  :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<textarea class="form-control" placeholder="<?php echo $txt_ebook_list_detail;?>"  rows="4" id="e_book_desc" name="e_book_desc"   ><?php echo $a_data['ebook_desc'];?></textarea>
</div>
</div>
<div class="form-group row " >
<label for="e_book_cate" class="col-sm-12 control-label"><b><?php echo $txt_ebook_menu_cate;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<select class="selectpicker form-control" id="e_book_cate" name="e_book_cate"  data-live-search="true" title="<?php echo $txt_ebook_menu_cate;?>"  required="required" > 
        <?php
		$_sql_cate = $db->query("	SELECT
									*
									FROM ebook_group 
									WHERE 1=1 AND g_ebook_status = 'Y'
									ORDER BY g_ebook_id ASC ");
		while($a_data_cate = $db->db_fetch_array($_sql_cate))
		{ 
		$sel = ($a_data_cate['g_ebook_id'] == trim($a_data['g_ebook_id'])) ? "selected":"";
		?>
		<option value="<?php echo $a_data_cate['g_ebook_id'];?>" <?php echo $sel;?> ><?php echo $a_data_cate['g_ebook_name'];?></option>
		<?php
		}
		?>		
</select>
</div>
</div>

<div class="form-group row " >
<label for="size" class="col-sm-12 control-label"><b><?php echo 'เลือกขนาด';?>  :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<select class="selectpicker form-control" id="size" name="size"  data-live-search="true" title="<?php echo 'เลือกขนาด';?>" > 
        <?php
		$_sql_preset = $db->query("	SELECT
									*
									FROM ebook_preset 
									WHERE 1=1
									ORDER BY ebook_preset_id ASC ");
		while($a_data_preset = $db->db_fetch_array($_sql_preset))
		{ 
		$sel = ($a_data_preset['ebook_preset_id'] == trim($fm)) ? "selected":"";
		?>
		<option value="<?php echo $a_data_preset['ebook_preset_w'];?>##<?php echo $a_data_preset['ebook_preset_h'];?>" <?php echo $sel;?> ><?php echo $a_data_preset['ebook_preset_name'];?></option>
		<?php
		}
		?>		
</select>
</div>
</div>

<div class="form-group row " >
<div class="col-md-6 col-sm-6 col-xs-12" >
<label for="e_book_size_width" class=""><b><?php echo $txt_ebook_page_size_width;?> <span class="text-danger"><code>*</code></span> :</b></label>
<!--<input class="form-control" placeholder="<?php echo $txt_ebook_page_size_width;?>" name="e_page_size_width" type="text" id="e_page_size_width"  value="" required="required" />-->
<div class="input-group">
<input class="form-control" placeholder="<?php echo $txt_ebook_page_size_width;?>" name="e_book_size_width" type="text" id="e_book_size_width"  value="<?php echo $a_data['ebook_w'];?>" required="required" aria-describedby="basic-addon2" />
 <span class="input-group-addon" id="basic-addon2">pixels</span>
</div>
<p class="text-danger"><code>Ex. 100 pixels</code></p>
</div>

<div class="col-md-6 col-sm-6 col-xs-12" >
<label for="e_book_size_height" class=""><b><?php echo $txt_ebook_page_size_height;?> <span class="text-danger"><code>*</code></span> :</b></label> 
<!--<input class="form-control" placeholder="<?php echo $txt_ebook_page_size_height;?>" name="e_page_size_height" type="text" id="e_page_size_height"  value="" required="required" />-->
<div class="input-group">
<input class="form-control" placeholder="<?php echo $txt_ebook_page_size_height;?>" name="e_book_size_height" type="text" id="e_book_size_height"  value="<?php echo $a_data['ebook_h'];?>" required="required" aria-describedby="basic-addon2" />
 <span class="input-group-addon" id="basic-addon2">pixels</span>
</div>
<p class="text-danger"><code>Ex. 100 pixels</code></p> 
</div>
</div>



<div class="form-group row " >
<label for="e_book_by" class="col-sm-12 control-label"><b><?php echo $txt_ebook_list_owner;?>  :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input class="form-control" placeholder="<?php echo $txt_ebook_list_owner;?>" name="e_book_by" type="text" id="e_book_by"  value="<?php echo $a_data['ebook_by'];?>" >
</div>
</div>

<div class="form-group row " >
<label for="pageFile" class="col-sm-12 control-label"><b><?php echo 'ภาพหน้าปก';?>  :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="checkbox">
  <label><input type="checkbox" name="show_image" id="show_image" value="1" onclick="JSChange(this.id);" >
  <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>เปลี่ยนรูป
  </label>
</div>
<div class="file-upload-drag " id="old-image" >
<img src="<?php echo $destPage.$a_data['ebook_cover'];?>" alt="" class="img-rounded img-responsive file-upload-image-old" />
</div>

<div class="file-upload-drag " id="news-image" style="display:none;" >
  <div class="image-upload-wrap"> 
    <input class="file-upload-input" name="pageFile" id="pageFile" type="file" onchange="readURL(this);JSCheck_Img(this.id,this.value);" accept="image/*" />
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
	
</div>		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQEdit_Ebook($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?php echo $txt_ewt_save;?> 
</button>
</div>
</div>
</div>
</div>
</div>
 </div>
</div>	 
</form>
	
<script>  
$(document).ready(function() {

	$('.selectpicker').selectpicker();	
	
});
$(document).on("change","#size", function() {	
		//let  size = $("[name=size]:checked").val();
		let  	size = $('#size :selected').val();
		const  myArr = size.split("##");
		//alert(myArr); 
		$("#e_book_size_width").val(myArr[0]);
		$("#e_book_size_height").val(myArr[1]); 
		 
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
		}else if($( '#'+ID ).is(':checked') == false){
			$('#news-image').hide();
			$('#old-image').show();
		}
}  
function JQEdit_Ebook(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({ 
						title: '<?php echo $txt_ebook_list_edit;?>',
						content: '<?php echo $txt_ewt_confirm_alert;?> ',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'far fa-question-circle',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: '<?php echo $txt_ewt_confirm_submit;?>',
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
													title: '<?php echo $txt_ewt_action_alert;?>',
													theme: 'modern',
													content: '',
													boxWidth: '30%',
													onAction: function () {
														self.location.href="ebook_list_builder.php?"+data;		
														//location.reload(true);														
														$('#box_popup').fadeOut();
													}		
												});
																										
												
											}
										});																										
									}								
							
								},
								cancel: {
									text: '<?php echo $txt_ewt_cancel;?>',
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