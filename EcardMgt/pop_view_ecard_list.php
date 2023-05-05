<?php
include("../EWT_ADMIN/comtop_pop.php"); 
$ec_id = (int)(!isset($_GET['ec_id']) ? '' : $_GET['ec_id']);
if(empty($ec_id))
{
	exit;
}
$_sql = $db->query("SELECT * FROM ecard_list WHERE ec_id = '{$ec_id}'");  
$a_data = $db->db_fetch_array($_sql);
$dir_base = "../ewt/".$_SESSION['EWT_SUSER']."/assets/images/ecard/"; 
?>
<form id="form_main" name="form_main" method="POST" action="" enctype="multipart/form-data" >

<div class="container" >    
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">    
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x color-white"></i></button>
<h4 class="modal-title color-white"><i class="fas fa-plus-circle"></i> <?php echo 'การ์ดอวยพร';?></h4> 
</div>

<div class="modal-body">
<div class="card ">
<div class="card-body" >
<?php 
if(file_exists($dir_base.$a_data['ec_filename']) && $a_data['ec_filename'] != ''){
?>
<img src="<?php echo $dir_base.$a_data['ec_filename'];?>" alt="" class="img-rounded img-responsive file-upload-image-old" >
<?php } ?>

</div>
</div>
</div>	
	
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="$('#box_popup').fadeOut();" type="button" class="btn btn-warning  btn-ml">
<i class="fas fa-times-circle fa-1x"></i>&nbsp;<?php echo 'ปิด';?>
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

function JQAdd_Card(form){  	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: '<?php echo "เพิ่มการ์ดอวยพร";?>', 
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