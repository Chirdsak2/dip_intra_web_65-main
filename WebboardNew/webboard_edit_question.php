<?php
include("../EWT_ADMIN/comtop.php");
include("lib/webboard_function.php");

$chk_config = $db->query("SELECT * FROM w_config WHERE c_config = '1'");
$w_con = mysql_fetch_array($chk_config);

if($_POST['question_tid']){
	if(check_type_number($_POST['question_tid'])==true){
		$question_tid = $_POST['question_tid'];
	
		//$chk_config = $db->query("SELECT * FROM site_info WHERE site_info_id = '1'");
		//$CO = mysql_fetch_array($chk_config);

		//echo "<br><br><br><br><br><br><br>";
		//echo "<pre>";
		//print_r($_POST);
		//print_r($CO);
		//print_r($_FILES);
		//echo "</pre>";

		$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/";
			
		if(trim($_POST["question_topic"])==""){
			
			?>
				<span>
					<form action="webboard_edit_question.php?t_id=<?php echo $_POST['question_tid']; ?>&c_id=<?php echo $_POST['question_room']; ?>" method="post" id="manage_info">
					<?php
						$_POST["question_topic"] = "";
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
						title: 'Must have Topic',
						content: 'Topic is required',
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
			
				
		if(trim($_POST["question_desc"])==""){
			
			?>
				<span>
					<form action="webboard_edit_question.php?t_id=<?php echo $_POST['question_tid']; ?>&c_id=<?php echo $_POST['question_room']; ?>" method="post" id="manage_info">
					<?php
						$_POST["question_desc"] = "";
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
						title: 'Must Have Description',
						content: 'Description is required',
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

		
		if(trim($_POST["question_by"])==""){
			
			?>
				<span>
					<form action="webboard_edit_question.php?t_id=<?php echo $_POST['question_tid']; ?>&c_id=<?php echo $_POST['question_room']; ?>" method="post" id="manage_info">
					<?php
						$_POST["question_by"] = "";
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
						title: 'Must Input Name',
						content: 'Name is required',
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
		
		if($_POST["question_email"]){
			if (!filter_var($_POST["question_email"], FILTER_VALIDATE_EMAIL)) {
			
			?>
				<span>
					<form action="webboard_edit_question.php?t_id=<?php echo $_POST['question_tid']; ?>&c_id=<?php echo $_POST['question_room']; ?>" method="post" id="manage_info">
					<?php
						$_POST["question_email"] = "";
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
						title: 'Incorrect Email Format',
						content: 'Email Format is incorrect',
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
		}
		

		//=================
		//  Attachment
		//=================

		if($_FILES[question_file][name]){
			
			//check extension
			$array_ext = explode(",",$w_con[c_img]);
			$file_ext  = array_reverse (explode(".",$_FILES[question_file][name]));
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
						<form action="webboard_edit_question.php?t_id=<?php echo $_POST['question_tid']; ?>&c_id=<?php echo $_POST['question_room']; ?>" method="post" id="manage_info">
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

			if($_FILES[question_file][size]>($w_con[c_sizeupload]*1000)){
				
				?>
					<span>
						<form action="webboard_edit_question.php?t_id=<?php echo $_POST['question_tid']; ?>&c_id=<?php echo $_POST['question_room']; ?>" method="post" id="manage_info">
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
		
		
		if($_POST[question_room]!=""){
			if(check_type_number($_POST[question_room])==true){
			}
			else{
				$_POST[question_room] = "";
			}
		}

		if(getenv(HTTP_X_FORWARDED_FOR)) {$IPn = getenv(HTTP_X_FORWARDED_FOR);}	 
		else {$IPn = getenv("REMOTE_ADDR");}

		$_POST["question_topic"]   = safety_clean($_POST["question_topic"]);
		//$_POST["question_room"]    = safety_clean($_POST["question_room"]);
		$_POST["question_desc"]    = safety_clean($_POST["question_desc"]);
		//$_POST["question_show"]    = safety_clean($_POST["question_show"]);

		$_POST["question_by"]      = safety_clean($_POST["question_by"]);
		$_POST["question_email"]   = safety_clean($_POST["question_email"]);


		$attach_sql = $db->query("SELECT keyword
								  FROM w_question
								  LEFT JOIN w_cate ON w_question.c_id=w_cate.c_id
								  WHERE t_id='$question_tid'");

		$attach_info = $db->db_fetch_array($attach_sql);
		
		if($_POST["question_attach_remove"]=="Yes"){
			unlink($Globals_Dir.'webboard_attach/'.$attach_info['keyword']);

			$sql_group = " UPDATE w_question 
						   SET    keyword    = ''
						   WHERE  t_id='$question_tid'";

			$db->query($sql_group);
		}		
		
		//=================
		//  Copy File
		//=================

		//$tid_sql    = "SELECT MAX(t_id) as t_id FROM w_question";
		//$tid_result = $db->query($tid_sql);
		//$id         = mysql_fetch_array($tid_result); 

		$current_id = $question_tid;

		if($_FILES[question_file][name]){

			$file    = $_FILES[question_file][tmp_name];
			$picname = "attachment".$current_id.".".$file_ext;

			unlink($Globals_Dir.'webboard_attach/'.$attach_info['keyword']);
			copy($file,$Globals_Dir.'webboard_attach/'.$picname);

			//Update DB

			$sql_attachment = "UPDATE w_question SET keyword = '$picname' WHERE t_id='$current_id'";
			$db->query($sql_attachment);

		}
		//exit();


		$sql_group = " UPDATE w_question 
					   SET    t_name    = '$_POST[question_topic]',
					          t_detail  = '$_POST[question_desc]',
							  q_name    = '$_POST[question_by]',
							  q_email   = '$_POST[question_email]'
					   WHERE  t_id='$question_tid'";

		$db->query($sql_group);

		$db->write_log("edit","webboard question","แก้ไขหัวข้อกระทู้   ".$_POST[question_topic]);

		?>
			<script>
			location.href = "webboard_question.php?t_id=<?php echo $question_tid; ?>";
			</script>

		<?php	

		exit();
	}
	else if($_POST['question_room']){
	?>
		<script>
			location.href = "webboard_room.php?c_id=<?php echo $_POST['question_room']; ?>";
		</script>

	<?php
	}else{
		?>
		<script>
			location.href = "webboard_room.php";
		</script>
	
	<?php
	}	
}
else if(trim($_GET['t_id'])==""){

	if(check_type_number($_POST['question_room'])==true){}
	else{$_POST['question_room']="";}

	if($_POST['question_room']){
	?>
		<script>
			location.href = "webboard_room.php?c_id=<?php echo $_POST['question_room']; ?>";
		</script>

	<?php
	}else if($_GET['c_id']){
		?>
		<script>
			location.href = "webboard_room.php?c_id=<?php echo $_GET['c_id']; ?>";
		</script>
	
	<?php
	}else{
		?>
		<script>
			location.href = "webboard_room.php";
		</script>
	
	<?php
	}		
}
	
?>  

<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");

$ban_cid = (int)(!isset($_GET['ban_cid']) ? 0 : $_GET['ban_cid']);


if($_GET['c_id']){
	if(check_type_number($_GET['c_id'])==true){
		$room_cid = $_GET['c_id'];
	}
}
else{
	$room_cid = '';
}

if($_GET['t_id']){
	if(check_type_number($_GET['t_id'])==true){
		$question_tid = $_GET['t_id'];
	}
}
else{
	if($_GET['c_id']){
	?>
	<script>
		location.href = "webboard_room.php?c_id=<?php echo $room_cid; ?>";
	</script>

<?php
	}else{
		?>
		<script>
			location.href = "webboard_room.php";
		</script>
	
	<?php
	}	
}

$perpage = 10;
$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);

if($page <= 0) $page = 1;

$start = ($page * $perpage) - $perpage;

$_sql = $db->query("SELECT *
					FROM w_cate
					{$wh} 
					ORDER BY w_cate.c_id DESC LIMIT {$start} , {$perpage} ");

$statement = "SELECT count(c_id) AS b
			  FROM w_cate
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

<h4><?=$txt_webboard_edit1_question;?></h4>
<p></p> 

</div>

<?php
	$question_sql = $db->query("SELECT *
								FROM w_question
								LEFT JOIN w_cate ON w_question.c_id=w_cate.c_id
								WHERE t_id='$question_tid'");

	$question_info = $db->db_fetch_array($question_sql);
?>

<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
	<li><a href="webboard_main.php"><?=$txt_webboard_menu_main;?></a></li>
	
	<?php 
		if($room_cid!=""){ 
			$room_array = group_bread($room_cid);

			for($r=0;$r<sizeof($room_array);$r++){?>
			
			<li><a href="webboard_room.php?c_id=<?=$room_array[$r];?>"><?=room_name($room_array[$r]);?></a></li>

		<?php	
			}
			
		?>

		<li><a href="webboard_room.php?c_id=<?=$room_cid;?>"><?=room_name($room_cid);?></a></li>

	<?php } ?>

	<li><a href="webboard_question.php?t_id=<?=$question_info[t_id];?>"><?=$question_info[t_name];?></a></li> 
	<li class=""><?=$txt_webboard_edit1_question;?></li> 
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
					<i class="fas fa-plus-circle"></i>&nbsp;<?=$txt_webboard_edit1_question;?>
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
			<p><h4><?=$txt_webboard_edit1_question;?></h4></p>
		</div>
	</div>
	<div class="card-body">

	<form action="webboard_edit_question.php" method="post" enctype="multipart/form-data">

	<div class="panel-group" id="accordion" align="center">



		<table border="0" width="80%">
			<tr>
				<td width="20%" style="padding: 10px">
					<b>Topic: <span style="color:red;">*</span></b>
				</td>
				<td width="80%" style="padding: 10px">
					<input type="text" name="question_topic" style="width: 100%" required 
					       value="<?php if($_POST["data_question_topic"]){echo $_POST["data_question_topic"];} else {echo $question_info["t_name"];} ?>">
					<input type="hidden" name="question_room" value="<?php echo $room_cid; ?>">
					<input type="hidden" name="question_tid" value="<?php echo $question_tid; ?>">
				</td>
			</tr>
			<tr>
				<td style="padding: 10px">
					<b>Detail: <span style="color:red;">*</span></b>
				</td>
				<td style="padding: 10px">
					<textarea name="question_desc" id="question_desc" style="width: 100%; height:100px; resize: none;" required><?php if($_POST["data_question_desc"]){echo $_POST["data_question_desc"];} else {echo $question_info["t_detail"];} ?></textarea>
				</td>
			</tr> 
			<tr>
				<td>
				</td>
				<td align="center" bgcolor="#FFFFFF">
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
				<td style="padding: 10px">
					<b>File:</b>
				</td>
				<td style="padding: 10px">
					<?php if($question_info["keyword"]){?> 
					Current File: <a href="<?php echo "../ewt/".$_SESSION["EWT_SUSER"]."/webboard_attach/".$question_info["keyword"]; ?>" download><?php echo $question_info["keyword"]; ?></a>
					<br> <input type="checkbox" name="question_attach_remove" value="Yes">  <b>Remove Attachment</b>
					<br><br>
					<?php } ?>

					<input type="file" name="question_file"  style="width: 80%;">
					<br> Allow only: <span style="color:red;"><?php echo $w_con[c_img]; ?></span>
					<br> Maximum File Size: <span style="color:red;"><?php echo $w_con[c_sizeupload]/1000; ?> MB</span>
				</td>
			</tr> 
			<tr>
				<td width="20%" style="padding: 10px">
					<b>By: <span style="color:red;">*</span></b>
				</td>
				<td width="80%" style="padding: 10px">
					<input type="text" name="question_by" style="width: 100%" value="<?php if($_POST["data_question_by"]){echo $_POST["data_question_by"];} else {echo $question_info["q_name"];} ?>" required>
				</td>
			</tr>
			<tr>
				<td width="20%" style="padding: 10px">
					<b>Email:</b>
				</td>
				<td width="80%" style="padding: 10px">
					<input type="text" name="question_email" style="width: 100%" value="<?php if($_POST["data_question_email"]){echo $_POST["data_question_email"];} else {echo $question_info["q_email"];} ?>">
				</td>
			</tr>
			<!-- <tr>
				<td style="padding: 10px">
					<b>Approve:</b>
				</td>
				<td style="padding: 10px">
					<input name="question_show" type="checkbox" value="Y"> 
				</td>
			</tr>  -->
		</table>

	</div>
	
	<div class="float-center text-center" style="top:18px;margin-bottom:10px;"> 
			
		<button id="submit_button" type="submit" class="btn btn-default btn-sm" >
			<i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?=$txt_webboard_edit_question;?>
		</button>
		
	</div>

	</form>

</div>
</div>	

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