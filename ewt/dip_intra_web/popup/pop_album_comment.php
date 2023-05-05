<?php
include("assets/config.inc.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$img_id = (int)(!isset($_GET['img_id']) ? 0 : $_GET['img_id']);
$category_id = (int)(!isset($_GET['category_id']) ? 0 : $_GET['category_id']);
?>
<form id="form_main" name="form_main" method="POST" action="popup/func_album_comment.php" enctype="multipart/form-data" >
	<input type="hidden" name="proc" id="proc"  value="album_cate_comment">
	<input type="hidden" name="img_id" id="img_id"  value="<?php echo $img_id ;?>">
	<input type="hidden" name="category_id" id="category_id"  value="<?php echo $category_id ;?>">

	<div class="container" >   
		<div class="modal-dialog modal-lg" >
			<div class="modal-content">
				<div class="modal-header">
					<div class="head-sec">
						<h2>แสดงความคิดเห็น</h2>
					</div>
					<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x"></i></button>
				</div>
				<div class="modal-body">
					<?php
					$i=1;
					$q_com = $db->query("select * from gallery_comment where category_id = '".$category_id."' and img_id = '".$img_id."' order by comment_id desc");
					while($r_com = $db->db_fetch_array($q_com)){
						$comdate = substr($r_com['com_date'],8,2).'/'.substr($r_com['com_date'],5,2).'/'.(substr($r_com['com_date'],0,4)+543);
						$arr_com_time = explode(' ',$r_com['com_date']);
						$com_date = $comdate.' '.$arr_com_time[1];
						?>
						<div class="row calendar-row">
							<div class="col-sm-3" align="right" style="vertical-align:top;"><em class="fas fa-comments"></em> ความคิดเห็นที่ <?php echo $i;?> :</div>
							<div class="col-sm-9"><?php echo $r_com['comment'];?><br>By : <?php echo $r_com['name'];?> | (<?php echo $com_date;?>)</div>
						</div>
						<?php
						$i++;
					}
					?>
					<hr>
					<div class="row calendar-row">
						<div class="col-sm-3"><span class="text-danger">* </span>ความคิดเห็น :</div>
						<div class="col-sm-9">
							<label for="comment" hidden>ความคิดเห็น</label>
							<textarea class="form-control" id="comment" name="comment" rows="3" required=""></textarea>
						</div>
					</div>

					<div class="row calendar-row">
						<div class="col-sm-3"><span class="text-danger">* </span>ชื่อผู้แสดงความคิดเห็น :</div>
						<div class="col-sm-9">
							<label for="name" hidden>ชื่อผู้แสดงความคิดเห็น</label>
							<input class="form-control font19px h-auto" type="text" id="name" name="name" required="" value="">
						</div>
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
					<button onclick="JQAdd_GalCate_Comment($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
					<i class="far fa-paper-plane"></i>&nbsp;<?php echo "ยืนยันการแสดงความคิดเห็น";?>
					</button>
				</div>
			</div>
		</div>
	</div>	 
</form>
<script src="popup/assets/js/more-pop.js"></script> 