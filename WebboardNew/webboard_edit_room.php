<?php

include("../EWT_ADMIN/comtop.php");
include("lib/webboard_function.php");

$chk_config = $db->query("SELECT * FROM w_config WHERE c_config = '1'");
$w_con = mysql_fetch_array($chk_config);

//echo "<br><br><br><br><br>";
//print_r($_POST);

if($_POST["webboardroom_name"]){

	if($_POST[webboardroom_parent]!=""){
		if(check_type_number($_POST[webboardroom_parent])==true){
		}
		else{
			$_POST[webboardroom_parent] = "";
		}
	}

	function viable_permission_number($data){
		if(check_type_number($data)==true){
			if(($data>=1)&&($data<=3)){	return true;}
			else{return false;}
		}
		else{
			return false;
		}
	}
	

	if(getenv(HTTP_X_FORWARDED_FOR)) {$IPn = getenv(HTTP_X_FORWARDED_FOR);}	 
	else {$IPn = getenv("REMOTE_ADDR");}

	$_POST["webboardroom_name"]   = str_replace("'","''",$_POST["webboardroom_name"]);
	$_POST["webboardroom_detail"] = str_replace("'","''",$_POST["webboardroom_detail"]);

	if($_POST["c_view"]){
		if(viable_permission_number($_POST["c_view"])==true){}
		else{$_POST["c_view"]=1;}
	} 
	else {
		$_POST["c_view"]=1;
	}

	if($_POST["c_question"]){
		if(viable_permission_number($_POST["c_question"])==true){}
		else{$_POST["c_question"]=1;}
	} 
	else {
		$_POST["c_question"]=1;
	}

	if($_POST["c_answer"]){
		if(viable_permission_number($_POST["c_answer"])==true){}
		else{$_POST["c_answer"]=1;}
	} 
	else {
		$_POST["c_answer"]=1;
	}

	if($_POST["c_viewporf"]){
		if(viable_permission_number($_POST["c_viewporf"])==true){}
		else{$_POST["c_viewporf"]=1;}
	} 
	else {
		$_POST["c_viewporf"]=1;
	}

	
	$sql_group =" INSERT INTO w_cate (c_name, c_detail, c_parentid, c_use, c_view, c_question, c_answer, c_view_porf) 
	              VALUES ('$_POST[webboardroom_name]','$_POST[webboardroom_detail]','$_POST[webboardroom_parent]','Y',
				          '$_POST[c_view]','$_POST[c_question]','$_POST[c_answer]','$_POST[c_viewporf]')";

	$db->query($sql_group);

	$db->write_log("edit","webboard room","แก้ไขห้อง   ".$_POST[webboardroom_name]);

	if($_POST[webboardroom_parent]!=""){
	?>
		<script>
			location.href = "webboard_room.php?c_id=<?php echo $_POST[webboardroom_parent]; ?>";
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

<h4><?=$txt_webboard_new_room;?></h4>
<p></p> 

</div>
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
	
	<li class=""><?=$txt_webboard_new_room;?></li> 
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
			<p><h4><?=$txt_webboard_new_room;?></h4></p>
		</div>
	</div>
	<div class="card-body">

	<form method="post">
		<div class="panel-group" id="accordion" align="center">

			
				<table border="0" width="80%">
					<tr>
						<td width="20%" style="padding: 10px">
							<b>Room Name: <span style="color:red;">*</span></b>
						</td>
						<td width="80%" style="padding: 10px">
							<input type="text" name="webboardroom_name" style="width: 100%" required>
							<input type="hidden" name="webboardroom_parent" value="<?php echo $room_cid; ?>">
						</td>
					</tr>
					<tr>
						<td style="padding: 10px">
							<b>Detail:</b>
						</td>
						<td style="padding: 10px">
							<textarea name="webboardroom_detail" style="width: 100%; height:100px; resize: none;"></textarea>
						</td>
					</tr> 
					<tr>
						<td style="padding: 10px">
							<b>Permission:</b>
						</td>
						<td style="padding: 10px">
							<table width="100%">
								<tr>
									<td></td>
									<td align="center">ไม่ต้อง login</td>
									<td align="center">ต้อง login<br>(สำหรับทุกคน)</td>
									<td align="center">ต้อง login<br>(เฉพาะบุคคลภายใน)</td>
								</tr>
								<tr>
									<td>สิทธิ์ในการเข้าดูกระทู้ในหมวดนี้	</td>
									<td align="center"><input name="c_view" value="1" type="radio" checked></td>
									<td align="center"><input name="c_view" value="2" type="radio"></td>
									<td align="center"><input name="c_view" value="3" type="radio"></td>
								</tr>
								<tr>
									<td>สิทธิ์ในการตั้งกระทู้ในหมวดนี้</td>
									<td align="center"><input name="c_question" value="1" type="radio" checked></td>
									<td align="center"><input name="c_question" value="2" type="radio"></td>
									<td align="center"><input name="c_question" value="3" type="radio"></td>
								</tr>
								<tr>
									<td>สิทธิ์ในการตอบกระทู้ในหมวดนี้</td>
									<td align="center"><input name="c_answer" value="1" type="radio" checked></td>
									<td align="center"><input name="c_answer" value="2" type="radio"></td>
									<td align="center"><input name="c_answer" value="3" type="radio"></td>
								</tr>
								<tr>
									<td>สิทธิ์ในการดาวน์โหลดไฟล์ในหมวดนี้</td>
									<td align="center"><input name="c_viewporf" value="1" type="radio" checked></td>
									<td align="center"><input name="c_viewporf" value="2" type="radio"></td>
									<td align="center"><input name="c_viewporf" value="3" type="radio"></td>
								</tr>
							</table>
						</td>
					</tr> 
				</table>
			
				
		</div>
		
		<div class="float-center text-center" style="top:18px;margin-bottom:10px;"> 
				
			<button id="submit_button" type="submit" class="btn btn-default btn-sm" >
				<i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?=$txt_webboard_new_room_add;?>
			</button>
		</div>
	</form>

	<script>
	</script>

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