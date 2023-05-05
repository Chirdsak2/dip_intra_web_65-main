<?php
include("../EWT_ADMIN/comtop_pop.php"); 
?>
<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_add_webboard_admin')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Add_Admin">

<div class="container" >    
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">    
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x color-white"></i></button>
<h4 class="modal-title color-white"><i class="fas fa-plus-circle"></i> <?php echo 'เพิ่มผู้ดูแลหมวดกระทู้';?></h4> 
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
<label for="a_contact" class="col-sm-12 control-label"><b><?php echo ' ชื่อผู้ดูแลหมวดกระทู้';?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-10 col-sm-10 col-xs-12" >
<a href="#browse" onClick="boxPopup2('<?php echo linkboxPopup();?>pop_webboard_genuser.php');" >
<input class="form-control" placeholder="<?php echo $txt_calendar_contact;?>" name="a_contact" type="text" id="a_contact"  value=""  >
</a> 
</div>
<div class="col-md-2 col-sm-2 col-xs-12 "  >
<span id="txtshow"></span>
<a href="#browse" onClick="boxPopup2('<?php echo linkboxPopup();?>pop_webboard_genuser.php');" >
<button type="button" class="btn btn-info  btn-sm " >
<i class="fas fa-folder-open"></i>&nbsp;<?php echo $txt_calendar_contact;?>
</button>
</a> 
<input name="gen_user_id" type="hidden" id="gen_user_id" value="">
</div>
</div>
<div id="box_popup2" class="layer-modal"></div>

<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12"> 
<label for="c_detail" class="col-sm-12 control-label"><b><?php echo 'หมวดที่ดูแล';?> <span class="text-danger"><code>*</code></span> :</b></label>

<?php $query_cate = $db->query("SELECT * FROM w_cate ORDER BY c_id ASC"); ?>
<td align="left" style="padding: 10px">
<?php while($cate = $db->db_fetch_array($query_cate)){?>
<input name="cate[]" value="<?php echo $cate['c_id'];?>" type="checkbox"> <?php echo $cate['c_name'];?><br>
<?php } ?>
</td> 
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