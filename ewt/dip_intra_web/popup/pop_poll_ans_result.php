<?php
include("assets/config.inc.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$c_id = (int)(!isset($_GET['c_id']) ? 0 : $_GET['c_id']);
$no = $_GET['no'];
$q_quest = $db->query("select c_name, c_detail from poll_cat where c_id = '".$c_id."'");
$r_quest = $db->db_fetch_array($q_quest);
?>

<div class="row calendar-row">
	<div class="col-sm-12 control-label">
		<p style="font-size: 25px;"><?php echo $no;?>.) <?php echo $r_quest['c_name'];?></p>
	</div>	
</div>

<div class="row calendar-row">
	<div class="col-sm-1"></div>
	<div class="col-sm-11">
		<?php echo $r_quest['c_detail'];?>
	</div>
</div>

<?php
$q_ans = $db->query("select * from poll_ans where c_id = '".$c_id."' order by a_position asc");
while($r_ans = $db->db_fetch_array($q_ans)){
	?>
	<div class="form-group row">
		<div class="col-sm-2"></div>
		<div class="col-md-5">
			<?php echo $r_ans['a_name'];?>
		</div>
		<div class="col-md-3">
			<?php echo $r_ans['a_counter'];?>&nbsp;&nbsp;&nbsp;คน
		</div>
	</div>
	<?php
	$total += $r_ans['a_counter'];
}
?>
<div class="row calendar-row">
	<div class="col-sm-1"></div>
	<div class="col-lg-11">
		<div class="">จากจำนวนคนตอบคำถามทั้งหมด&nbsp;&nbsp;&nbsp;<?php echo $total;?>&nbsp;&nbsp;&nbsp;คน</div>
	</div>
</div>