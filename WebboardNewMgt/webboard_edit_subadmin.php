<?php

include("../EWT_ADMIN/comtop.php");
include("lib/webboard_function.php");


$depth = 0;

function list_room($c_id,$depth){
  
  global $db;
  global $depth;
  global $_GET;
  

  $sql_subcate = "SELECT * FROM w_cate 
                  WHERE c_parentid = '$c_id'";
  
  $result_subcate = $db->query($sql_subcate);

  $order_subcate = 1;

  	while($subcate = $db->db_fetch_array($result_subcate)){
		?>
			<? if(trim($depth)!="0"){ 
				//echo "- ";
				} ?> 
				
		<?php for($e=0;$e<($depth+1);$e++){?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?> 

		<?php 
			$query_chk = $db->query("   SELECT w_cate.c_id 
										FROM w_permission 
										LEFT JOIN w_cate ON w_cate.c_id = w_permission.c_id 
										LEFT JOIN w_admin ON w_admin.t_id = w_permission.t_id 
										WHERE w_permission.t_id = '".$_GET['t_id']."' 
											AND w_cate.c_id = '".$subcate[c_id]."' 
										ORDER BY w_cate.c_id ASC"); 
			$chk = $db->db_fetch_array($query_chk);
		?>

		<input <?php if($subcate[c_id]==$chk['c_id']){echo "checked";}else{;}?> 
		       name="cate[]" value="<?php echo $subcate['c_id'];?>" 
			   type="checkbox"> <?php echo $subcate[c_name]; ?><br>

		<?php 
		$sql_subcate1 = "SELECT * FROM w_cate 
						WHERE c_parentid = '$subcate[c_id]'";

		$result_subcate1 = $db->query($sql_subcate1);
		$subcate1_row    = mysql_num_rows($result_subcate1);

		
		if($subcate1_row>0){
			$depth++;
			list_room($subcate[c_id],$depth);
		
		}
		else{
		
		}
    
	$order_subcate++;
	} 
	$depth--;
}

//echo "<br><br><br><br><br>";
//print_r($_POST);

if($_POST["sadmin_name"]){
	$date = date('Y-m-d');
	##ตรวจข้อมูลซ้ำ##
	$query_ch_sadmin = "SELECT t_id FROM w_admin WHERE t_id = '".$_POST['hdd_uid']."'";	
	$result_group = $db->query($query_ch_sadmin);
	$num_sadmin = $db->db_num_rows($result_group);
	
	if($_POST['hdd_uid']==0){
		$_POST['hdd_uid'] = $_GET['t_id'];
	}
	
	if($num_sadmin == 0){
	
		$query_add_sadmin ="UPDATE w_admin SET 
							t_id='".$_POST['hdd_uid']."',
							t_name='".$_POST['sadmin_name']."',
							t_type='N',
							t_login='".$date."'
							WHERE t_id='".$_GET['t_id']."'";
				 
		$add_sadmin = $db->query($query_add_sadmin);
		
		$db->write_log("edit","webboard admin","แก้ไข webboard admin ".$_POST['sadmin_name']);
	}
	
	
	$query_permisssion_del = "DELETE FROM w_permission WHERE t_id='".$_POST['hdd_uid']."'";
	$permisssion_del = $db->query($query_permisssion_del);
	
	foreach ($_POST['cate'] as $value) {
			
		$query_permisssion = "INSERT INTO w_permission(t_id, c_id) 
								VALUES ('".$_POST['hdd_uid']."','".$value."')";
		$permisssion = $db->query($query_permisssion);
	}
	
	echo "<script>";
	echo "window.location.href='webboard_subadmin.php';";
	echo "</script>";
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

<h4>แก้ไขผู้ดูแลหมวดกระทู้</h4>
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
			
			<!--<li><a href="webboard_room.php?c_id=<?=$room_array[$r];?>"><?=room_name($room_array[$r]);?></a></li>-->

		<?php	
			}
			
		?>
		

	<?php } ?>
	
	<li><a href="webboard_subadmin.php?c_id=<?=$room_cid;?>">ผู้ดูแลหมวดกระทู้</a></li>
	<li><a href="webboard_edit_subadmin.php?c_id=<?=$room_cid;?>">แก้ไขผู้ดูแลหมวดกระทู้</a></li>
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
			<p><h4>แก้ไขผู้ดูแลหมวดกระทู้</h4></p>
		</div>
	</div>
	<div class="card-body">

	<form name="form1" method="post" action="#">
		<div class="panel-group" id="accordion" align="center">
		<?php
			$query_de = $db->query("SELECT * FROM w_admin  WHERE t_id = '".$_GET['t_id']."'");
			$DE = $db->db_fetch_array($query_de);
		?>
			
				<table border="0" width="80%">
					<tr>
						<td width="20%" valign = "top" style="padding: 10px">
							<b>ชื่อ : <span style="color:red;">*</span></b>
						</td>
						<td width="80%" style="padding: 10px">
						
							<input type="text" name="sadmin_name" value = "<?php echo $DE['t_name'];?>" style="width: 80%" required>
							
							<a href="#" onClick="popo=window.open('site_s_member.php','popug','width=800,height=600,scrollbars=1,resizable=1');popo.focus();"><img src="../images/user_pos.gif" alt="เลือกจากบุคคลภายในองค์กร" width="20" height="20" border="0" align="absmiddle"></a>&nbsp;
							
							<a href="#" onClick="popo=window.open('site_s_professor_c.php','popug','width=800,height=600,scrollbars=1,resizable=1');popo.focus();">
							<img src="../images/bar_user.gif" alt="เลือกจากรายการผู้เชี่ยวชาญของระบบกระทู้" width="20" height="20" border="0" align="absmiddle">
							</a>
							
							<input type="hidden" name="hdd_uid" id="hdd_uid"></td>
						</td>
					</tr>
					<tr>
						<td valign = "top" style="padding: 10px;">
							<b>หมวดที่ดูแล:</b>
						</td>
						<!-- <?php $query_cate = $db->query("SELECT * FROM w_cate ORDER BY c_id ASC"); ?>
						<td align="left" style="padding: 10px">
						<?php while($cate = $db->db_fetch_array($query_cate)){?>
						<?php 
							$query_chk = $db->query("SELECT w_cate.c_id 
							                         FROM w_permission 
													 LEFT JOIN w_cate ON w_cate.c_id = w_permission.c_id 
													 LEFT JOIN w_admin ON w_admin.t_id = w_permission.t_id 
													 WHERE w_permission.t_id = '".$_GET['t_id']."' 
														   AND w_cate.c_id = '".$cate['c_id']."' 
													 ORDER BY w_cate.c_id ASC"); 
							$chk = $db->db_fetch_array($query_chk);
						?>
						<?php if($cate['c_id']==$chk['c_id']){$ch = "checked";}else{$ch="";}?>
							<input name="cate[]" value="<?php echo $cate['c_id'];?>" type="checkbox" <?php echo $ch;?>> <?php echo $cate['c_name'];?><br>
						<?php } ?>
						</td> -->
						
						<td>
							<span style="color:red;padding:10px;"><b>หมายเหตุ:</b></span> ไม่รวมหมวดย่อยที่อยู่ภายใต้<br><br>
							<?php list_room(0, 1); ?>
						</td>
					</tr> 
				</table>
			
				
		</div>
		
		<div class="float-center text-center" style="top:18px;margin-bottom:10px;"> 
			<button id="submit_button" type="submit" class="btn btn-default btn-sm" >
				<i class="far fa-arrow-alt-circle-right"></i>&nbsp;แก้ไขผู้ดูแลหมวดกระทู้
			</button>
		</div>
	</form>

<?php

/* $date = date('Y-m-d');

if($_POST['proc']=="add"){
	$query_add_sadmin ="INSERT INTO w_admin(t_name, t_type, t_login) 
	              VALUES ('".$_POST['sadmin_name']."','N','".$date."')";
	$add_sadmin->query($query_add_sadmin);
	foreach ($_POST['cate'] as $value) {
		$query_t_id = $db->query("SELECT * FROM w_admin WHERE t_name = '".$_POST['sadmin_name']."'");
		$t_id = $db->db_fetch_array($query_t_id);
		
		$query_permisssion .= "INSERT INTO w_permission(t_id, c_id) 
							VALUES ('".$t_id['t_name']."','".$value."')";
	}
	$permisssion->query($query_permisssion);
} */
?>

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