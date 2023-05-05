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

<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_add_webboard_room')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Add_WB_Room">

<div class="container" >    
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">    
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x color-white"></i></button>
<h4 class="modal-title color-white"><i class="fas fa-plus-circle"></i> <?php echo $txt_webboard_new_room;?></h4> 
</div>

<div class="modal-body">
<div class="card ">
<div class="card-body" >
<div class="form-group row " >
<div class="col-md-12 col-sm-12 col-xs-12" >
<label for="ec_status"><b><?php echo "สถานะการเปิด/ปิดการใช้งาน";?> </b></label> :   
<div >
<label class="switch">
  <input type="checkbox" value="Y" name="ec_status" id="ec_status" <?php if($a_data['ec_status'] == 'Y' || $a_data['ec_status'] == ''){ echo 'checked="checked"'; } ?>>
  <span class="slider round"></span>
  <span class="absolute-no">NO</span>
</label>
</div>
</div>
</div>
<div class="form-group row " >
<label for="c_name" class="col-sm-12 control-label"><b><?php echo ' ชื่อหมวดกระทู้';?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<textarea class="form-control" placeholder="<?php echo 'ชื่อหมวดกระทู้';?>"  rows="3" id="c_name" name="c_name"  required="required" ></textarea>
</div>
</div>
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12"> 
<label for="c_detail" class="col-sm-12 control-label"><b><?php echo 'รายละเอียด';?> <span class="text-danger"><code>*</code></span> :</b></label>
<textarea class="form-control" placeholder="<?php echo 'รายละเอียด';?>"  rows="3" id="c_detail" name="c_detail" required="required"></textarea>
</div>
</div>
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12"> 
<label for="c_view" class="col-sm-12 control-label"><b><?php echo 'สิทธิ์ในการเข้าดูกระทู้ในหมวดนี้';?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="radio b-sm">  
	<label><input type="radio" name="c_view" id="c_view" value="1"><?php echo 'ไม่ต้อง Login';?>
	<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
	</label>
	<label><input type="radio" name="c_view" id="c_view"  value="2" checked><?php echo 'ต้อง  Login';?>
	<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
	</label>
</div>
</div>
</div>

<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12"> 
<label for="c_question" class="col-sm-12 control-label"><b><?php echo 'สิทธิ์ในการตั้งกระทู้ในหมวดนี้';?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="radio b-sm">  
	<label><input type="radio" name="c_question" id="c_question" value="1"><?php echo 'ไม่ต้อง Login';?>
	<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
	</label>
	<label><input type="radio" name="c_question" id="c_question"  value="2" checked><?php echo 'ต้อง  Login';?>
	<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
	</label>
</div>
</div>
</div>

<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12"> 
<label for="c_answer" class="col-sm-12 control-label"><b><?php echo 'สิทธิ์ในการตอบกระทู้ในหมวดนี้';?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="radio b-sm">  
	<label><input type="radio" name="c_answer" id="c_answer" value="1"><?php echo 'ไม่ต้อง Login';?>
	<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
	</label>
	<label><input type="radio" name="c_answer" id="c_answer"  value="2" checked><?php echo 'ต้อง  Login';?>
	<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
	</label>
</div>
</div>
</div>

<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12"> 
<label for="c_viewporf" class="col-sm-12 control-label"><b><?php echo 'สิทธิ์ในการดาวน์โหลดไฟล์ในหมวดนี้';?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="radio b-sm">  
	<label><input type="radio" name="c_viewporf" id="c_viewporf" value="1"><?php echo 'ไม่ต้อง Login';?>
	<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
	</label>
	<label><input type="radio" name="c_viewporf" id="c_viewporf"  value="2" checked><?php echo 'ต้อง  Login';?>
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
<button onclick="JQAdd_WB_Room($('#form_main'));" type="button" class="btn btn-success  btn-ml">
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

function JQAdd_WB_Room(form){  	
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
						title: '<?php echo $txt_webboard_new_room;?>',  
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