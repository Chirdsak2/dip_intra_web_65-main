<?php
include("assets/config.inc.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$c_id = (int)(!isset($_GET['c_id']) ? 0 : $_GET['c_id']);
$no = $_GET['no'];
$q_quest = $db->query("select c_name, c_detail, c_set_time from poll_cat where c_id = '".$c_id."'");
$r_quest = $db->db_fetch_array($q_quest);
?>

<form id="form_main" name="form_main" method="POST" action="popup/func_poll_ans.php" enctype="multipart/form-data" >
	<input type="hidden" name="proc" id="proc"  value="poll_ans">
	<input type="hidden" name="c_id" id="c_id"  value="<?php echo $c_id ;?>">
	<input type="hidden" name="c_set_time" id="c_set_time"  value="<?php echo $r_quest['c_set_time'] ;?>">
	<input type="hidden" name="status_poll" id="status_poll"  value="<?php echo $_COOKIE['POLL_'.$c_id];?>">

	<div class="container" >   
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<div class="head-sec">
						<h2 id="shw_head">สำรวจความคิดเห็น</h2>
					</div>
					<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x"></i></button>
				</div>
				<div class="modal-body" id="shw_poll_result">
					<div class="row calendar-row">
						<div class="col-sm-12">
							<p style="font-size: 25px;"><span class="text-danger">* </span> <?php echo $no;?>.) <?php echo $r_quest['c_name'];?></p>
							<fieldset>
								<legend>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $r_quest['c_detail'];?></legend>
							</fieldset>
						</div>	
					</div>
					
					<div class="row calendar-row">
						<?php
						$q_ans = $db->query("select * from poll_ans where c_id = '".$c_id."' order by a_position asc");
						while($r_ans = $db->db_fetch_array($q_ans)){
							?>
							<div class="col-lg-5 offset-md-1">
								<div class="form-check pt-2 pb-2">
									<input class="form-check-input" type="radio" name="a_id" id="a_id" value="<?php echo $r_ans['a_id'];?>" required> &nbsp;
									<label class="form-check-label" for="a_id"><?php echo $r_ans['a_name'];?></label>
								</div>
							</div>
							<?php
						}
						?>
					</div>
					
					<div class="form-group row" >
						<label for="chkpic" class="col-sm-12 control-label"><b>กรอกตัวเลขตามภาพที่ปรากฎ <span class="text-danger"><code>*</code></span> : </b></label>
						<div class="col-md-3 col-sm-3 col-xs-3 text-center" style="padding-top:5px;" >
							<span id="recapt" ></span>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2" >
							<span class="btn btn-warning text-white" onclick="Func_ReCaptcha();"><i class="fas fa-sync"></i></span>	
						</div>
						<div class="col-md-7 col-sm-7 col-xs-7" >
							<input class="form-control chkcaptcha" type="text" name="chkpic" id="chkpic" required="required" autocomplete="off" />
						</div>
					</div>
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" onclick="$('#box_popup').fadeOut();" >
					<i class="far fa-times-circle"></i>&nbsp;<?php echo "ปิด";?></button>
					
					<div id="hide_btn">
						<button onclick="JQAdd_Poll($('#form_main'));" type="button" class="btn btn-success btn-ml">
							<i class="far fa-paper-plane"></i>&nbsp;<?php echo "โหวต";?>
						</button>&nbsp;&nbsp;
						
						<button onclick="view_poll('<?php echo $c_id;?>','<?php echo $no;?>');" type="button" class="btn btn-danger btn-ml" >
							<i class="fas fa-search" aria-hidden="true"></i>&nbsp;<?php echo "ดูผลโหวต";?>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>	 
</form>
<script src="popup/assets/js/more-pop.js"></script> 
<script>
function view_poll(c_id,no){
	var url = "popup/pop_poll_ans_result.php";
	var dataString = 'c_id='+c_id+'&no='+no;
	$.ajax({
		type: "GET",
		url: url,
		data: dataString, // serializes the form's elements.
		cache: false,
		success: function(html)
		{
			$('#shw_poll_result').html(html);
			$('#shw_head').html('สถิติการสำรวจความคิดเห็น');
			$('#hide_btn').hide();
		}
	});
}
</script>