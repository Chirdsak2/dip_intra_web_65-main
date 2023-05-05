<?php
include("../EWT_ADMIN/comtop_pop.php");

$com_eid = (int)(!isset($_GET['com_eid']) ? 0 : $_GET['com_eid']);
$com_fid = (int)(!isset($_GET['com_fid']) ? 0 : $_GET['com_fid']);

/*echo "SELECT * 
					FROM  m_complain_form_element 
					LEFT JOIN m_complain_form_info ON (m_complain_form_info.com_ele_id = m_complain_form_element.com_ele_id)
					WHERE m_complain_form_element.com_ele_fid = '{$com_fid}' AND m_complain_form_element.com_ele_id = '{$com_eid}' ";*/
$_sql = $db->query("SELECT * 
					FROM  m_complain_form_info				
					WHERE m_complain_form_info.com_ele_fid = '{$com_fid}' AND m_complain_form_info.com_ele_id = '{$com_eid}' ");			  
$a_rows = $db->db_num_rows($_sql);	
$a_data = $db->db_fetch_array($_sql);
?>

<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_add_setting_item')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Add_Set_Item" />
<input type="hidden" name="com_eid" id="com_eid"  value="<?php echo $com_eid;?>" />
<input type="hidden" name="com_fid" id="com_fid"  value="<?php echo $com_fid;?>" />

<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x color-white"></i></button>
<h4 class="modal-title color-white"> <?php echo $txt_complain_setting;?></h4>
</div>

<div class="modal-body">

<div class="card ">
<div class="scrollbar scrollbar-near-moon thin">
<div class="card-header " >
<div class="card-title text-left"><b></b></div> 
</div>

<div class="card-body" >

<div class="form-group row " >
<label for="complain_label" class="col-sm-12 control-label"><b><?php echo $txt_complain_set_lable;?> <span class="text-danger"></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input class="form-control" placeholder="<?php echo $txt_complain_set_lable;?>" name="complain_label" type="text" id="complain_label"  value="<?php echo $a_data['com_info_label'];?>"  />
</div>
</div>

<div class="form-group row " >
<label for="complain_help" class="col-sm-12 control-label"><b><?php echo $txt_complain_set_help;?> <span class="text-danger"></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input class="form-control" placeholder="<?php echo $txt_complain_set_help;?>" name="complain_help" type="text" id="complain_help"  value="<?php echo $a_data['com_info_help'];?>"  />
</div>
</div>


<div class="form-group row " >
<label for="complain_required" class="col-sm-12 control-label"><b><?php echo $txt_complain_set_required;?> <span class="text-danger"></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="checkbox">
          <label>
			<input  name="complain_required" id="complain_required" type="checkbox" value="Y" <?php if($a_data['com_info_required'] == 'Y'){ echo 'checked="checked"';}?> />
            <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
			<?php echo $txt_complain_set_required;?>
          </label>
</div>
</div>
</div>




</div>
</div>	
</div>
		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQAdd_Complain_Item($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?php echo $txt_ewt_save ;?>
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
	var check = $('input:checkbox[name='+name+']:checked').val();	
	if(check == 'Y'){
		$('#category_sub').attr("disabled",false);
		}else{
			$('#category_sub').attr("disabled",true);
		}	
	console.log(check);
}

$(function () {
      $('.icp-dd').iconpicker({
        //title: 'Dropdown with picker',
        //component:'.btn > i'
			
      });
});
function JQAdd_Complain_Item(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: '<?php echo $txt_complain_setting;?>',
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
																
														//location.reload(true);			
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
function JQAdd_Menu_Item(form){	
var vcal = $('#icon_fa').attr("class");
	$('#menu_icon').val(vcal);
	//alert(vcal);
var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 
console.log(form.serialize());  
 
			 /*$.confirm({
						title: '<?php echo "เพิ่มหมวด FAQ";?>',
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
														document.location.reload();
														$('#box_popup').fadeOut();
													}													
												});
												//$("#frm_edit_s").load(location.href + " #frm_edit_s");
												//alert("Data Save: " + data);												
												//self.location.href="article_list.php?cid="+data;											
												//$('#box_popup').fadeOut();
												
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
						
						});*/
					} 
								
}	
</script>