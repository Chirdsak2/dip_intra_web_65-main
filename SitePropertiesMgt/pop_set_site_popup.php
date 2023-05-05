<?php
include("../EWT_ADMIN/comtop_pop.php");


$info_id = (int)(!isset($_GET['info_id']) ? '' : $_GET['info_id']);

$s_site_info = "SELECT * FROM site_info_popup WHERE site_popup_name = 'banner' ";
$s_query = $db->query($s_site_info);
$a_data_popup = $db->db_fetch_array($s_query);
$site_popup_code =  $a_data_popup['site_popup_code'];
?>

<form id="form_main" name="form_main" method="POST" action="<?=getLocation('func_set_site_popup')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Set_Banner_Popup">
<input type="hidden" name="popup_name" id="popup_name"  value="banner">

<div class="container" id="frm_edit_s">   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x"></i></button>
<h4 class="modal-title">
<span class="fa-stack fa-lg">
  <i class="fa fa-circle fa-stack-2x"></i>
  <i class="far fa-images fa-stack-1x fa-inverse"></i>
</span>

 <?="Banner Pop up";?></h4>
</div>

<div class="modal-body">
<div class="card ">
<div class="scrollbar scrollbar-near-moon thin">
<div class="card-body" >
<div class="form-group row">
<label for="use_status"><b><?="เปิดการใช้งาน Banner Pop up";?> :</b></label>  
<div class="col-md-12 col-sm-12 col-xs-12">
<label class="switch">
  <input type="checkbox" value="Y" name="use_status" id="use_status" <?php if($a_data_popup['site_popup_status'] == 'Y'){ echo 'checked="checked"'; } ?> />
  <span class="slider round"></span>
  <span class="absolute-no">NO</span>
</label>
</div>
</div>

<div class="form-group row">
<label for="code"><b><?="Banner";?> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12"> 
<ul id="sortableLv1-form" class="sortableLv1 " style="width: 100%;">
<?php
$Globals_Dir = "../ewt/".$_SESSION['EWT_SUSER']."/";
$_sql = $db->query("SELECT * FROM banner WHERE banner_gid != '' ORDER BY banner_id DESC ");
$a_rows = $db->db_num_rows($_sql);		

if($a_rows > 0){
$n = 1;
while($a_data = $db->db_fetch_array($_sql)){
	if($a_data['banner_id'] == $site_popup_code){
		$s_chk = 'checked="checked"';
		}else{
			$s_chk = '';
			}	
	if(file_exists($Globals_Dir.$a_data['banner_pic']) AND $a_data['banner_pic']!=''){
?>
<li class="productCategoryLevel1 " >
<div class="radio">
          <label>&nbsp;&nbsp;
			<input name="banner_pic" id="banner_pic<?=$n;?>"  type="radio" value="<?=$a_data['banner_id'];?>" <?=$s_chk;?>  />
            <span class="cr1" ><i class="cr-icon fas fa-check color-ewt"></i></span>&nbsp;<img class="img-thumbnail" src="<?=$Globals_Dir?><?=$a_data['banner_pic']; ?>" style="width:50%;height:auto;" />
          </label>
</div>
</li>
<?php 
} 
$n++; 
} 
	} 
?>
</ul>
</div>
</div>


</div>
</div>	
</div>
		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQAdd_PopupBanner($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
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
 
function JQAdd_PopupBanner(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: '<?="Banner Pop up";?>',
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