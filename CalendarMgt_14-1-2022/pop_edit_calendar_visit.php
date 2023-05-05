<?php
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
include("../language.php");
include("../language/language_TH.php");
include("../lib/config_path.php");

$reg_id = (int)(!isset($_GET['reg_id']) ? 0 : $_GET['reg_id']);
$reg_id = ready($reg_id);

$_sql = $db->query("SELECT * FROM cal_register_visit WHERE reg_id = '$reg_id'");
$a_data = $db->db_fetch_array($_sql);	

$time_array = array();

$time_data = $db->query("SELECT * FROM cal_register_time ORDER BY time_start, time_end");
while($time_info = $db->db_fetch_array($time_data)){
	array_push($time_array,$time_info);
}	

?>

<form id="form_main" name="form_main" method="POST" action="func_calendar_visit.php" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="edit_calendar_visit">
<input type="hidden" name="reg_id" id="reg_id"  value="<?php echo $a_data["reg_id"]; ?>">
<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x"></i></button>
<h4 class="modal-title"> แก้ไขรายการเยี่ยมชม</h4>
</div>

<div class="modal-body">

	<div class="card ">
	<div class="scrollbar scrollbar-near-moon thin">
		<div class="card-header ewt-bg-success m-b-sm" >
			<div class="card-title text-left"><b></b></div>
		</div>

		<div class="card-body" >

			<div class="form-group row " >
				
				<label for="reg_approve"><b>อนุมัติการเข้าชม </b></label> :   
				<div >
				<label class="switch">
				<input type="checkbox" value="Y" name="reg_approve" id="reg_approve" <?php if($a_data["reg_approve"]=="Y"){echo "checked";} ?>>
				<span class="slider round"></span>
				<span class="absolute-no">NO</span>
				</label>
			</div>

			<div class="form-group row " >
				<div class="col-md-6 col-sm-6 col-xs-12" >
					<label for="reg_date"><b>วันที่ : </b></label>
						<div class='input-group date datepicker' id='txt_calendar_enddate_show'>
							<input readonly type='text' class="form-control " placeholder=""  name="reg_date"  id="reg_date" 
									value="<?php echo $a_data["reg_date"]; ?>" >
							<span class="input-group-addon ewt-bg-color color-white border-ewt">
								<i class="far fa-calendar-alt"></i>
							</span>
						</div>
				</div>

				<div class="col-md-6 col-sm-6 col-xs-12" >
					<label for="reg_trim"><b>เวลา : </b></label>
						<select class="form-control " name="reg_time"  id="reg_time">
							<?php
							foreach($time_array AS $time){
							?>
							<option value="<?php echo $time["time_id"]; ?>"
								<?php if($a_data["reg_time"]==$time["time_id"]){echo "selected"; } ?>
							><?php echo $time["time_start"]." - ".$time["time_end"]; ?></option>
							<?php
							}
							?>
						</select>
				</div>
			</div>




		</div>
	</div>	
</div>
		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQEdit_Calendar($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?=$txt_ewt_save;?>
</button>
</div>
</div>
</div>

</div>
 
</div>
</div>	 
</form>
<!-- Custom js -->
<script type="text/javascript" src="<?=$IMG_PATH;?>assets/js/custom.js"></script>		
<script>  

var today = new Date();
$('.datepicker').datepicker({
		format: 'yyyy-mm-dd',
		todayHighlight: true,
		//language: 'th-th',
		//thaiyear: true,
		leftArrow: '<i class="fas fa-angle-double-left"></i>',
		rightArrow: '<i class="fas fa-angle-double-right"></i>',
	})
	//.datepicker("setDate", "0"); 
	//.datepicker("setDate", today.toLocaleDateString());  	


function JQCheck_SetRegis(form){
	var name  = form.attr('name'); 
	var check = $('input:checkbox[name='+name+']:checked').val();	
	if(check == 'Y'){
		$('#c_num').show();
		$('#calendar_num').attr("required",true);

		}else{
			$('#c_num').hide();
			$('#calendar_num').attr("required",false);
			
		}	
	console.log(check);
}

function JQEdit_Calendar(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: '<?=$txt_calendar_edit;?>',
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
												//self.location.href="article_list.php?cid="+data;											
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