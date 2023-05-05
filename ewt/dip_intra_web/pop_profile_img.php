<?php
include("../EWT_ADMIN/comtop_pop.php");

$info_id = (int)(!isset($_GET['info_id']) ? '' : $_GET['info_id']);

$s_site_info = "SELECT * FROM site_info";
$query = $db->query($s_site_info);
$rec = $db->db_fetch_array($query);

?>

<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_set_site_info')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Set_Site_Info">
<input type="hidden" name="info_id" id="info_id"  value="<?php echo $info_id;?>">
<input type="hidden" name="site_info_id" id="site_info_id"  value="<?php echo $rec['site_info_id'];?>">
<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6"> 
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x fa-1x  color-white"></i></button>
<h4 class="modal-title color-white"><i class="fas fa-cogs" aria-hidden="true"></i> <?php echo $txt_site_set_info;?></h4>
</div>

<div class="modal-body">
<div class="card ">
<div class="scrollbar scrollbar-near-moon thin">
<div class="card-body" >


</div>
</div>	
</div>
		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQAdd_Site_Info($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?php echo $txt_ewt_save;?>
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
 
function JQAdd_Complain_Form(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: '<?php echo $txt_complain_add_form;?>',
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
														self.location.href="complain_builder.php?com_fid="+data;			
														//location.reload(true);			
														//$('#box_popup').fadeOut();
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
						title: '<?php echo $txt_site_set_info;?>',
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

												data = JSON.parse(data);												
												//console.log(data);

												if(data[0].flag=="error"){

													$("#"+data[0].data_array.focus).focus();
													
													$.alert({
														title: data[0].data_array.title,
														content: data[0].data_array.content,
														icon: 'fa fa-exclamation-circle',
														theme: 'modern',                          
														type: 'orange',
														closeIcon: false,						
														buttons: {
															close: {
																text: 'ปิด',
																btnClass: 'btn-orange',
															}
														},						
													});	
												}
												else if(data[0].flag=="success"){
												
													$.alert({
														title: '',
														theme: 'modern',
														content: 'บันทึกข้อมูลเรียบร้อย',
														boxWidth: '30%',
														onAction: function () {
															location.reload(true);			
															$('#box_popup').fadeOut();
														}		
													});
												}

												
											}
										});																										
									}								
							
								},
								cancel: {
									text: 'ยกเลิก',
									action: function () {
									}									
								}
							},                          
                            animation: 'scale',
                            type: 'blue'
						
						});
					} 
								
}
</script>