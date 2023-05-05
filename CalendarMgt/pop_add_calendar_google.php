<?php
include("../EWT_ADMIN/comtop_pop.php");


$info_id = (int)(!isset($_GET['info_id']) ? '' : $_GET['info_id']);

$s_site_info = "SELECT * FROM site_info_embed WHERE site_embed_name = 'Facebook-Messenger' ";
$s_query = $db->query($s_site_info);
$a_data = $db->db_fetch_array($s_query);
?>

<form id="form_main" name="form_main" method="POST" action="<?=getLocation('func_add_calendar_google')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Add_Cal_Google">


<div class="container" id="frm_edit_s">   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x"></i></button>
<h4 class="modal-title"><img src="<?=$IMG_PATH ;?>images/icons8-google-calendar-96.png" _class="animated fadeInDown " style="height: 32px;width:32px;">  
 <?=$txt_calendar_google;?></h4>
</div>

<div class="modal-body">
<div class="card ">
<div class="scrollbar scrollbar-near-moon thin">
<div class="card-body" >
<div class="form-group row " >
<label for="google_title" class="col-sm-12 control-label"><b><?='Title Google Calendar';?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input class="form-control" placeholder="<?='Title Google Calendar';?>" name="google_title" type="text" id="google_title"  value="" required="required" />
</div>
</div>
<div class="form-group row">
<label for="use_status"><b><?="เปิดการใช้งาน Google Calendar";?> :</b></label>  
<div class="col-md-12 col-sm-12 col-xs-12">
<label class="switch">
  <input type="checkbox" value="Y" name="use_status" id="use_status"  />
  <span class="slider round"></span>
  <span class="absolute-no">NO</span>
</label>
</div>
</div>

<div class="form-group row">
<label for="code"><b><?="Google Calendar Link Embed";?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12"> 
<textarea name="code" cols="60" rows="8"  id="code" class="form-control" required="required" ><?//=html_entity_decode($a_data['site_embed_code'], ENT_QUOTES, "UTF-8");?></textarea>
<span class="text-danger">Ex.https://calendar.google.com/calendar/embed?src=designer.bizpotential@gmail.com&ctz=Asia_FBangkok
</div>
</div>


</div>
</div>	
</div>
		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQAdd_Google_Calendar($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?=$txt_ewt_save;?>
</button>
</div>
</div>
</div>

</div>
 
</div>
</div>	 
</form>

<script> 

function JQCheck_Cate(form){
	var name  = form.attr('name'); 
	var type_data = $('input:radio[name='+name+']:checked').val();
	
	if(type_data == '0'){
		$('#show_complain_category').hide();
		$('#complain_category').attr("disabled",true);
		$('#complain_category').attr("required",false);
		}else{
			$('#show_complain_category').show();
			$('#complain_category').attr("disabled",false);
			$('#complain_category').attr("required",true);
		}	
	console.log(type_data);
}
 
function JQAdd_Google_Calendar(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: '<?=$txt_calendar_google;?>',
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
													title: '',
													theme: 'modern',
													content: 'บันทึกข้อมูลเรียบร้อย',
													boxWidth: '30%',
													onAction: function () {
														//self.location.href="complain_builder.php?com_fid="+data;			
														location.reload(true);	
														//$("#frm_edit_s").load(location.href + " #frm_edit_s");
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

function JQAdd_Site_Info(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: '<?=$txt_site_set_info;?>',
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
													title: '',
													theme: 'modern',
													content: 'บันทึกข้อมูลเรียบร้อย',
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