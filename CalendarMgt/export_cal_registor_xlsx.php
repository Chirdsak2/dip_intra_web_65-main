<?php
include("../EWT_ADMIN/comtop_pop.php");

	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	header("Content-Disposition: attachment;filename=export_cal_registor_".date('YmdHis').".xls "); 
	header("Content-Transfer-Encoding: binary ");
	echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
	
	$event_id = (int)(!isset($_GET['event_id']) ? 0 : $_GET['event_id']);
	$_sql = $db->query("SELECT * 
						FROM cal_registor_event 
						WHERE cal_event_id ='{$event_id}' 
						ORDER BY cal_registor_event.cal_registor_id ASC
					");
	$a_rows = $db->db_num_rows($_sql);	
		
?>
<div class="container" >   
<div class="row ">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm"  > 
<h5 class="text-center"><?php echo "รายชื่อผู้ลงทะเบียนเข้าร่วมกิจกรรม";?></h5>	 
</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm"  >
	<div class="table-responsive">     
	<table class="table table-striped" border="1" x:str>   
    <thead>
      <tr>
	    <th class="text-center" style="width:5%;">ลำดับที่</th>
        <th class="text-center" style="width:40%;">ชื่อ - สกุล</th> 
        <th class="text-center" style="width:20%;">เบอร์โทร</th>
		<th class="text-center" style="width:20%;">อีเมล์</th>
      </tr>
    </thead>
<?php
	$i=1;
	while($a_data = $db->db_fetch_array($_sql))
	{
?>
	<tbody> 
		<tr>
	    <td class="text-center"><?php echo $i;?></td>
        <td><i class="fas fa-user-circle color-ewt"></i>&nbsp;<?php echo $a_data['cal_registor_name']; ?></td>
        <td style='vnd.ms-excel.numberformat:@' ><?php echo $a_data['cal_registor_tel']; ?></td>
		<td><?php echo $a_data['cal_registor_email']; ?></td>
		</tr>	
	</tbody>
<?php 
	$i++;
	}
?>
	</table>	
	</div>
</div>
</div>
</div>