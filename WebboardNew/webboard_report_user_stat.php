<?php
include("../EWT_ADMIN/comtop.php");

//============
//  Stat
//============

$depth = 0;

function list_room($c_id,$depth,$con_a){
  
  global $db;
  global $depth;
  

  $sql_subcate = "SELECT * FROM w_cate 
                  WHERE c_parentid = '$c_id' AND c_use = 'Y'";
  
  $result_subcate = $db->query($sql_subcate);

  $order_subcate = 1;

  	while($subcate = $db->db_fetch_array($result_subcate)){
		?>

		<tr>
			<td colspan="3" style="FONT-WEIGHT: bold;background-color: #ffc153;color: #FF6600;padding-left: 15px;">
			<a style="color: #FF6600;" href="webboard_room.php?c_id=<?php echo $subcate[c_id]; ?>">
				<? if(trim($depth)!="0"){ 
					//echo "- ";
					} ?> <?php for($e=0;$e<($depth+1);$e++){?>><?php } ?> <?php echo $subcate[c_name]; ?>
				</a>
			</td>
		</tr>

		<?php 
			$sql_q = mysql_query("SELECT * from  w_question where c_id = '$subcate[c_id]'  AND s_id='1' ");
			$num_q = $db->db_num_rows($sql_q);
			while($rec_q = $db->db_fetch_array($sql_q)){
			?>
			<tr>
				<td width="2%" bgcolor="#ffe2af">&nbsp;</td>
				<td width="72%" bgcolor="#ffe2af"> <?php for($e=0;$e<($depth+1);$e++){?>><?php } ?> <?php echo $rec_q[t_name];?></td>
				<td align="center" bgcolor="#FFFFFF">
				<?php
					$sql_a = $db->query("SELECT count(*) as num 
					                     from w_answer 
										 where 1=1 and t_id = '".$rec_q[t_id]."' ".$con_a." ");
					$rec_a = $db->db_fetch_array($sql_a);
					echo $rec_a["num"];
				?>
				</td>
				
			</tr>
			<?php 
			}
			
			if($num_q == 0){
				?>
				<tr>
				<td bgcolor="#FFFFFF">&nbsp;</td>
				<td colspan="3" bgcolor="#FFFFFF"><span class="style1">---ไม่พบหัวข้อกระทู้----</span></td>
			</tr>
				<?php
			}
		?>

		<?php 

		
		$sql_subcate1 = "SELECT * FROM w_cate 
						WHERE c_parentid = '$subcate[c_id]' AND c_use = 'Y'";

		$result_subcate1 = $db->query($sql_subcate1);
		$subcate1_row    = mysql_num_rows($result_subcate1);

		
		if($subcate1_row>0){
		$depth++;
		list_room($subcate[c_id],$depth,$con_a);
		
		}
		else{
		
		}
    
	$order_subcate++;
	} 
	$depth--;
}

$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/";
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
            else*/if (floor($diff/86400))
                        {
                        $x = floor($diff / 86400);
						if($x  > 0){
                        echo " $x วัน";
                        $diff = $diff - ($x * 86400);
                        return DiffToText_new($diff);
						}
                        }
            elseif (floor($diff/3600))
                        {
                        $x = floor($diff / 3600);
                        echo " $x ชั่วโมง";
                        $diff = $diff - ($x * 3600);
                        return DiffToText_new($diff);
                        }

            elseif (floor($diff/60))
                        {
                        $x = floor($diff / 60);
                        echo " $x นาที ";
                        $diff = $diff - ($x * 60);
                        return DiffToText_new($diff);
                        }
            else if ($diff)
                        echo " $diff วินาที ";
            }
if(empty($start_date) && $Flag ==''){
$start_date = date("d/m/").(date("Y")+543);
}
if(empty($end_date) && $Flag ==''){
$end_date = date("d/m/").(date("Y")+543);
}

if($_POST["start_date"]){$date1 = explode("/",$_POST["start_date"]);}
if($_POST["end_date"]){$date2 = explode("/",$_POST["end_date"]);}
?>  

<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");
include("lib/webboard_function.php");

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
								<td colspan="2" bgcolor="#FFFFFF" style="padding:10px;" class="ewttablehead"><b>ค้นหา</b></td>
							</tr>
							<tr>
								<td width="25%" bgcolor="#FFFFFF" style="padding:10px;" align="center">วันที่ :<span style="color:red;">*</span> </td>
								<td width="30%" bgcolor="#FFFFFF" style="padding:10px;">

									<div class='input-group date datepicker' id='datetimepicker' >
										<input name="start_date" id="start_date" type="text"  class="form-control form-control-sm " value="<?php if($_POST[start_date]){echo $date1[0]."/".$date1[1]."/".($date1[2]-543);} else {echo $today[2]."/".$today[1]."/".$today[0];}?>" readonly="readonly" required/>
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
										<input name="end_date" id="end_date" type="text"  class="form-control form-control-sm " value="<?php if($_POST[end_date]){echo $date2[0]."/".$date2[1]."/".($date2[2]-543);}  else {echo $today[2]."/".$today[1]."/".$today[0];}?>" readonly="readonly" required/>
										<span class="input-group-addon">
											<a href="#date" onClick="return show_calendar('form1.date_n');" >
												<i class="far fa-calendar-alt"></i>
											</a>
										</span>
									</div>
								</td>
							</tr>
							<tr>
								<td colspan="4" align="center" bgcolor="#FFFFFF" style="padding:20px;">
									<input class="btn btn-info  btn-ml" type="submit" name="Submit" value="แสดงข้อมูล">
									<input name="Flag" type="hidden" id="Flag" value="View">
								</td>
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
		
		<div class="panel panel-default ">

		
			<div class="">
				<div class="panel-body">

					<?php
					if($Flag == "View"){
					if($start_date == "" AND $end_date == ""){
					$con = "";
					$con_a = "";
					$date_name = "";
					}elseif($start_date != "" AND $end_date == ""){
					$st = explode("/",$start_date);
					$con = " AND (t_date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
					$con_a = " AND (a_date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
					$date_name = "วันที่".$start_date;
					}elseif($start_date == "" AND $end_date != ""){
					$st = explode("/",$end_date);
					$con = " AND (t_date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
					$con_a = " AND (a_date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
					$date_name = "วันที่".$end_date;
					}else{
					$st = explode("/",$start_date);
					$en = explode("/",$end_date);
					$con = " AND (t_date BETWEEN '".($st[2] -543)."-".$st[1]."-".$st[0]."' AND '".($en[2] - 543)."-".$en[1]."-".$en[0]."') ";
					$con_a = " AND (a_date BETWEEN '".($st[2] -543)."-".$st[1]."-".$st[0]."' AND '".($en[2] - 543)."-".$en[1]."-".$en[0]."') ";
					$date_name = "วันที่".$start_date."ถึง วันที่".$end_date;
					}
					$db->write_log("view","webboard","ดูรายงานสถิติการเข้า webboard");
					$sql = mysql_query("select* from  w_question where 1=1  ".$con." ");
					$sql_ct = mysql_query("select * from  w_question where 1=1  ".$con." LIMIT 0,1");
					$A = mysql_fetch_row($sql_ct);

					?>
					<!-- <table width="100%" border="0" cellspacing="0" cellpadding="1">
					<tr> 
						<td align="right">&nbsp;</td>
					</tr>
					<tr> 
						<td width="47%" align="center"><table width="94%" border="0" cellpadding="2" cellspacing="1" bgcolor="#000000" class="ewttableuse">
						<tr>
							<td colspan="2" class="ewttablehead">รายการ</td>
							<td width="13%" align="center" class="ewttablehead">จำนวนผู้ตอบ</td>
						</tr>
						<?php 
						$query = $db->query("select * from w_cate where c_use = 'Y'");
						while($rec = $db->db_fetch_array($query)){
						?>
						<tr>
							<td colspan="4" bgcolor="#F2F2F2" class="MemberHead"><img src="../images/arrow_r.gif" width="7" height="7"><?php echo $rec[c_name]; ?></td>
							</tr>
						<?php 
						$sql_q = mysql_query("select* from  w_question where 1=1 and c_id = '".$rec[c_id]."'  ");
						$num_q = $db->db_num_rows($sql_q);
						while($rec_q = $db->db_fetch_array($sql_q)){
						
						$sql_a = $db->query("select count(*) as num from w_answer where 1=1 and t_id = '".$rec_q[t_id]."' ".$con_a." ");
						$rec_a = $db->db_fetch_array($sql_a);
						?>
						<tr>
							<td width="2%" bgcolor="#F2F2F2">&nbsp;</td>
							<td width="72%" bgcolor="#FFFFFF"><img src="../images/bar_min.gif" width="15" height="13"><?php echo $rec_q[t_name];?></td>
							<td align="center" bgcolor="#FFFFFF"><?php echo $rec_a[num];?></td>
						</tr>
						<?php 
							}
							if($num_q == 0){
							?>
							<tr>
							<td bgcolor="#FFFFFF">&nbsp;</td>
							<td colspan="3" bgcolor="#FFFFFF"><span class="style1">---ไม่พบหัวข้อกระทู้----</span></td>
						</tr>
							<?php
							}
						} ?>
						
						</table></td>
					</tr>
					</table> -->
					<?php } ?>


					<table width="100%" border="0" cellspacing="0" cellpadding="1">
						<?php
						
							if(trim($_GET[c_id])==""){
								$_GET[c_id]=0;
							}

							$sql_subcate1 = " SELECT * FROM article_group 
											WHERE c_parent = '$_GET[c_id]'";

							$result_subcate1 = $db->query($sql_subcate1);
							$subcate1_row    = mysql_num_rows($result_subcate1);

							if($subcate1_row>0){
						?>
							<tr  class="ewttablehead">
								<td align="center" colspan="2" >รายการ</td>
								<td align="center" >จำนวนผู้ตอบ</td>
							</tr>

						<?php
							}
							list_room($_GET[c_id], 1,$con_a); 
							//list_room(4);
						?>
					</table>

					<br>

					<div class="text-right">
						<table border="0" align="right">
							<tr>
								<td style="padding:3px;">
									<a href="webboard_report_user_stat_csv_export.php?start_date=<?=str_replace("/","-",$start_date);?>&end_date=<?=str_replace("/","-",$end_date);?>" target="_blank">
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
									<a href="webboard_report_user_stat_excel_export.php?start_date=<?=str_replace("/","-",$start_date);?>&end_date=<?=str_replace("/","-",$end_date);?>" target="_blank">
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