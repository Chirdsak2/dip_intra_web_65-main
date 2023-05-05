<?php
include("../EWT_ADMIN/comtop.php");

$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/";

$today = explode ("-",date("Y-m-d"));

function DiffToText_new($diff)
            {
          /*  if (floor($diff/31536000))
                        {
                        $x = floor($diff / 31536000);
                        echo " $x ปี ";
                        $diff = $diff - ($x * 31536000);
                        return DiffToText_new($diff);
                        }
            elseif (floor($diff/2678400))
                        {
                        $x = floor($diff / 2678400);
                        echo " $x เดือน ";
                        $diff = $diff - ($x * 2678400);
                        return DiffToText_new($diff);
                        }
            else*/if ($diff>=86400)
                        {
                        $x = floor($diff / 86400);
						//if($x  > 0){
                        echo " $x วัน";
                        $diff = $diff - ($x * 86400);
                        return DiffToText_new($diff);
						//}
                        }
            elseif ($diff>=3600)
                        {
                        $x = floor($diff / 3600);
                        echo " $x ชั่วโมง";
                        $diff = $diff - ($x * 3600);
                        return DiffToText_new($diff);
                        }

            elseif ($diff>=60)
                        {
                        $x = floor($diff / 60);
                        echo " $x นาที ";
                        $diff = $diff - ($x * 60);
                        return DiffToText_new($diff);
                        }
            else if ($diff)
						if($diff > 0){
                        echo " $diff วินาที ";
						}
            }
if(empty($start_date) && $Flag ==''){
$start_date = date("d/m/").(date("Y")+543);
}
if(empty($end_date) && $Flag ==''){
$end_date = date("d/m/").(date("Y")+543);
}
 if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
//    Set $limit,  $limit = Max number of results per 'page' 

$limit = $CO[c_number];
if(empty($limit)){
$limit =10;
}
	$begin =($offset+1); 
    $end = ($begin+($limit-1)); 
    if ($end > $totalrows) { 
        $end = $totalrows; 
    }


if($_POST["start_date"]){$date1 = explode("/",$_POST["start_date"]);}
if($_POST["end_date"]){$date2 = explode("/",$_POST["end_date"]);}

//echo "<br><br><br><br><br>";
//print_r($_POST);
//echo $start_date."<br>";
//echo $end_date."<br>";

?>  

<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");

$ban_cid = (int)(!isset($_GET['ban_cid']) ? 0 : $_GET['ban_cid']);

include("lib/webboard_function.php");

/*
$perpage = 10;
$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);

if($page <= 0) $page = 1;

$start = ($page * $perpage) - $perpage;

$wh = "WHERE c_parentid='0' AND c_use = 'Y'";

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
*/

?>

<div class="row m-b-sm">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<!--start card -->
<div class="card">
<!--start card-header -->
<div class="card-header">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

<h4><?=$txt_webboard_menu_main;?></h4>
<p></p> 

</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><?=$txt_webboard_menu_main;?></li>
<!-- <li class=""><?=$txt_webboard_menu_user;?></li>        -->
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
			<p><h4><?=$txt_webboard_menu_main;?></h4></p>
		</div>
	</div>
	<div class="card-body">

	<div class="panel-group" id="accordion">
		
		<div class="panel panel-default ">

			<div class="panel-heading ewt-bg-success">
			</div>
		
			<div class="">
				<div class="panel-body">
				
					<form name="form1" method="post" action=""> 

						<table width="80%" border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
							<tr>
								<td colspan="2" bgcolor="#FFFFFF" class="ewttablehead" style="padding:10px;"><b>ค้นหา</b></td>
							</tr>
							<tr>
								<td width="25%" bgcolor="#FFFFFF" style="padding:10px;" align="center">วันที่ :<span style="color:red;">*</span> </td>
								<td width="30%" bgcolor="#FFFFFF" style="padding:10px;">

									<div class='input-group date datepicker' id='datetimepicker' >
										<input value="<?php if($_POST[start_date]){echo $date1[0]."/".$date1[1]."/".($date1[2]-543);} else {echo $today[2]."/".$today[1]."/".$today[0];}?>" 
										       name="start_date" id="start_date" type="text"  class="form-control form-control-sm " readonly="readonly" required/>
										<span class="input-group-addon">
											<a href="#date" onClick="return show_calendar('form1.date_n');" >
												<i class="far fa-calendar-alt"></i>
											</a>
										</span>
									</div>

								</td>
								<td width="15%" bgcolor="#FFFFFF" style="padding:10px;" align="center">
									ถึง 
								</td>
								<td width="30%" bgcolor="#FFFFFF" style="padding:10px;">

									<div class='input-group date datepicker' id='datetimepicker' >
										<input value="<?php if($_POST[end_date]){echo $date2[0]."/".$date2[1]."/".($date2[2]-543);}  else {echo $today[2]."/".$today[1]."/".$today[0];}?>"  
										       name="end_date" id="end_date" type="text"  class="form-control form-control-sm " readonly="readonly" required/>
										<span class="input-group-addon">
											<a href="#date" onClick="return show_calendar('form1.date_n');" >
												<i class="far fa-calendar-alt"></i>
											</a>
										</span>
									</div>
								</td>
							</tr>
							<tr>
								<td bgcolor="#FFFFFF" style="padding:10px;"><b>แสดง : </b></td>
								<td colspan="3" width="73%" bgcolor="#FFFFFF" style="padding:10px;">
									<select class="form-control" name="query_show">
									<option value="" <?php if($_POST[query_show]==''){ echo "selected";}?>>--ทั้งหมด--</option>
									<option value="1" <?php if($_POST[query_show]=='1'){ echo "selected";}?> >ที่ตอบกลับแล้ว</option>
									<option value="2" <?php if($_POST[query_show]=='2'){ echo "selected";}?>>ที่ยังไม่ได้ตอบกลับ</option>
									</select>
								</td>
							</tr>
							<tr>
							<td colspan="4" align="center" bgcolor="#FFFFFF" style="padding:10px;">
							    <input class="btn btn-info  btn-ml" type="submit" name="Submit" value="แสดงข้อมูล">
								<input name="Flag" type="hidden" id="Flag" value="View"></td>
							</tr>
						</table>

					</form>
					
				</div>
			</div>

			<div class="panel-footer ewt-bg-white text-right" style="background-color: #FFC153;">

				<div class="ewt-icon-wrap ewt-icon-effect-1 ewt-icon-effect-1b">

				</div>
				
			</div>

		</div>

		<br>

		<div class="panel panel-default ">

			<div class="">
				<div class="panel-body">


				<?php
					if($Flag == "View"){
					if($start_date == "" AND $end_date == ""){
					$con = "";
					$date_name = "";
					}elseif($start_date != "" AND $end_date == ""){
					$st = explode("/",$start_date);
					$con = " AND (t_date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
					$date_name = "วันที่".$start_date;
					}elseif($start_date == "" AND $end_date != ""){
					$st = explode("/",$end_date);
					$con = " AND (t_date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
					$date_name = "วันที่".$end_date;
					}else{
					$st = explode("/",$start_date);
					$en = explode("/",$end_date);
					$con = " AND (t_date BETWEEN '".($st[2] -543)."-".$st[1]."-".$st[0]."' AND '".($en[2] - 543)."-".$en[1]."-".$en[0]."') ";
					$date_name = "วันที่".$start_date."ถึง วันที่".$end_date;
					}

					$db->write_log("view","webboard","ดูรายงานการใช้งาน webboard");
					if($query_show == ''){
					$sql = mysql_query("select w_question.*,w_cate.c_name from  w_question,w_cate where 1=1 and  w_question.c_id =w_cate.c_id ".$con."  order by t_date DESC,t_time DESC  ");
					}else{
					$sql = mysql_query("select w_question.*,w_cate.c_name from  w_question,w_cate where 1=1 and  w_question.c_id =w_cate.c_id  ".$con." order by t_date DESC,t_time DESC ");
					}
					//$A = mysql_fetch_row($sql_ct);

					?>
					<table width="100%" border="0" cellspacing="0" cellpadding="1">
					<tr> 
						<td align="center"><table width="94%" border="0" cellpadding="2" cellspacing="1" class="ewtsubmenu">
						<tr>
							<td colspan="5" align="center" class="MemberHead"><strong>รายชื่อกลุ่มเป้าหมายในการให้บริการ</strong></td>
							</tr> 
						<tr>
							<td colspan="5" align="center" class="MemberHead"><?php echo $date_name;?> </td>
							</tr>
						<tr>
							<td colspan="5"><span class="cellcal">การให้บริการด้าน</span> การให้บริการข้อมูลอิเล็กทรอนิกส์ผ่านทางระบบอินเตอร์เน็ต </td>
							</tr>
						<tr>
							<td colspan="5" align="right" class="MemberHead"><img src="../images/checked_n2.gif" width="15" height="15" align="absmiddle" style="background-color: #66FF66" >&nbsp;มาใหม่&nbsp;<img src="../images/checked_n2.gif" width="15" height="15" align="absmiddle" style="background-color: #FF0000" >&nbsp;รอคำตอบ&nbsp;<img src="../images/checked_n2.gif" width="15" height="15" align="absmiddle" style="background-color: #FFFFFF" >&nbsp;ตอบแล้ว&nbsp;</td>
							</tr>
						</table></td>
					</tr>
					<tr> 
						<td width="47%" align="center"><table width="94%" border="0" cellpadding="2" cellspacing="1" bgcolor="#000000" class="ewttableuse">
						<tr>
							<td width="4%" align="center" class="ewttablehead"><strong>ลำดับ</strong></td>
							<td width="11%" align="center" class="ewttablehead"><strong>ข้อมูลที่โพส</strong></td>
							<td width="5%" align="center" class="ewttablehead">หมวด</td>
							<td width="9%" align="center" class="ewttablehead"><strong>ชื่อผู้โพสข้อมูล</strong></td>
							<td width="7%" align="center" class="ewttablehead"><strong>e-mail address </strong></td>
							<td width="4%" align="center" class="ewttablehead"><strong>เลขที่</strong></td>
							<td width="9%" align="center" class="ewttablehead"><strong>วัน/เดือน/ปี<br>
							ที่ติดต่อ</strong></td>
							<td width="7%" align="center" class="ewttablehead"><strong>เวลาติดต่อ</strong></td>
							<td width="9%" align="center" class="ewttablehead"><strong>วัน/เดือน/ปี <br>  
							ที่ตอบกลับ </strong></td>
							<td width="9%" align="center" class="ewttablehead"><strong>เวลาตอบกลับ</strong></td>
							<td width="7%" align="center" class="ewttablehead"><strong>หน่วยงาน</strong></td>
							<td width="19%" align="center" class="ewttablehead"><strong>ระยะเวลาการให้บริการ(นาที)</strong></td>
							</tr>
						<?php
				$i=1;
				while($R=$db->db_fetch_array($sql)){
					$date = explode("-",$R[t_date]);
					$time = explode(":",$R[t_time]);
					$d2 = mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0]);
					$d_df = mktime(0, 0, 0, date(m), date(d), date(Y));
					
					if($R[user_id] != '0'){
								$db->query("USE ".$EWT_DB_USER);
								$sql_img = "select * from gen_user,emp_type where gen_user.emp_type_id = emp_type.emp_type_id and gen_user_id = '".$R[user_id]."'";
								$query = $db->query($sql_img);
								$rec_img = $db->db_fetch_array($query);
								$db->query("USE ".$EWT_DB_NAME);
									$name_a = stripslashes($rec_img[name_thai].'   '.$rec_img[surname_thai]); 
									$mail = $rec_img[email_person];
									$emp_type  = $rec_img[emp_type_name];
									$user_id = $rec_img[emp_id];
					}else{
									$name_a = $R[q_name]; 
									$mail = $R[q_email];
									$emp_type  = 'ประชาชนทั่วไป';
									$user_id = $R[t_id];
					}
					
					$sql_an = "select * from w_answer where t_id = '".$R[t_id]."' order by a_id ASC";
					$query_an = $db->query($sql_an);
					$rec = $db->db_fetch_array($query_an);
					$date_an = explode("-",$rec[a_date]);
					$time_an = explode(":",$rec[a_time]);
					if($db->db_num_rows($query_an)>0){
					$d1 = mktime($time_an[0], $time_an[1], $time_an[2], $date_an[1], $date_an[2], $date_an[0]);
					$color = "#FFFFFF";
					}else{
					$d1 = 0;
					
						if(($d_df-$d2 ) >86400){
							$color = "#c61f1f";
						}else if(($d_df-$d2 ) < 86400){
							$color = "#20e658";
						}
					}
					$diff = $d1-$d2;
						


			if($query_show == '1'){
				if($db->db_num_rows($query_an)>0){
				
				?>
				<tr bgcolor="<?php echo $color;?>">
					<td align="center" ><?php echo $i+$offset; ?></td>
					<td ><?php echo $R[t_name]; ?></td>
					<td ><?php echo $R[c_name]; ?></td>
					<td ><?php echo $name_a; ?></td>
					<td ><?php echo $mail; ?></td>
					<td ><?php echo $user_id; ?></td>
					<td ><?php echo $R[t_date]; ?></td>
					<td ><?php echo $R[t_time]; ?></td>
					<td ><?php echo $rec[a_date];?></td>
					<td ><?php echo $rec[a_time];?></td>
					<td align="center" ><?php echo $emp_type;?></td>
					<td ><?php echo DiffToText_new($diff);?></td>
					</tr>
				<?php 
				$i++;
				}
				}else if($query_show == '2'){
				if($db->db_num_rows($query_an)==0){
				
				?>
				<tr bgcolor="<?php echo $color;?>">
					<td align="center" ><?php echo $i+$offset; ?></td>
					<td ><?php echo $R[t_name]; ?></td>
					<td ><?php echo $R[c_name]; ?></td>
					<td ><?php echo $name_a; ?></td>
					<td ><?php echo $mail; ?></td>
					<td ><?php echo $user_id; ?></td>
					<td ><?php echo $R[t_date]; ?></td>
					<td ><?php echo $R[t_time]; ?></td>
					<td ><?php echo $rec[a_date];?></td>
					<td ><?php echo $rec[a_time];?></td>
					<td align="center" ><?php echo $emp_type;?></td>
					<td ><?php echo DiffToText_new($diff);?></td>
					</tr>
				<?php 
				$i++;
				}
				}else{
				?>
				<tr bgcolor="<?php echo $color;?>">
					<td align="center" ><?php echo $i+$offset; ?></td>
					<td ><?php echo $R[t_name]; ?></td>
					<td ><?php echo $R[c_name]; ?></td>
					<td ><?php echo $name_a; ?></td>
					<td ><?php echo $mail; ?></td>
					<td ><?php echo $user_id; ?></td>
					<td ><?php echo $R[t_date]; ?></td>
					<td ><?php echo $R[t_time]; ?></td>
					<td ><?php echo $rec[a_date];?></td>
					<td ><?php echo $rec[a_time];?></td>
					<td align="center" ><?php echo $emp_type;?></td>
					<td ><?php echo DiffToText_new($diff);?></td>
					</tr>
				<?php 
				$i++;
				}
				
			} 
				
				?>
				<!--<tr>
					<td colspan="11" bgcolor="#FFFFFF">&nbsp;</td>
					</tr>-->
				</table></td>
			</tr>
			</table>

<?php } ?>
			<br>
			<div class="text-right">
				<table border="0" align="right">
					<tr>
						<td style="padding:3px;">

							<a href="webboard_report_usage_csv_export.php?query_show=<?=$_POST[query_show]; ?>&start_date=<?=str_replace("/","-",$start_date);?>&end_date=<?=str_replace("/","-",$end_date);?>" target="_blank">
							<button type="button" class="btn btn-info  btn-ml">
								<i class="fas fa-plus-circle"></i>&nbsp;Export Csv File
							</button>
							</a>
						</td>
						<!-- <td style="padding:3px;">
							<button type="button" class="btn btn-info  btn-ml">
								<i class="fas fa-plus-circle"></i>&nbsp;Export PDF File
							</button>
						</td> -->
						<td style="padding:3px;">
							<a href="webboard_report_usage_excel_export.php?query_show=<?=$_POST[query_show]; ?>&start_date=<?=str_replace("/","-",$start_date);?>&end_date=<?=str_replace("/","-",$end_date);?>" target="_blank">
							<button type="button" class="btn btn-info  btn-ml">
								<i class="fas fa-plus-circle"></i>&nbsp;Export Excel File
							</button>
							</a>
						</td>
					</tr>
				</table>
			</div>

				</div>
			</div>
			

			<div class="panel-footer ewt-bg-white text-right" style="background-color: #FFC153;">

				<div class="ewt-icon-wrap ewt-icon-effect-1 ewt-icon-effect-1b">

				</div>
			</div>

		</div>

	</div>

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


<script >
$(document).ready(function() {
 var today = new Date();
 $('.datepicker')		
        .datepicker({
            format: 'dd/mm/yyyy',
            language: 'th-th',
			thaiyear: true,
			leftArrow: '<i class="fas fa-angle-double-left"></i>',
            rightArrow: '<i class="fas fa-angle-double-right"></i>',
        })//.datepicker("setDate", "0"); 
		//.datepicker("setDate", today.toLocaleDateString());  
		
	$('.datepicker-icon').datepicker({
            format: 'dd/mm/yyyy',
            language: 'th-th',
			thaiyear: true,
			leftArrow: '<i class="fas fa-angle-double-left"></i>',
            rightArrow: '<i class="fas fa-angle-double-right"></i>',
        })
		
	<?php if(!$_POST["start_date"]){?>
		$('#start_date').datepicker({
            format: 'dd/mm/yyyy',
            language: 'th-th',
			thaiyear: true,
			leftArrow: '<i class="fas fa-angle-double-left"></i>',
            rightArrow: '<i class="fas fa-angle-double-right"></i>',
        }).datepicker("setDate", "0"); 
	<?php } else { ?>
		$('#start_date').datepicker({
            format: 'dd/mm/yyyy',
            language: 'th-th',
			thaiyear: true,
			leftArrow: '<i class="fas fa-angle-double-left"></i>',
            rightArrow: '<i class="fas fa-angle-double-right"></i>',
        }).datepicker("setDate", "<?= $date1[0]."/".$date1[1]."/".($date1[2]-543); ?>"); 

	<?php } ?>
		
		
	<?php if(!$_POST["end_date"]){?>
		$('#end_date').datepicker({
            format: 'dd/mm/yyyy',
            language: 'th-th',
			thaiyear: true,
			leftArrow: '<i class="fas fa-angle-double-left"></i>',
            rightArrow: '<i class="fas fa-angle-double-right"></i>',
        }).datepicker("setDate", "0"); 
	<?php } else { ?>
		$('#end_date').datepicker({
            format: 'dd/mm/yyyy',
            language: 'th-th',
			thaiyear: true,
			leftArrow: '<i class="fas fa-angle-double-left"></i>',
            rightArrow: '<i class="fas fa-angle-double-right"></i>',
        }).datepicker("setDate", "<?= $date2[0]."/".$date2[1]."/".($date2[2]-543); ?>"); 

	<?php } ?>


});


</script>