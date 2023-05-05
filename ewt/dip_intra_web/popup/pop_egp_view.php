<?php
include("assets/config.inc.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$id = (int)(!isset($_GET['id']) ? '' : $_GET['id']);

$_sql = $db->query("SELECT 
					* 
					FROM egp_list 
					LEFT JOIN egp_process ON egp_list.egp_list_process = egp_process.egp_process_code 
					LEFT JOIN egp_type ON egp_list.egp_list_type = egp_type.egp_type_code 
					LEFT JOIN egp_dept ON egp_list.egp_list_dept = egp_dept.egp_dept_code 
					WHERE egp_list_id = '{$id}' ");
$a_data = $db->db_fetch_array($_sql);	
?>
<form id="form_main" name="form_main" method="POST" action="" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="" />
<input type="hidden" name="id" id="id"  value="<?php echo $id;?>" />
<div class="container" >   
<div class="modal-dialog modal-lg" >
<div class="modal-content">
      <div class="modal-header">
        <div class="head-sec">
          <h2><?php echo 'รายละเอียด';?></h2>
        </div>
        <button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x"></i></button>
      </div>
<div class="modal-body">
<h3><?php echo $a_data['egp_list_title'];?></h3>
	<div class="row">
	<!--<div class="col-lg-3 col-md-3 col-sm-3 col-3 linebt">หัวข้อ</div>
	<div class="col-lg-9 col-md-9 col-sm-9 col-9 linebt"><?php echo $a_data['egp_list_title'];?></div>-->

	<div class="col-lg-3 col-md-3 col-sm-3 col-3 linebt">ประเภทประกาศ</div>
	<div class="col-lg-9 col-md-9 col-sm-9 col-9 linebt"><?php echo $a_data['egp_type_name'];?> </div>

	<div class="col-lg-3 col-md-3 col-sm-3 col-3 linebt">วีธีการจัดหา</div>
	<div class="col-lg-9 col-md-9 col-sm-9 col-9 linebt"><?php echo $a_data['egp_process_name'];?> </div>

	<div class="col-lg-3 col-md-3 col-sm-3 col-3 linebt">ชื่อหน่วยงาน</div>
	<div class="col-lg-9 col-md-9 col-sm-9 col-9 linebt"><?php echo $a_data['egp_dept_name'];?> </div>

    <div class="col-lg-3 col-md-3 col-sm-3 col-3  mt-3 mb-3">เอกสารประกอบ</div>
	<div class="col-lg-9 col-md-9 col-sm-9 col-9  mt-3 mb-3">
			<a href="<?php echo  $a_data['egp_list_url'];?>" target="_blank">      
			<button type="button" class="btn btn-info  btn-ml "  >
			<span class="glyphicon glyphicon-file "></span>&nbsp;<?php echo "เปิดดูเอกสารประกอบ"; ?> 
			</button>	
			</a>	
    </div>


	<!--</div>	 	
</div>
<div class="modal-footer">
<div class="col-lg-12 col-md-12 col-sm-12 col-12 mt-5 mb-3 text-center">
<?php
if($a_data['event_registor'] == 'Y' ) 
{
	if($a_data['event_registor_num'] > $a_rows AND $a_data['event_registor_num'] != '0' ) 
	{
?>
<button type="button" class="btn btn-success" onClick="boxPopup('popup/pop_calendar_registor.php?event_id=<?php echo $a_data['event_id'];?>')" > ลงทะเบียนเข้าร่วม </button>
<?php 
	}
	else
	{
		//echo "<button type=\"button\" class=\"btn btn-saminar btn-success\"  >";
		//echo $text_calendar_disable_regis.PHP_EOL;
		//echo '</button>';
	}
}

if($a_data['event_registor'] == 'M') 
{
	if(!empty($a_data['event_link_registor']))
	{
//$txt .='<button type="button" class="btn btn-saminar btn-success" data-toggle="modal"  data-target="#Register-calendar">';
		echo "<button type=\"button\" class=\"btn btn-saminar btn-success\" onClick=\"window.open('".$a_data['event_link_registor']."');\" >";
		echo $text_calendar_regis.PHP_EOL;
		echo '</button>';
	}
}
 ?>
</div>-->
</div>
</div>
</div>	
</div>
</div> 
</form>
<script src="popup/assets/js/more-pop.js"></script> 