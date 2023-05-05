<?php
include("../EWT_ADMIN/comtop_pop.php");

$cat_id = (int)(!isset($_GET['cat_id']) ? 0 : $_GET['cat_id']);
function getCateType($_type)
{	
	if($_type == '1') 
	{
		$_text = 'ปฎิทินกิจกรรม';
	}
	else if($_type == '2')
	{
		$_text = 'ปฎิทินผู้บริหาร'; 
	}	
	return ' '.$_text.''; 
}
$_sql = $db->query("SELECT * 
					FROM cal_category 
					WHERE webname_site = '{$_SESSION['EWT_SUSER']}' AND cat_id = '{$cat_id}'
					");
					
$a_data = $db->db_fetch_array($_sql);
?>
 
<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_edit_calendar_group')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Edit_Cate">
<input type="hidden" name="cat_id" id="cat_id"  value="<?php echo $cat_id;?>">
<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header  ewt-bg-color b-t-l-6 b-t-r-6"> 
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x color-white"></i></button>
<h4 class="modal-title color-white"><i class="far fa-edit" aria-hidden="true"></i> <?php echo $txt_calendar_edit_cate;?></h4>
</div>

<div class="modal-body">

<div class="card ">
<div class="card-body" >

<div class="form-group row " >
<label for="category_title" class="col-sm-12 control-label"><b><?php echo $txt_calendar_cate_title;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input class="form-control" placeholder="<?php echo $txt_calendar_cate_title;?>" name="category_title" type="text" id="category_title"  value="<?php echo $a_data['cat_name'];?>" required="required" >
</div>
</div>

<div class="form-group row " >
<label for="category_color" class="col-sm-12 control-label"><b><?php echo $txt_calendar_cate_color;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input type="text"   value="<?php echo $a_data['cat_color'];?>" placeholder="<?php echo $txt_calendar_cate_color;?>" name="category_color" id="category_color" class="pick-a-color form-control"  required="required"   >
</div>
</div>

<div class="form-group row " >
<label for="category_color" class="col-sm-12 control-label"><b><?php echo 'ประเภท';?> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<p><?php echo getCateType($a_data['cat_type']);?> </p>
</div>
</div>
<?php if($a_data['cat_type'] == '2'){ ;?>
<div class="form-group row " id="invite" >  
<label for="calendar_manager" class="col-sm-12 control-label"><b><?php echo 'ผู้บริหาร';?> :</b></label>   
<div class="col-md-12 col-sm-12 col-xs-12" >
<?php
$dir_base = "../ewt/".$_SESSION['EWT_SUSER']."/assets/images/calendar/";
$_sql_user = $db->query("	SELECT * 
							FROM cal_manager 
						    WHERE m_id = {$a_data['cat_manager']}
							
						");
$a_data_user = $db->db_fetch_array($_sql_user);
	if($a_data_user['m_images'])
	{
		$a_data_user['m_images'] = $dir_base.$a_data_user['m_images'];
	}
	else
	{
		$a_data_user['m_images'] = '../EWT_ADMIN/images/user001.png';   
	}
?>  
<span class='text-default'><img src='<?php echo $a_data_user['m_images'];?>' alt='' class='img-circle img-rounded ' style='width:50px;height:50px;'> <?php echo $a_data_user['m_name']; ?> <?php echo $a_data_user['m_surname']; ?></span> 
</div>
</div> 
<?php } ?>
</div>
</div>	

</div>		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQEdit_Calendar_Group($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
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

$('.pick-a-color').pickAColor({
			  showSpectrum            	: true,
				showSavedColors         : true,
				saveColorsPerElement    : true,
				fadeMenuToggle          : true,
				showAdvanced			: true,
				showBasicColors         : true,
				showHexInput            : true,
				allowBlank				: true,
				inlineDropdown			: true
			});
			
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

function JQEdit_Calendar_Group(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: '<?php echo $txt_calendar_edit_cate;?>',
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
													title: '',
													theme: 'modern',
													icon: 'far fa-check-circle',
													content: 'บันทึกข้อมูลเรียบร้อย! ',
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