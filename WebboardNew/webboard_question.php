<?php
include("../EWT_ADMIN/comtop.php");
include("lib/webboard_function.php");

$chk_config = $db->query("SELECT * FROM w_config WHERE c_config = '1'");
$w_con = mysql_fetch_array($chk_config);

//============
//  Removing
//============

if($_POST["proc"]=="delete_question"){

	//echo "<br><br><br><br><br><br>";
	//print_r($_POST);
	//exit();

	$question_sql = $db->query("SELECT *
					FROM w_question
					LEFT JOIN w_cate ON w_question.c_id=w_cate.c_id
					WHERE t_id='$_POST[t_id]'");

	$question_info = $db->db_fetch_array($question_sql);


	if($_POST[t_id]){
		$sql_del = "DELETE FROM w_question WHERE t_id='$_POST[t_id]'";
		$db->query($sql_del);

		$db->write_log("delete","webboard question","ลบกระทู้ ".$question_info[t_name]);
	}
	
	if($_POST[c_id]){
	?>
		<script>
			location.href = "webboard_room.php?c_id=<?php echo $_POST[c_id]; ?>";
		</script>

	<?php	
	}else{
	?>
		<script>
			location.href = "webboard_room.php";
		</script>

	<?php	
	}
	exit();
	
}
else if($_POST[proc]=="add_comment"){

	$_POST[t_id] = $_GET[t_id];
	
	//echo "<br><br><br><br><br><br>";
	//print_r($_POST);
	//exit();

	$question_sql = $db->query("SELECT *
					FROM w_question
					LEFT JOIN w_cate ON w_question.c_id=w_cate.c_id
					WHERE t_id='$_POST[t_id]'");

	$question_info = $db->db_fetch_array($question_sql);

	

	//=================
	//  Attachment
	//=================

	//$chk_config = $db->query("SELECT * FROM site_info WHERE site_info_id = '1'");
	//$CO = mysql_fetch_array($chk_config);

	$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/";

	if($_FILES[comment_file][name]){
		
		//check extension
		$array_ext = explode(",",$w_con[c_img]);
		$file_ext  = array_reverse (explode(".",$_FILES[comment_file][name]));
		$file_ext  = $file_ext[0];

		$check_ext = "No";

		for($a=0;$a<sizeof($array_ext);$a++){
			if(strtolower($array_ext[$a])==strtolower($file_ext)){$check_ext = "Yes";}
		}

		if($check_ext=="No"){
			//echo "<br><br><br><br><br>";
			//print_r($_POST);
			?>
				<span>
					<form method="post" id="manage_info">
					<?php
						$h = 1; 
						foreach($_POST as $key=>$value){
					?>
						<input type"hidden" name="data_<?php echo $key; ?>" value="<?php echo safety_clean($value); ?>">
					<?php $h++; } ?>
					</form>
				</span>

				<?php
				include("../EWT_ADMIN/script-all.php");
				?>
				<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
				<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui-touch-punch.min.js"></script>
				<script>
					$.confirm({
						title: 'Incorrect File Type',
						content: 'File type is incorrect',
						boxWidth: '30%',
						icon: 'glyphicon glyphicon-exclamation-sign',
						theme: 'modern',
						buttons: {
							confirm: {
								text: '<?php echo $txt_webboard_disapprove_confirm; ?>',
								btnClass: 'btn-warning',
								action: function (){
									$("#manage_info").submit();
								}								
							
							},
						},                          
						animation: 'scale',
						type: 'orange'
						
					});
				</script>
			<?php

			exit();
		}

		if($_FILES[comment_file][size]>($w_con[c_sizeupload]*1000)){
			
			?>
				<span>
					<form method="post" id="manage_info">
					<?php
						$h = 1; 
						foreach($_POST as $key=>$value){
					?>
						<input type"hidden" name="data_<?php echo $key; ?>" value="<?php echo safety_clean($value); ?>">
					<?php $h++; } ?>
					</form>
				</span>

				<?php
					include("../EWT_ADMIN/script-all.php");
				?>
				<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
				<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui-touch-punch.min.js"></script>
				<script>
					$.confirm({
						title: 'Incorrect File Size',
						content: 'File size exceed limit',
						boxWidth: '30%',
						icon: 'glyphicon glyphicon-exclamation-sign',
						theme: 'modern',
						buttons: {
							confirm: {
								text: '<?php echo $txt_webboard_disapprove_confirm; ?>',
								btnClass: 'btn-warning',
								action: function (){
									$("#manage_info").submit();
								}								
							
							},
						},                          
						animation: 'scale',
						type: 'orange'
						
					});
				</script>
			<?php

			exit();
		}

		else{

			
		}
	}

	if($_POST[t_id]){

		//$sql_del = "DELETE FROM w_question WHERE t_id='$_POST[t_id]'";
		$_POST["comment_desc"]    = str_replace("'","''",$_POST["comment_desc"]);

		$date = date('Y-m-d');
		$time = date('h:i:s');
		
		if(getenv(HTTP_X_FORWARDED_FOR)) {$IPn = getenv(HTTP_X_FORWARDED_FOR);}	 
		else {$IPn = getenv("REMOTE_ADDR");}

		$sql_insert = "INSERT INTO w_answer (t_id,a_detail,a_date,a_time,s_id,a_ip) 
		               VALUES ('$_POST[t_id]','$_POST[comment_desc]','$date','$time','0','$IPn')";
		$db->query($sql_insert);
		
		$db->write_log("add","webboard comment","เพิ่มความคิดเห็นกระทู้".$question_info[t_name]);

		//=================
		//  Copy File
		//=================

		$aid_sql    = "SELECT MAX(a_id) as a_id FROM w_answer";
		$aid_result = $db->query($aid_sql);
		$id         = mysql_fetch_array($aid_result); 
		$current_id = $id[a_id];
		
		if($_FILES[comment_file][name]){
	
			$file    = $_FILES[comment_file][tmp_name];
			$picname = "attachment_answer".$current_id.".".$file_ext;
	
			copy($file,$Globals_Dir.'webboard_attach/'.$picname);
	
			//Update DB
	
			$sql_attachment = "UPDATE w_answer SET a_attact = '$picname' WHERE a_id='$current_id'";
			$db->query($sql_attachment);
	
		}

	
	
	?>
		<script>
			location.href = "webboard_question.php?t_id=<?php echo $_POST[t_id]; ?>";
		</script>

	<?php	
	}
	exit();
}
else if($_POST[proc]=="delete_comment"){

	if($_POST[t_id]){

		if($_POST[a_id]){
			$sql_del = "DELETE FROM w_answer WHERE a_id='$_POST[a_id]'";
			$db->query($sql_del);
			
			$db->write_log("delete","webboard comment","ลบความคิดเห็นกระทู้");
		}
	
	?>
		<script>
			location.href = "webboard_question.php?t_id=<?php echo $_POST[t_id]; ?>";
		</script>

	<?php	
	}
	exit();
}
else if($_POST[proc]=="approve_comment"){
	
	if($_POST[t_id]){

		if($_POST[a_id]){
			$sql_approve = "UPDATE w_answer SET s_id='1' WHERE a_id='$_POST[a_id]'";
			$db->query($sql_approve);
			
			$db->write_log("approve","approve comment","อนุมัติความคิดเห็น");
		}
	
	?>
		<script>
			location.href = "webboard_question.php?t_id=<?php echo $_POST[t_id]; ?>";
		</script>

	<?php	
	}
	exit();

}
else if($_POST[proc]=="disapprove_comment"){
	
	if($_POST[t_id]){

		if($_POST[a_id]){
			$sql_approve = "UPDATE w_answer SET s_id='0' WHERE a_id='$_POST[a_id]'";
			$db->query($sql_approve);
			
			$db->write_log("disapprove","disapprove comment","ยกเลิกอนุมัติความคิดเห็น");
		}
	
	?>
		<script>
			location.href = "webboard_question.php?t_id=<?php echo $_POST[t_id]; ?>";
		</script>

	<?php	
	}
	exit();

}

?>  

<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");

$ban_cid = (int)(!isset($_GET['ban_cid']) ? 0 : $_GET['ban_cid']);

if(check_type_number($_GET['t_id'])==true){
	$question_tid = $_GET['t_id'];
}



$perpage = 10;
$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);

if($page <= 0) $page = 1;

$start = ($page * $perpage) - $perpage;

$question_sql = $db->query("SELECT *
					        FROM w_question
							LEFT JOIN w_cate ON w_question.c_id=w_cate.c_id
					        WHERE t_id='$question_tid'");

$question_info = $db->db_fetch_array($question_sql);


$_sql = $db->query("SELECT *
					FROM w_answer
					WHERE t_id = '$question_info[t_id]'
					ORDER BY w_answer.a_id DESC LIMIT {$start} , {$perpage} ");

$statement = "SELECT count(a_id) AS b
			  FROM w_answer
			  WHERE t_id = '$question_info[t_id]'";
			  
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

<h4><?=$question_info["t_name"];?></h4>
<p></p> 

</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><a href="webboard_main.php"><?=$txt_webboard_menu_main;?></a></li>
<li><a href="webboard_room.php?c_id=<?=$question_info["c_id"];?>"><?=$question_info["c_name"];?></a></li>
<li class=""><?=$question_info["t_name"];?></li>
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	  

</div>

<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
	<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle">
			<i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span>
		</button>
        <ul class="dropdown-menu dropdown-menu-right">
            <li>
				<a onClick="boxPopup('<?=linkboxPopup();?>pop_add_calendar_group.php?cal_cid=<?=$cal_cid;?>');" >
					<i class="fas fa-plus-circle"></i>&nbsp;<?=$txt_calendar_add_cate;?>
				</a>
			</li>
			
			<li>
				<a href="banner_group.php" target="_self" >
					<i class="fas fa-undo-alt"></i>&nbsp;<?=$txt_ewt_back;?>
				</a>
			</li>
		</ul>
	</div>
</div>

</div>
</div>
</div>
<!--END card-header -->

<!--start card-body -->
<div class="card-body">
<div class="row ">
<div class="col-md-12 col-sm-12 col-xs-12" id="table-view" >

<div class="card ">
	<div class="card-header ewt-bg-color m-b-sm" >
		<div class="card-title text-left color-white">
			<p><h4><?=$question_info["t_name"];?></h4></p>
		</div>
	</div>
	<div class="card-body">

	<div class="panel-group" id="accordion">
		
		<div class="panel panel-default ">

			<div class="panel-heading ewt-bg-success">
				<h4 class="panel-title">
					<i class="fas fa-comment-dots color-ewt"></i> 
					<?=$question_info['t_name'];?> 
				</h4>
			</div>

			<style>
				.attachment_link{
					color: red;
					text-decoration-line: underline  !important;
				}

			</style>
		
			<div id="collapseOne<?=$i;?>" class="">
				<div class="panel-body">
					<div><?=question_html($question_info["t_detail"]);?><br> 
					
					<?php 
						if($question_info["keyword"]){ 
					?>
						<b> Attachment: </b><a class="attachment_link" href="<?php echo "../ewt/".$_SESSION["EWT_SUSER"]."/webboard_attach/".$question_info["keyword"]; ?>" download>ดาวโหลดเอกสารแนบ</a><br>
					<?php 
						} 
					?>
					<br>
					<?php if($question_info['q_name']){?>
						<b> User: </b> <?=$question_info['q_name'];?> <br>
					<?php } else { ?>
						<b> User: </b> - <br>
					<?php } ?>
					<b> Create Date/Time: </b><?=$question_info['t_date'];?> <?=$question_info['t_time'];?> <br>
					<b> IP Address: </b><?=$question_info['t_ip'];?> <br></div>
				</div>

				<hr>

				<div class="panel-footer ewt-bg-white text-right">

					<div class="ewt-icon-wrap ewt-icon-effect-1 ewt-icon-effect-1b">

						<button value="<?=$question_info['t_id'];?>" type="button" class="edit_question btn btn-default  btn-circle  btn-sm " data-toggle="tooltip" data-placement="top" title="<?=$txt_webboard_edit_question;?>" >
							<i class="far fa-edit"></i>
						</button>

						<button value="<?=$question_info['t_id'];?>" type="button" class="delete_question btn btn-default  btn-circle  btn-sm " data-toggle="tooltip" data-placement="top" title="<?=$txt_webboard_delete_question;?>" >
							<i class="far fa-trash-alt" aria-hidden="true"></i>
						</button>
					
					</div>
				</div>
			</div>

		</div>

		<br>

		<div class="panel panel-default " align="center" style="background-color: #FFC153;">
		
			<br>

			<form method="post" enctype="multipart/form-data">

			<table border="0" width="80%">
				<tr>
					<td style="padding: 10px; background-color: #FFFFFF; border-top-left-radius:18px;">
						<b>Detail: <span style="color:red;">*</span></b>
					</td>
					<td style="padding: 10px; background-color: #FFFFFF; border-top-right-radius:18px;">
						<textarea id="comment_desc" name="comment_desc" style="width: 100%; height:100px; resize: none;" required><?= $_POST["data_comment_desc"]; ?></textarea>
						<input type="hidden" name="proc" value="add_comment">
					</td>
				</tr> 
				
				<tr>
					<td style="padding: 10px; background-color: #FFFFFF;">
					</td>
					<td align="center"  style="padding: 10px; background-color: #FFFFFF;">
						<a href="javascript:setURL()"><img src="../WebboardMgt/pic/link.gif" alt="แทรกลิงค์ URL" width="18" height="17" border="0"></a> 
						<a href="javascript:setImage()"><img src="../WebboardMgt/pic/tree.gif" alt="แทรกรูป" width="18" height="17" border="0"></a> 
						<a href="javascript:setsmile('[---]')"><img src="../WebboardMgt/pic/indent.gif" alt="ย่อหน้า" width="18" height="17" border="0"></a> 
						<a href="javascript:setBold()"><img src="../WebboardMgt/pic/b.gif" alt="ตัวหนา" width="18" height="17" border="0"></a> 
						<a href="javascript:setItalic()"><img src="../WebboardMgt/pic/i.gif" alt="ตัวเอียง" width="18" height="17" border="0"></a> 
						<a href="javascript:setUnderline()"><img src="../WebboardMgt/pic/u.gif" alt="เส้นใต้" width="18" height="17" border="0"></a> 
						<a href="javascript:setColor('red','แดง')"><img src="../WebboardMgt/pic/redcolor.gif" alt="สีแดง" width="18" height="17" border="0"></a> 
						<a href="javascript:setColor('green','เขียว')"><img src="../WebboardMgt/pic/greencolor.gif" alt="สีเขียว" width="18" height="17" border="0"></a> 
						<a href="javascript:setColor('blue','น้ำเงิน')"><img src="../WebboardMgt/pic/bluecolor.gif" alt="สีน้ำเงิน" width="18" height="17" border="0"></a> 
						<a href="javascript:setColor('orange','ส้ม')"><img src="../WebboardMgt/pic/orangecolor.gif" alt="สีส้ม" width="18" height="17" border="0"></a> 
						<a href="javascript:setColor('pink','ชมพู')"><img src="../WebboardMgt/pic/pinkcolor.gif" alt="สีชมพู" width="18" height="17" border="0"></a> 
						<a href="javascript:setColor('gray','เทา')"><img src="../WebboardMgt/pic/graycolor.gif" alt="สีเทา" width="18" height="17" border="0"></a> 

					</td>
				</tr>
				<tr>
					<?php 
						//$chk_config = $db->query("SELECT * FROM site_info WHERE site_info_id = '1'");
						//$CO = mysql_fetch_array($chk_config);
					?>
					<td style="padding: 10px; background-color: #FFFFFF; border-bottom-left-radius:18px;">
						<b>File:</b>
					</td>
					<td style="padding: 10px; background-color: #FFFFFF; border-bottom-right-radius:18px;">
						<input type="file" name="comment_file"  style="width: 80%;">
						<br> Allow only: <span style="color:red;"><?php echo $w_con[c_img]; ?></span>
						<br> Maximum File Size: <span style="color:red;"><?php echo $w_con[c_sizeupload]/1000; ?> MB</span>
					</td>
				</tr> 
			</table>
			
			<br>
			
			<button type="submit" class="btn btn-default btn-sm" >
				<i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php echo $txt_webboard_submit_comment; ?>
			</button>

			</table>

			<br><br>

		</div>

		<br>

		<b> Total Comment: </b><?php echo total_comment($question_info['t_id']); ?><br>
			
		<?php
			if($a_rows > 0){
			$i = (($page-1)*$perpage)+1;
			while($a_data = $db->db_fetch_array($_sql)){
		?>	
			<br>

			<div class="panel panel-default ">
				<div width="100%" style="background-color: #FFC153;padding: 10px;">
					<b>Comment # <?=$i;?>
				</div>
			
				<div class=""> 
					<div class="panel-body">
						<div><b><?=$txt_complain_detail;?> :</b> 
						<?=$a_data["a_detail"];?>
						</div><br> 
						
						<div>
							<b> Create Date/Time: </b><?=$a_data['a_date'];?> <?=$a_data['a_time'];?> <br>
							<?php 
								if($a_data["a_attact"]){ 
							?>
								<b> Attachment: </b><a class="attachment_link" href="<?php echo "../ewt/".$_SESSION["EWT_SUSER"]."/webboard_attach/".$a_data["a_attact"]; ?>" download>ดาวโหลดเอกสารแนบ</a><br>
							<?php 
								} 
							?>
							<b>IP Address :</b> <?=$a_data['a_ip'];?><br>
							<b>Status :</b>
							<?php if($a_data['s_id']==0){ ?>
								<span style="color:red;">ไม่อนุมัติ</span>
							<?php } else { ?>
								<span style="color:green;">อนุมัติ</span>
							<?php } ?>
						</div>
					</div>

					<div class="panel-footer ewt-bg-white text-right" style="background-color: #FFC153;padding: 10px;">

						<div class="ewt-icon-wrap ewt-icon-effect-1 ewt-icon-effect-1b">


							<!-- <button type="button" class="btn btn-default  btn-circle  btn-sm " onClick="JQDelete_Complain(<?=$a_data['id']?>);" data-toggle="tooltip" data-placement="top" title="<?=$txt_complain_delete;?>" >
							<i class="far fa-comment-dots " aria-hidden="true"></i>
							</button> -->

							<?php if($a_data['s_id']==0){ ?>
								<button value="<?=$a_data['a_id'];?>" type="button" class="approve_comment btn btn-default  btn-circle  btn-sm " data-toggle="tooltip" data-placement="top" title="<?php echo $txt_webboard_approve_comment; ?>" >
									<i class="far fa-check-circle"></i>
								</button>
							<?php } else { ?>
								<button value="<?=$a_data['a_id'];?>" type="button" class="disapprove_comment btn btn-default  btn-circle  btn-sm " data-toggle="tooltip" data-placement="top" title="<?php echo $txt_webboard_disapprove_comment; ?>" >
									<i class="far fa-times-circle"></i>
								</button>
							<?php } ?>

							<button value="<?=$a_data['a_id'];?>" type="button" class="delete_comment btn btn-default  btn-circle  btn-sm " data-toggle="tooltip" data-placement="top" title="<?php echo $txt_webboard_delete_comment; ?>" >
								<i class="far fa-trash-alt" aria-hidden="true"></i>
							</button>
				
						</div>
					</div>
				</div>
				
			</div>	

		<?php $i++;} ?>
		<?php } ?>

	</div>

</div>
</div>	
<?=pagination_ewt($statement,$perpage,$page,$url='webboard_question.php?t_id=3&');?>	
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
                                                                                                                                                                                                        <script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui-touch-punch.min.js"></script>
<style>
/* <!-- */
.panel-default > .panel-heading {
    /*color: #FFFFFF;*/
    /*background-color: #FFC153 ;*/
	background-color: #FFFFFF ;
    border-color: #ddd;
}
    .faqHeader {
        font-size: 27px;
        margin: 20px;
    }
    .panel-heading [data-toggle="collapse"]:after {
		font-family: 'Font Awesome 5 Free';
		font-weight: 900;
        content: "\f105"; /* "play" icon */
        float: right;
        color: #FFC153;
        font-size: 24px;
        line-height: 22px;
        /* rotate "play" icon from > (right arrow) to down arrow */
        -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
        -ms-transform: rotate(-90deg);
        -o-transform: rotate(-90deg);
        transform: rotate(-90deg);
	
    }
    .panel-heading [data-toggle="collapse"].collapsed:after {
        /* rotate "play" icon from > (right arrow) to ^ (up arrow) */
        -webkit-transform: rotate(90deg);
        -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        transform: rotate(90deg);
        color: #454444;
    }
	
.ewt-icon-wrap {
	margin: 0 auto;
}
.ewt-icon {
	display: inline-block;
	font-size: 0px;
	cursor: pointer;
	_margin: 15px 15px;
	width: 30px;
	height: 30px;
	border-radius: 50%;
	text-align: center;
	position: relative;
	z-index: 1;
	color: #fff;
}

.ewt-icon:after {
	pointer-events: none;
	position: absolute;
	width: 100%;
	height: 100%;
	border-radius: 50%;
	content: '';
	-webkit-box-sizing: content-box; 
	-moz-box-sizing: content-box; 
	box-sizing: content-box;
}
.ewt-icon:before {
	font-family: 'Font Awesome 5 Free';
	font-weight: 900;
	speak: none;
	font-size: 18px;
	line-height: 30px;
	font-style: normal;
	_font-weight: normal;
	font-variant: normal;
	text-transform: none;
	display: block;
	-webkit-font-smoothing: antialiased;
}
.ewt-icon-edit:before {
	content: "\f044";
}
.ewt-icon-del:before {
	content: "\f2ed";
}
.ewt-icon-view:before {
	content: "\f06e";
}
.ewt-icon-print:before {
	content: "\f02f";
}
/* Effect 1 */
.ewt-icon-effect-1 .ewt-icon {
	background: rgba(255,255,255,0.1);
	-webkit-transition: background 0.2s, color 0.2s;
	-moz-transition: background 0.2s, color 0.2s;
	transition: background 0.2s, color 0.2s;
}
.ewt-icon-effect-1 .ewt-icon:after {
	top: -7px;
	left: -7px;
	padding: 7px;
	box-shadow: 0 0 0 4px #fff;
	-webkit-transition: -webkit-transform 0.2s, opacity 0.2s;
	-webkit-transform: scale(.8);
	-moz-transition: -moz-transform 0.2s, opacity 0.2s;
	-moz-transform: scale(.8);
	-ms-transform: scale(.8);
	transition: transform 0.2s, opacity 0.2s;
	transform: scale(.8);
	opacity: 0;
}
/* Effect 1a */
.ewt-icon-effect-1a .ewt-icon:hover {
	background: rgba(255,255,255,1);
	color: #41ab6b;
}
.ewt-icon-effect-1a .ewt-icon:hover:after {
	-webkit-transform: scale(1);
	-moz-transform: scale(1);
	-ms-transform: scale(1);
	transform: scale(1);
	opacity: 1;
}
/* Effect 1b */
.ewt-icon-effect-1b .ewt-icon:hover{
	background: rgba(255,255,255,1);
	color: #41ab6b;
}
.ewt-icon-effect-1b .ewt-icon:after {
	-webkit-transform: scale(1.2);
	-moz-transform: scale(1.2);
	-ms-transform: scale(1.2);
	transform: scale(1.2);
}
.ewt-icon-effect-1b .ewt-icon:hover:after {
	-webkit-transform: scale(1);
	-moz-transform: scale(1);
	-ms-transform: scale(1);
	transform: scale(1);
	opacity: 1;
}
.drop-placeholder {
	background-color: #f6f3f3 !important;
	height: 3.5em;
	padding-top: 12px;
	padding-bottom: 12px;
	line-height: 1.2em;
	border: 3px dotted #cccccc !important;
}
/* --> */
</style>

<span id="manage_info">
</span>

<script>

	$(".edit_question").click(function(){
		var t_id = this.value;
		var c_id = '<?php echo $question_info[c_id]; ?>';
		
		if(confirm("<?php echo $txt_webboard_edit_question_ask; ?>")){
			location.href = "webboard_edit_question.php?t_id="+t_id+"&c_id="+c_id;
	
		}
	});
	

	$(".delete_question").click(function(){
		var t_id = this.value;
		var c_id = '<?php echo $question_info[c_id]; ?>';
		if(confirm("<?php echo $txt_webboard_delete_question_ask; ?>")){
			$("#manage_info").html('<form method="post" id="manage_form"><input type="hidden" name="c_id" value="'+c_id+'"><input type="hidden" name="t_id" value="'+t_id+'"><input type="hidden" name="proc" value="delete_question"></form>');			
			$("#manage_form").submit();
		}
	});
	

	$(".delete_comment").click(function(){

		var a_id = this.value;

		if(confirm("<?php echo $txt_webboard_delete_comment_ask; ?>")){
			$("#manage_info").html('<form method="post" id="manage_comment"><input type="hidden" name="a_id" value="'+a_id+'"><input type="hidden" name="t_id" value="<?=$question_info[t_id];?>"><input type="hidden" name="proc" value="delete_comment"></form>');
			$("#manage_comment").submit();
		}
	});

</script>


<script>

	/*
	$(".add_comment").click(function(){
		var comment = $("#comment_desc").val();
		if(comment.trim()==""){
			$("#comment_desc").focus();
			return false;
		}
		if(confirm("<?php echo $txt_webboard_submit_comment_ask; ?>")){
			$("#manage_info").html('<form method="post" id="manage_comment"><input type="hidden" name="webboard_comment" value="'+comment+'"><input type="hidden" name="t_id" value="<?=$question_info[t_id];?>"><input type="hidden" name="proc" value="add_comment"></form>');
			$("#manage_comment").submit();
		}
	});
	*/

	$(".approve_comment").click(function(){
		//var comment = $("#comment_desc").val();
		var a_id = this.value;
		if(confirm("<?php echo $txt_webboard_approve_comment_ask; ?>")){
			$("#manage_info").html('<form method="post" id="manage_comment"><input type="hidden" name="a_id" value="'+a_id+'"><input type="hidden" name="t_id" value="<?=$question_info[t_id];?>"><input type="hidden" name="proc" value="approve_comment"></form>');
			$("#manage_comment").submit();
		}
	});

	$(".disapprove_comment").click(function(){
		//var comment = $("#comment_desc").val();
		var a_id = this.value;
		if(confirm("<?php echo $txt_webboard_disapprove_comment_ask; ?>")){
			$("#manage_info").html('<form method="post" id="manage_comment"><input type="hidden" name="a_id" value="'+a_id+'"><input type="hidden" name="t_id" value="<?=$question_info[t_id];?>"><input type="hidden" name="proc" value="disapprove_comment"></form>');
			$("#manage_comment").submit();
		}
	});


</script>

<script>

	function setURL()
	{
		var temp = window.prompt('ใส่ URL ที่คุณต้องการสร้างเป็นลิงค์','http://'); 
		if(temp) setsmile('[url]'+temp+'[/url]');
	}
	
	function setImage()
	{
		var temp = window.prompt('ใส่ URL ของรูปที่คุณต้องการให้แสดงในกระทู้ของคุณ','http://'); 
		if(temp) setsmile('[img]'+temp+'[/img]');
	}
	
	function setBold()
	{
		var temp = window.prompt('ใส่ข้อความที่คุณต้องการทำเป็นตัวหนา',''); 
		if(temp) setsmile('[b]'+temp+'[/b]');
	}
	
	function setItalic()
	{
		var temp = window.prompt('ใส่ข้อความที่คุณต้องการทำเป็นตัวเอียง',''); 
		if(temp) setsmile('[i]'+temp+'[/i]');
	}
	
	function setUnderline()
	{
		var temp = window.prompt('ใส่ข้อความที่คุณต้องการให้มีเส้นใต้',''); 
		if(temp) setsmile('[u]'+temp+'[/u]');
	}
	
	function setColor(color,name)
	{
		var temp = window.prompt('ใส่ข้อความที่คุณต้องการให้เป็น สี'+name,''); 
		if(temp) setsmile('[color='+color+']'+temp+'[/color]');
	}
	
	function setsmile(what)
	{
		document.getElementById("question_desc").value=document.getElementById("question_desc").value+what;
		document.myForm.amsg.focus();
	} 

</script>

