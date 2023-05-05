<?php
include("../EWT_ADMIN/comtop_pop.php");

$m_id = (!isset($_GET['m_id']) ? 0 : $_GET['m_id']); 
$_sql = $db->query("SELECT * FROM menu_list WHERE m_id = '{$m_id}' ");
$a_data = $db->db_fetch_array($_sql);	
?>

<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_edit_menu'); ?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Edit_Menu">
<input type="hidden" name="m_id" id="m_id"  value="<?php echo $m_id;?>">
<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x  color-white"></i></button>
<h4 class="modal-title color-white"><i class="fas fa-plus-circle"></i> <?php echo $txt_menu_edit ;?></h4>
</div>

<div class="modal-body">
<div class="card ">
<div class="card-body" >

<div class="scrollbar scrollbar-near-moon thin"> 

<div class="form-group row " >
<div class="col-md-12 col-sm-12 col-xs-12" >
<label for="menu_show"><b><?php echo "สถานะการเปิด/ปิดการใช้งาน";?> </b></label> :   
<div >
<label class="switch">
  <input type="checkbox" value="Y" name="menu_show" id="menu_show" <?php if($a_data['m_show'] == 'Y'){ echo 'checked="checked"'; } ?> />
  <span class="slider round"></span>
  <span class="absolute-no">NO</span>
</label>
</div>
</div>
</div>

<div class="form-group row " >
<label for="menu_title" class="col-sm-12 control-label"><b><?php echo $txt_menu_name;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input class="form-control" placeholder="<?php echo $txt_menu_name;?>" id="menu_title" name="menu_title" required="required" value="<?php echo $a_data['m_name'];?>">
</div>
</div>

</div>		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQAdd_Menu($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?php echo $txt_ewt_save;?>
</button>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>	 
</form>	
<script>  
function JQAdd_Menu(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: '<?php echo $txt_menu_edit;?>',
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
												//console.log(data);
												$.alert({
													title: '',
													theme: 'modern',
													content: 'บันทึกข้อมูลเรียบร้อย',
													boxWidth: '30%',
													onAction: function () {
														//self.location.href="menu_builder.php?m_id="+data;		
														location.reload(true);	
														//$("#frm_edit_s").load(location.href + " #frm_edit_s");
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
									$('#box_popup').fadeOut(); 	
									}									
								}
							},                          
                            animation: 'scale',
                            type: 'blue'
						
						});
					} 
								
}
</script>