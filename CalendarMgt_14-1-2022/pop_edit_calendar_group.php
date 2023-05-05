<?php
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
include("../language.php");
include("../language/language_TH.php");
include("../lib/config_path.php");



$cat_id = (int)(!isset($_GET['cat_id']) ? 0 : $_GET['cat_id']);

$_sql = $db->query("SELECT * 
					FROM cal_category 
					WHERE webname_site = '{$_SESSION['EWT_SUSER']}' AND cat_id = '{$cat_id}'
					");
					
$a_data = $db->db_fetch_array($_sql);
?>

<form id="form_main" name="form_main" method="POST" action="<?=getLocation('func_edit_calendar_group')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Edit_Cate">
<input type="hidden" name="cat_id" id="cat_id"  value="<?=$cat_id;?>">
<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x"></i></button>
<h4 class="modal-title"> <?=$txt_calendar_edit_cate;?></h4>
</div>

<div class="modal-body">

<div class="card ">
<div class="scrollbar scrollbar-near-moon thin">
<div class="card-header ewt-bg-success m-b-sm" >
<div class="card-title text-left"><b></b></div>
</div>

<div class="card-body" >

<div class="form-group row " >
<label for="category_title" class="col-sm-12 control-label"><b><?=$txt_calendar_cate_title;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input class="form-control" placeholder="<?=$txt_calendar_cate_title;?>" name="category_title" type="text" id="category_title"  value="<?=$a_data['cat_name'];?>" required="required" />
</div>
</div>

<div class="form-group row " >
<label for="category_color" class="col-sm-12 control-label"><b><?=$txt_calendar_cate_color;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input type="text" value="<?=$a_data['cat_color'];?>" placeholder="<?=$txt_calendar_cate_color;?>" name="category_color" id="category_color" class="pick-a-color form-control"  required="required"  />
</div>
</div>

<!--<div class="form-group row " >
<label for="category_order" class="col-sm-12 control-label"><b><?=$text_genfaq_categorystep;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-2 col-sm-2 col-xs-12" >
<input class="form-control checknumber" placeholder="<?=$text_genfaq_categorystep;?>" name="category_order" type="text" id="category_order"  value="" required="required" />
</div>
</div>-->

</div>
</div>	
</div>
		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQEdit_Calendar_Group($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
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
$(document).ready(function() {

$('.pick-a-color').pickAColor({
			  showSpectrum            : true,
				showSavedColors         : true,
				saveColorsPerElement    : true,
				fadeMenuToggle          : true,
				showAdvanced						: true,
				showBasicColors         : true,
				showHexInput            : true,
				allowBlank							: true,
				inlineDropdown					: true
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
						title: '<?=$txt_calendar_edit_cate;?>',
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
													content: 'ส่งข้อมูลตอบกลับเรียบร้อย',
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