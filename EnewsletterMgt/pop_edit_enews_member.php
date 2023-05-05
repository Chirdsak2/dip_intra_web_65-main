<?php
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
include("../language.php");
include("../language/language_TH.php");
include("../lib/config_path.php");

$m_id = (int)(!isset($_GET['m_id']) ? 0 : $_GET['m_id']);

$sql_member = $db->query("SELECT * FROM n_member WHERE m_id = '".$m_id."'");
$data_member = $db->db_fetch_array($sql_member);	

$Sel = "select * from n_group,article_group where c_id = g_name and ";
$Sel .= " `n_group`.`g_name` !=  '' order by g_id desc ";	
$_sql = $db->query($Sel);					
//$a_data = $db->db_fetch_array($_sql);	
?>

<form id="form_main" name="form_main" method="POST" action="pop_edit_enews_member_function.php" enctype="multipart/form-data" >
<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x"></i></button>
<h4 class="modal-title"> <?=$txt_enews_edit_user.' ( '.$data_member["m_email"].' )';?></h4>
</div>

<div class="modal-body">

<div class="card ">
<div class="scrollbar scrollbar-near-moon thin">
<div class="card-header ewt-bg-success m-b-sm" >
<div class="card-title text-left"><b></b></div>
</div>

<div class="card-body" >
<div class="form-group row" >
	<div class="col-md-12 col-sm-12 col-xs-12">
		<table width="100%" align="center" class="table table-bordered">
			<form name="form1" method="post" action="pop_edit_enews_member_function.php">
				<?php
				$i = 0;
				while($R = $db->db_fetch_array($_sql)){
				$sqlx = $db->query("SELECT * FROM n_group_member WHERE m_id = '".$m_id."' AND g_id = '".$R["g_id"]."'");
				$row = $db->db_num_rows($sqlx);?>
				<tr bgcolor="<?php //if($row > 0){ echo "#5bc0de"; }else{ echo "#FFFFFF"; } ?>" >
				  <td width="10%" style="text-align:left" > 
						
							<div class="checkbox">&nbsp;&nbsp;
							<label>
							<input type="checkbox" id="chk<?php echo $i; ?>" name="chk<?php echo $i; ?>"  value="Y" <?php  if($row > 0){ echo "checked"; } ?> />
							<span class="cr1"><i class="cr-icon fas fa-check color-ewt"></i></span>&nbsp;<b> <?php echo $R['c_name']; ?></b>
							</label>
							</div>
							<input type="hidden" name="g_id<?php echo $i; ?>" id="g_id<?php echo $i; ?>"  value="<?php echo $R['g_id'];?>">
				  </td>
				 <!--<td width="90%"   style="color:<?php if($row > 0){ echo "#FFFFFF"; }else{ echo ""; } ?>;" > <?php echo $R['c_name'];?></td>-->
				</tr>
				<?php 
				$i++;
				}?>
				
				<input type="hidden" name="all" id="all"  value="<?=$i;?>">
				<input type="hidden" name="m_id" id="m_id"  value="<?=$m_id;?>">
			</form>
		</table>

</div>

</div>

</div>
</div>	
</div>
		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQEdit_Enews($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
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
/*
$(function() {
        $.samaskHtml();
		$('.number').samask("00000");

 var today = new Date();
 $('.datepicker')		
        .datepicker({
            format: 'yyyy-mm-dd',
			todayHighlight: true,
            //language: 'th-th',
			//thaiyear: true,
			leftArrow: '<i class="fas fa-angle-double-left"></i>',
            rightArrow: '<i class="fas fa-angle-double-right"></i>',
        })
		//.datepicker("setDate", "0"); 
		//.datepicker("setDate", today.toLocaleDateString());  	

$('#datetimepicker1').on('changeDate', function() {
		var event_date_start = $('#event_date_start').val();
		var event_date_end = $('#event_date_end').val();
		
		if(event_date_end != ''){
		if(event_date_end < event_date_start){
					$.alert({
						title: 'วันที่เริ่มต้นกิจกรรมไม่ถูกต้อง',
						content: 'กรุณาเลือกวันที่เริ่มต้นกิจกรรมใหม่อีกครั้ง',
						icon: 'fa fa-exclamation-circle',
                        theme: 'modern',                          
                        type: 'orange',
						animation: 'scale',
						closeIcon: false,						
						buttons: {
							close: {
								 text: 'ปิด',
									btnClass: 'btn-orange',
								}
							},						
						});	
				
				$('#event_date_start').val('');		
			}
		}		
	});
	
$('#datetimepicker2').on('changeDate', function() {
		var event_date_start = $('#event_date_start').val();
		var event_date_end = $('#event_date_end').val();
		
		if(event_date_end < event_date_start){
					$.alert({
						title: 'วันที่สิ้นสุดกิจกรรมไม่ถูกต้อง',
						content: 'กรุณาเลือกวันที่สิ้นสุดกิจกรรมใหม่อีกครั้ง',
						icon: 'fa fa-exclamation-circle',
                        theme: 'modern',                          
                        type: 'orange',
						animation: 'scale',
						closeIcon: false,						
						buttons: {
							close: {
								 text: 'ปิด',
									btnClass: 'btn-orange',
								}
							},						
						});	
						$('#event_date_end').val('');		
					}
			});	
			
	

$('#txt_calendar_statdate_show').on('changeDate', function() {
		var start_date = $('#start_date').val();
		var end_date   = $('#end_date').val();
		if(end_date != ''){
		if(end_date < start_date){
					$.alert({
						title: 'วันที่เริ่มต้นการแสดงผลที่ปฏิทินกิจกรรมไม่ถูกต้อง',
						content: 'กรุณาเลือกวันที่เริ่มต้นการแสดงผลที่ปฏิทินกิจกรรมใหม่อีกครั้ง',
						icon: 'fa fa-exclamation-circle',
                        theme: 'modern',                          
                        type: 'orange',
						animation: 'scale',
						closeIcon: false,						
						buttons: {
							close: {
								 text: 'ปิด',
									btnClass: 'btn-orange',
								}
							},						
						});	
				
				$('#start_date').val('');		
			}
		}		
	});
	
$('#txt_calendar_enddate_show').on('changeDate', function() {
		var start_date = $('#start_date').val();
		var end_date   = $('#end_date').val();
		
		if(end_date < start_date){
					$.alert({
						title: 'วันที่สิ้นสุดการแสดงผลที่ปฏิทินกิจกรรมไม่ถูกต้อง',
						content: 'กรุณาเลือกวันที่สิ้นสุดการแสดงผลที่ปฏิทินกิจกรรมใหม่อีกครั้ง',
						icon: 'fa fa-exclamation-circle',
                        theme: 'modern',                          
                        type: 'orange',
						animation: 'scale',
						closeIcon: false,						
						buttons: {
							close: {
								 text: 'ปิด',
									btnClass: 'btn-orange',
								}
							},						
						});	
						$('#end_date').val('');		
					}
			});				
});

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
}*/

function JQEdit_Enews(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: '<?=$txt_enews_edit;?>',
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