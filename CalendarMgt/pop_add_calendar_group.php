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

<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_add_calendar_group')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Add_Cate">
<input type="hidden" name="s_cat_color" id="s_cat_color"  value="<?php echo $s_cat_color;?>">

<div class="container" >    
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">    
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x color-white"></i></button>
<h4 class="modal-title color-white"><i class="fas fa-plus-circle"></i> <?php echo $txt_calendar_add_cate;?></h4> 
</div>

<div class="modal-body">

<div class="card ">
<div class="card-body" >

<div class="form-group row " >
<label for="category_title" class="col-sm-12 control-label"><b><?php echo $txt_calendar_cate_title;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input class="form-control" placeholder="<?php echo $txt_calendar_cate_title;?>" name="category_title" type="text" id="category_title"  value="" required="required" />
</div>
</div>

<div class="form-group row " >
<label for="category_color" class="col-sm-12 control-label"><b><?php echo $txt_calendar_cate_color;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input type="text" value="" placeholder="<?php echo $txt_calendar_cate_color;?>" name="category_color" id="category_color"  class="pick-a-color form-control"  required="required"  />
</div>
</div>

<div class="form-group row " >
<label for="category_type" class="col-sm-12 control-label"><b><?php echo 'ประเภท';?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="radio b-sm">  
  <label><input type="radio" name="category_type" id="category_type" value="1" checked ><?php echo 'ปฎิทินกิจกรรม';?>
  <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
  </label>

  <label><input type="radio" name="category_type" id="category_type"  value="2"  ><?php echo 'ปฎิทินผู้บริหาร';?> 
  <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
  </label>
</div>

</div>
</div>
<div class="form-group row " id="invite" >  
<label for="calendar_manager" class="col-sm-12 control-label"><b><?php echo 'ผู้บริหาร';?> <span class="text-danger"><code>*</code></span> : </b></label>  
<div class="col-md-12 col-sm-12 col-xs-12" >
<select name="calendar_manager" id="calendar_manager" class="selectpicker form-control" data-live-search="true" title="<?php echo 'เลือกผู้บริหาร';?>"  data-size="10"  data-actions-box="true">  
<?php
$dir_base = "../ewt/".$_SESSION['EWT_SUSER']."/assets/images/calendar/";
// SELECT * FROM cal_manager WHERE m_id NOT IN(SELECT cat_manager FROM cal_category WHERE cat_manager IS NOT NULL) ORDER BY cal_manager.m_id DESC
$_sql_user = $db->query("SELECT * FROM cal_manager ORDER BY cal_manager.m_id DESC");
while($a_data_user = $db->db_fetch_array($_sql_user))  
{
		if($a_data_user['m_images'])
		{
			$a_data_user['m_images'] = $dir_base.$a_data_user['m_images'];
		}
		else
		{
			$a_data_user['m_images'] = '../EWT_ADMIN/images/user001.png';   
		}
	//$sel = ($a_data_cat[0] == trim($a_data['cat_id'])) ? "selected":"";  
?>   
<option  data-content="<span class='text-default'><img src='<?php echo $a_data_user['m_images'];?>' alt='' class='img-circle img-rounded ' style='width:20px;height:20px;'> <?php echo $a_data_user['m_name']; ?> <?php echo $a_data_user['m_surname']; ?></span>" value="<?php echo $a_data_user['m_id'];?>" <?php echo $sel;?> ><?php echo $a_data_user['name_thai']; ?> <?php echo $a_data_user['surname_thai']; ?></option>
<?php 
	}
	
?>		  
</select>

</div>
</div>

<!--<div class="form-group row " >
<label for="category_order" class="col-sm-12 control-label"><b><?php echo $text_genfaq_categorystep;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-2 col-sm-2 col-xs-12" >
<input class="form-control checknumber" placeholder="<?php echo $text_genfaq_categorystep;?>" name="category_order" type="text" id="category_order"  value="" required="required" />
</div>
</div>-->

</div>
</div>
</div>	
	
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQAdd_Calendar_Group($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
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
$('.selectpicker').selectpicker(); 	  
$('#invite').hide();
$('.pick-a-color').pickAColor({
				showSpectrum            : true,
				showSavedColors         : true,
				saveColorsPerElement    : true,
				fadeMenuToggle          : true,
				showAdvanced			: true,
				showBasicColors         : true,
				showHexInput            : true,
				allowBlank				: true,
				inlineDropdown			: true
			});
	
//$('#category_color').keydown(function(){
//var data = $('#s_cat_color').val();

var jQueryArray = <?php echo json_encode($s_cat_color); ?>;
	console.log(jQueryArray);
	
//});

//$('.pick-a-color').on('click', function(event){
//var check = $('#category_color').val();	
		//alert(check);
	//});
	
	$(document).on("change", "[id^='category_type']", function() {
		let  Type = $('[id^="category_type"]:checked').val();
        JQCheck_Type(Type);
    });		
	
});

function JQCheck_Type(id) 
{	
	if(id == '2')
	{
		$('#invite').show();
		$('#calendar_manager').attr("required",true);
	}
	else
	{
		$('#invite').hide();
		$('#calendar_manager').attr("required",false);
	}	
}

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

function JQAdd_Calendar_Group(form){ 	
	$('#loader').fadeIn();	
	var fail = CKSubmitData(form);
	if (fail == false) {	
	var action  = form.attr('action'); 
	var method  = form.attr('method'); 
	var formData = false;
	if (window.FormData){
		formData = new FormData(form[0]);
	} 														
			 $.confirm({
						title: '<?php echo $txt_calendar_add_cate;?>',
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
												$("#loader").fadeOut(5000);  
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