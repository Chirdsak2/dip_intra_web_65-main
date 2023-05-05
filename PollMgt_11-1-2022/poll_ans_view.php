<?php
include("../EWT_ADMIN/comtop_pop.php");

$c_id = (int)(!isset($_GET['c_id']) ? 0 : $_GET['c_id']);
$no = $_GET['no'];

$q_quest = $db->query("select * from poll_cat where c_id = '{$c_id}' ");
$r_quest = $db->db_fetch_array($q_quest);
?>
<input type="hidden" name="proc" id="proc"  value="poll_ans">
<input type="hidden" name="c_id" id="c_id"  value="<?php echo $c_id ;?>">
<input type="hidden" name="no" id="no"  value="<?php echo $no ;?>">

<div class="container" >   
<div class="modal-dialog modal-lg" >
<div class="modal-content">

<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x color-white"></i></button>
<h4 class="modal-title  color-white"><i class="fas fa-plus-circle"></i> <?='สถิติการสำรวจความคิดเห็น';?></h4>
</div>

<div class="modal-body">
<div class="card ">
<div class="scrollbar scrollbar-near-moon thin">
			
<div class="card-body">
						
<div class="form-group row " >
<div class="col-md-12 col-sm-12 col-xs-12" >
		<i class="fas fa-poll text-dark"></i> <?php echo $r_quest['c_name'];?>
	</div>	
<div class="col-md-12 col-sm-12 col-xs-12" >

		<i class="far fa-calendar-alt text-dark"></i> <?=$r_quest['c_start'];?> to <?=$r_quest['c_stop'];?> 
	</div>
</div>
<div class="form-group row " >
<div class="col-md-12 col-sm-12 col-xs-12" >
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
<div class="form-group row " >
<div class="col-md-12 col-sm-12 col-xs-12" >
		<div class="">จากจำนวนคนตอบคำถามทั้งหมด&nbsp;&nbsp;&nbsp;<?php echo $total;?>&nbsp;&nbsp;&nbsp;คน</div>
	</div>
</div>
</div>
</div>
						
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
							<button onclick="window.location.href='poll_ans_view_xls.php?c_id=<?php echo $c_id;?>'" type="button" class="btn btn-success btn-sm " >
								<i class="fas fa-file-excel"></i>&nbsp;Export CSV
							</button>
						</div>
						<br>
					</div>	
				</div>
			</div> 
		</div>
	</div>
	</div>
<script>
$('document').ready(function(){
	/*var url = "../ewt/<?=$_SESSION['EWT_SUSER'];?>/popup/pop_poll_ans_result.php";
	var dataString = 'c_id='+$('#c_id').val()+'&no='+$('#no').val(); 
	$.ajax({
		type: "GET",
		url: url,
		data: dataString, // serializes the form's elements.
		cache: false,
		success: function(html)
		{
			//$('#shw_poll_result').html(html);
		}
	});*/
});
</script>