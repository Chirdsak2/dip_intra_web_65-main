<?php
include("assets/config.inc.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
//include("comtop.php");
//$wcid = $_GET["wc_id"];
$tid = $_GET["t_id"];
$aid = $_GET["a_id"];

if($aid == ""){
	$sql_w_question = $db->query("SELECT * FROM w_question WHERE t_id = '".$tid."' $wh");
	$rec_question = $db->db_fetch_array($sql_w_question);
	$timer = explode("-",$rec_question['t_date']); 
	if($lang_sh1[1] != ''){
	$YearT = $timer[0];
	}else{
	$YearT = $timer[0]+543;
	}
	$time = $timer[2]."/".$timer[1]."/".$YearT." ".$rec_question['t_time'];
	$address = $rec_question['user_id']."/".$rec_question['t_email']."/".$rec_question['user_id'];

	$NAME = $rec_question['t_name'];
	$DETAIL = $rec_question['t_detail'];
	$EMAIL = $rec_question['t_email'];
	$TITLE = "แจ้งลบกระทู้ (ถ้อยคำที่สุภาพ สร้างสรรค์ เป็นประโยชน์ต่อส่วนรวม)";
	$flag = "Delquestion";

}else{
	$sql_answer = $db->query("SELECT * FROM w_answer WHERE a_id = '".$aid."' AND t_id = '".$tid."'  AND s_id = '1' AND a_sts = '1' ");
	$rec_answer = $db->db_fetch_array($sql_answer);
	$timer = explode("-",$rec_answer['a_date']); 
if($lang_sh1[1] != ''){
	$YearA = $timer[0];
}else{
	$YearA = $timer[0]+543;
}
	$time = $timer[2]."/".$timer[1]."/".$YearA." ".$rec_answer['a_time'];		
	$address = $rec_answer['user_id']."/".$rec_answer['a_email']."/".$rec_answer['user_id'];

	$NAME = $rec_answer['a_name'];	
	$DETAIL = $rec_answer['a_detail'];
	$EMAIL = $rec_answer['a_email'];	
	$TITLE = "แจ้งลบความคิดเห็น (ถ้อยคำที่สุภาพ สร้างสรรค์ เป็นประโยชน์ต่อส่วนรวม)";
	$flag = "Delanswer";
}
?>
<form id="form_main" name="form_main" method="POST" action="popup/func_webboard_comment_del.php" enctype="multipart/form-data" >
<div>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div class="head-sec">
          <h2><?php echo $TITLE;?></h2>
        </div>
        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>-->
      </div>
	  
      <div class="modal-body">
		<div class="form-group row">
			<label class="col-sm-2 col-form-label">เหตุผล : <span class="text-danger">* </span></label>
			<div class="col-sm-9">
				<textarea class="form-control form-control-sm bottom10" name="del_comment" id="del_comment" required></textarea>
			</div>
		</div>
      </div>
      
	  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" onclick="$('#box_popup').fadeOut();" >
			<i class="far fa-times-circle"></i>&nbsp;<?php echo "ปิด";?></button>
			<button onclick="JQDel_Webbord_Comment($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
			<i class="far fa-paper-plane"></i>&nbsp;<?php echo "ยืนยัน";?>
			</button>
		</div>
		
		<input name="proc" type="hidden" id="proc" value="<?php echo $flag; ?>">
		<input name="wc" type="hidden" id="wc" value="<?php echo $wcid; ?>">
		<input name="tid" type="hidden" id="tid" value="<?php echo $tid; ?>">
		<input name="aid" type="hidden" id="aid" value="<?php echo $aid; ?>">
	  
    </div>
  </div>
</div>
</form>
<script src="popup/assets/js/more-pop.js"></script> 