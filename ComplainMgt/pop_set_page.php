<?php
include("../EWT_ADMIN/comtop_pop.php");

$m_page_id = (int)(!isset($_GET['m_page_id']) ? 0 : $_GET['m_page_id']);


/*echo "SELECT * 
					FROM  m_complain_form_element 
					LEFT JOIN m_complain_form_info ON (m_complain_form_info.com_ele_id = m_complain_form_element.com_ele_id)
					WHERE m_complain_form_element.com_ele_fid = '{$com_fid}' AND m_complain_form_element.com_ele_id = '{$com_eid}' ";*/
$_sql = $db->query("SELECT * 
					FROM  m_complain_form
					WHERE com_form_status = 'Y'
					");			  
$a_rows = $db->db_num_rows($_sql);

	
?>

<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_set_page')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Add_Set_Page" />
<input type="hidden" name="m_page_id" id="m_page_id"  value="<?php echo $m_page_id;?>" />


<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x color-white"></i></button>
<h4 class="modal-title color-white"> <?php echo 'Add Complain Form';?></h4>
</div>

<div class="modal-body">

<div class="card ">
<div class="scrollbar scrollbar-near-moon thin">
<div class="card-header  m-b-sm" >
<div class="card-title text-left"><b></b></div>
</div>

<div class="card-body" >
<ul id="sortableLv1-form" class="sortableLv1 connectedSortable" style="width: 100%;">
<?php
if($a_rows > 0){
$i = 0;
while($a_data = $db->db_fetch_array($_sql)){
	
	$_sql_form  = $db->query("SELECT * 
					FROM  m_complain_page
					WHERE m_page_id  = '{$m_page_id}' AND m_page_form = '{$a_data['com_form_id']}'
					");			  
	$a_rows_form  = $db->db_num_rows($_sql_form);
?>
	
<li class="productCategoryLevel1 " id="<?php echo $a_data['com_form_id'];?>">
<div class="radio">&nbsp;
          <label>
			<input name="com_form_id"  type="radio" value="<?php echo $a_data['com_form_id'];?>" <?php if($a_rows_form > 0){ echo 'checked="checked"';}?> />
            <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>&nbsp;<?php echo $a_data['com_form_title'];?>
					(<?php 
					if($a_data['com_form_type'] == '0')
					{											
						echo $txt_complain_form_type_0;
					}
					else if($a_data['com_form_type'] == '1')
					{					
						echo $txt_complain_form_type_1;
					}
					?>)
		  </label>
</div>
</li>
<?php $i++;} }?>


</ul>

</div>
</div>	
</div>
		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQAdd_Complain_Page($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
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
function JQAdd_Complain_Page(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: '<?php echo 'Setting Complain Form';?>',
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