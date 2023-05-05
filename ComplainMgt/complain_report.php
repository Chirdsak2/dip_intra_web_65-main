<?php
include("../EWT_ADMIN/comtop.php");

?>  

<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");
function FuncStatus($Id){
	if($Id == 'M')
	{
		$a_data = 'เจ้าหน้าที่ติอต่อกลับ';
	}
	else if($Id == 'S')
	{
		$a_data = 'รับเรื่องแล้ว';
	}	
	else
	{
		$a_data = '';		
	}
		return $a_data;
}
function FuncInfo($ID){
	global $db;
	if($ID)
	{
	$_sql = $db->query("SELECT 
						* 						
						FROM m_complain_info 
						WHERE Complain_lead_ID = '{$ID}'
					");
	$a_data = $db->db_fetch_array($_sql);
	return 'หมวด : '.$a_data['Complain_lead_name'];
	}
}

$perpage = 10;
$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
$info = (int)(!isset($_GET['info']) ? '' : $_GET['info']);
$fm = (int)(!isset($_GET['fm']) ? '' : $_GET['fm']);
if($page <= 0) $page = 1;
$start = ($page * $perpage) - $perpage;


 

$_sql = $db->query("SELECT *
					FROM m_complain
					WHERE status <> 'N'
					{$wh} 
					ORDER BY m_complain.id DESC LIMIT {$start} , {$perpage} ");

$statement = "SELECT count(id) AS b
			  FROM m_complain 
			  WHERE status <> 'N'
			  {$wh} ";
			  
$a_rows = $db->db_num_rows($_sql);		
$s_count = $db->query($statement);
$a_count = $db->db_fetch_array($s_count);
$total_record = $a_count['b'];
$total_page = (int)ceil($total_record / $perpage);
?>

<div class="row m-b-sm">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<!--start card -->
<div class="card">
<!--start card-header -->
<div class="card-header">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<h4><b><?php echo 'รายงานสถิติเรื่องร้องเรียน';?></b></h4>	
<div class="row"> 
<div class="col-md-offset-3 col-md-6" >

<form name="form1" method="GET">
<div class="form-group row"> 
	<div class="col-md-12 col-sm-12 col-xs-12" > 
		<label for="info"><b>เลือกหมวดเรื่องร้องเรียน<span class="text-danger"></span>  :</b></label>
		<select class="selectpicker form-control" id="info" name="info" data-live-search="true" title="<?php echo 'เลือกหมวดเรื่องร้องเรียน';?>" > 
        <?php
		$_sql_info = $db->query("	SELECT 
									* 						
									FROM m_complain_info 
									WHERE Complain_status_use = ''
									ORDER BY Complain_lead_ID ASC ");
		while($a_data_info = $db->db_fetch_array($_sql_info))
		{ 
		$sel = ($a_data_info['Complain_lead_ID'] == trim($info)) ? "selected":"";
		?>
		<option value="<?php echo $a_data_info['Complain_lead_ID'];?>" <?php echo $sel;?> ><?php echo $a_data_info['Complain_lead_name'];?></option>
		<?php
		}
		?>		  
		</select>
		</div>
	<!--<div class="col-md-6 col-sm-6 col-xs-12" > 
		<label for="fm"><b>เลือกฟอร์มเรื่องร้องเรียน<span class="text-danger"></span> :</b></label>
		<select class="selectpicker form-control" id="fm" name="fm"  data-live-search="true" title="<?php echo 'เลือกฟอร์มเรื่องร้องเรียน';?>" >
        <?php
		$_sql_form = $db->query("	SELECT
									*
									FROM m_complain_form 
									WHERE com_form_status = 'Y'
									ORDER BY com_form_id ASC ");
		while($a_data_form = $db->db_fetch_array($_sql_form))
		{ 
		$sel = ($a_data_form['com_form_id'] == trim($fm)) ? "selected":"";
		?>
		<option value="<?php echo $a_data_form['com_form_id'];?>" <?php echo $sel;?> ><?php echo $a_data_form['com_form_title'];?></option>
		<?php
		}
		?>		
		</select>
	</div>-->
</div>
<div class="form-group row">
<div class="col-md-6 col-sm-6 col-xs-12">
<label for="start_date"><b><?php echo "วันที่เริ่มต้น";?> : </b></label>
            <div class='input-group date' id='datetimepicker1'>
                <input type='text' class="form-control datepicker cal" placeholder="<?php echo "วันที่เริ่มต้น";?>" name="start_date"  id="start_date" value="" >
                <span class="input-group-addon">
                    <i class="far fa-calendar-alt"></i>
                </span>
            </div>			
</div>
<div class="col-md-6 col-sm-6 col-xs-12">
<label for="end_date"><b><?php echo "วันที่สิ้นสุด";?> : </b></label>
            <div class='input-group date' id='datetimepicker2'>
                <input type='text' class="form-control datepicker cal" placeholder="<?php echo "วันที่เริ่มต้น";?>"  name="end_date"  id="end_date" value="" >
                <span class="input-group-addon">
                    <i class="far fa-calendar-alt"></i>
                </span>
            </div>
</div>
</div>


	<div class="clearfix">&nbsp;</div>
	<div class="col-md-12 col-sm-12 col-xs-12 text-center" > 
	<button type="submit" class="btn btn-success"><i class="fas fa-search"></i> ค้นหา</button>
	<button type="button" name="wf_reset" id="wf_reset" class="btn btn-warning" onclick="window.location.href='complain_report.php';"><i class="fas fa-sync-alt "></i> Reset</button>
	</div>    
</form>
</div> 
</div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	  
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="fas fa-file-export"></i>&nbsp;export <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
            <li><a onClick="window.location.href='pop_export_report_xlsx.php';" ><i class="fas fa-file-excel text-medium text-success"></i>&nbsp;<?php echo "Excel";?></a></li>
			<li><a onClick="window.location.href='pop_export_report_pdf.php';" ><i class="fas fa-file-pdf text-medium text-danger"></i>&nbsp;<?php echo "PDF";?></a></li>
			<li><a onClick="window.location.href='pop_export_report_docx.php';" ><i class="fas fa-file-word text-medium text-info"></i>&nbsp;<?php echo "Word";?></a></li>
		</ul>
</div>
</div>
 

</div>
</div>
<!--END card-header -->

<!--start card-body -->
<div class="card-body">
<div class="row ">

<div class="col-md-12 col-sm-12 col-xs-12" id="table-view" >
<h4><b><?php echo 'ผลการค้นหา';?></b></h4>	

<h5><b><?php echo 'รายการแจ้งเรื่อง';?> <?php echo FuncInfo($info);?>  จำนวน <?php echo $total_record;?> รายการ</b></h5>	
<table width="100%" border="0" align="center" class="table table-bordered" >
<thead>
<tr class="success">
<th width="5%"  class="text-center" ><b>#</b></th>
<th width="20%" class="text-center" ><b><?php echo 'เรื่อง';?></b></th>
<th width="20%" class="text-center" ><b><?php echo 'ผู้แจ้ง';?></b></th>
<th width="15%" class="text-center" ><b><?php echo 'อีเมล์';?></b></th>
<th width="10%" class="text-center" ><b><?php echo 'โทรศัพท์';?></b></th>
<th width="10%" class="text-center" ><b><?php echo 'วันที่แจ้ง';?></b></th>
<th width="15%" class="text-center" ><b><?php echo 'สถานะ';?></b></th>	   
</tr>
</thead>
<tbody>
<?php
if($a_rows > 0)
{
	$i = 1;
	while($a_data = $db->db_fetch_array($_sql))
	{
?>
<tr> 
<td class="text-center" ><?php echo $i;?></td>
<td class="text-left" ><?php echo $a_data['topic'];?></td>
<td class="text-left" ><?php echo $a_data['name'];?></td>
<td class="text-left" ><?php echo $a_data['email'];?></td>
<td class="text-center" ><?php echo $a_data['tel'];?></td>
<td class="text-center" ><?php echo $a_data['date'];?> <?php echo $a_data['time'];?></td>
<td class="text-center" ><?php echo FuncStatus($a_data['c_read']);?></td> 
</tr>
<?php 
$i++;
	} 
}
else
{
?>
<tr bgcolor="#FFFFFF"> 
<td colspan="7"><p class="text-center text-danger"><?php echo $lang_survey_nodata; ?></p></td>
</tr>
<?php } ?>
</tbody>
</table>
 <?php echo pagination_ewt($statement,$perpage,$page,$url='?'); ?>  
 
</div>
</div> 
</div>
<!--END card-body-->
</div>
<!--END card-->
</div>
</div>

</div>
<!-- END CONTAINER  -->
<?php
include("../EWT_ADMIN/combottom.php");
?>
<!-- Custom js -->
<script type="text/javascript" src="<?php echo $IMG_PATH;?>assets/js/custom.js"></script>
<script src="../js/jQuery-Mask-Plugin-master/dist/jquery.mask.min.js"></script>
<script>  
$(document).ready(function() {
	$('.cal').mask("0000-00-00");

	$('.selectpicker').selectpicker();	
	
 var today = new Date();
 $('.datepicker')		
        .datepicker({
            format: "dd/mm/yyyy",
				language: "th-th",
				autoclose: true,
				todayHighlight: true, 
			leftArrow: '<i class="fas fa-angle-double-left"></i>',
            rightArrow: '<i class="fas fa-angle-double-right"></i>',
        })
		//.datepicker("setDate", "0"); 
		//.datepicker("setDate", today.toLocaleDateString());  

$('#datetimepicker1').on('changeDate', function() {
		var event_date_start = $('#start_date').val();
		var event_date_end = $('#end_date').val();
		
		if(event_date_end != ''){
		if(event_date_end < event_date_start){
					$.alert({
						title: 'วันที่เริ่มต้น  ไม่ถูกต้อง',
						content: 'กรุณาเลือก วันที่เริ่มต้น ใหม่อีกครั้ง',
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
	
$('#datetimepicker2').on('changeDate', function() {
		var event_date_start = $('#start_date').val();
		var event_date_end = $('#end_date').val();
		
		if(event_date_end < event_date_start){
					$.alert({
						title: 'วันที่สิ้นสุด ไม่ถูกต้อง',
						content: 'กรุณาเลือก วันที่สิ้นสุด ใหม่อีกครั้ง',
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
</script>                                                                                                                                                                                                       <script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script>
function JQDelete_Complain(id){
	$.confirm({
						title: 'ลบข้อมูล',
						content: 'คุณต้องการลบรายการนี้หรือไม่?',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'fas fa-exclamation-circle',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: 'ยืนยันลบข้อมูล',
									btnClass: 'btn-warning',
									action: function () {
										$.ajax({
											type: 'POST',
											url: 'func_delete_complain.php',
											data:{'id': id,'proc':'DelCom'},
											success: function (data) {
												$.alert({
													title: '',
													content: 'ลบข้อมูลเรียบร้อยแล้ว',
													boxWidth: '30%',												
													buttons: {
														  cancel: {
																text: 'ตกลง',
									 							btnClass: 'btn-blue',
																action: function () {	
																location.reload();	
																}
														  }													     
													}
																						
												});
													
											}
										});											
										//FuncDelete(id);											
										//$.alert('ทำการลบข้อมูลเรียบร้อยแล้ว');																
									}								
							
								},
								cancel: {
									text: 'ยกเลิก'
									 									
								}
							},                          
                            animation: 'scale',
                            type: 'orange'
						
						});
	
}
function JQDelete(id){
					$.confirm({
						title: 'ลบข้อมูล',
						content: 'คุณต้องการลบรายการนี้หรือไม่?',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'glyphicon glyphicon-exclamation-sign',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: 'ยืนยันลบข้อมูล',
									btnClass: 'btn-warning',
									action: function () {
										$.ajax({
											type: 'GET',
											url: 'func_delete_vdo.php',
											data:{'id': id,'proc':'DelVdo'},
											success: function (data) {
												$.alert({
													title: '',
													content: 'url:text.html',
													boxWidth: '30%',												
													buttons: {
														  cancel: {
																text: 'ตกลง',
									 							btnClass: 'btn-blue',
																action: function () {	
																location.reload();	
																}
														  }													     
													}
																						
												});
													
											}
										});											
										//FuncDelete(id);											
										//$.alert('ทำการลบข้อมูลเรียบร้อยแล้ว');																
									}								
							
								},
								cancel: {
									text: 'ยกเลิก'
									 									
								}
							},                          
                            animation: 'scale',
                            type: 'orange'
						
						});
                   // });
}

</script>