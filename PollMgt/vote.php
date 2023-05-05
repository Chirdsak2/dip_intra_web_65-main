<?php
include("admin.php");
$color = array("","#CC9933","#CCCC00","#66CCFF","#00CC66","#FF99CC","#FF9933");
function datetime($str){
  $y=substr($str,0,4);
  $m=substr($str,4,2);
  $d=substr($str,6,2);
  $h=substr($str,8,2);
  $i=substr($str,10,2);
  $s=substr($str,12,2);
  
  $str="$d/$m/$y [$h:$i:$s]";
  if(trim($str)=="// [::]"){ return '-'; }else{ return  $str;}
}
?>
<html>
<head>
<title>Vote</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script language="JavaScript"  type="text/javascript" src="../StatMgt/lib_carendar/calendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../StatMgt/lib_carendar/loadcalendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../StatMgt/lib_carendar/calendar-th.js"></script>
<link href="../StatMgt/lib_carendar/style_calendar.css" rel="stylesheet" type="text/css">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<?php
$PollSel = $db->query("SELECT * FROM poll_cat WHERE  c_id = '{$_GET[cad_id]}' ");
$pollR = $db->db_fetch_array($PollSel);
$db->write_log("view","poll","ดูรายงานสถิติการสำรวจความคิดเห็น(poll)  ".$pollR[c_name]);
 ?>
<body leftmargin="0" topmargin="0">
<table width="100%" align="center" class="table table-bordered">
 <form name="form1" method="post" action=""> <tr>
      <td><img src="../images/column-chart.gif" width="24" height="24" border="0" align="left"> 
        <strong><font size="4" face="Tahoma"><?php echo $text_genpoll_stat;?><br> 
        <font size="2"><?php echo $text_general_daystart;?>
        <input class="form-control" style="width:20%;" type="text" name="start_date"  id="start_date" size="15" value="<?php echo  $start_date; ?>">
      <img src="../images/calendar.gif" alt="..<?php echo $text_general_catendar_open;?>." width="20" height="20" border="0" align="absmiddle" onClick="return showCalendar('start_date', 'dd-mm-y');" onMouseOver="this.style.cursor='hand';"> 
      <?php echo $text_general_dayend;?></font> 
      <input class="form-control" style="width:20%;" type="text" name="end_date"  id="end_date" size="15" value="<?php echo  $end_date;  ?>">
      <img src="../images/calendar.gif" alt="..<?php echo $text_general_catendar_open;?>." width="20" height="20" border="0" align="absmiddle" onClick="return showCalendar('end_date', 'dd-mm-y');" onMouseOver="this.style.cursor='hand';"> 
      </font></strong>
      
        <input type="submit" name="Submit" value="<?php echo $text_general_search;?>" class="btn btn-success btn-ml" />
        <strong><font size="4" face="Tahoma">
        <input name="Flag" type="hidden" id="Flag" value="View">
		<input name="vote" type="hidden" id="vote" value="<?php echo $_POST["vote"];?>">
		<input name="cad_id" type="hidden" id="cad_id" value="<?php echo $_POST["cad_id"];?>">
      </strong></td>
  </tr> </form>
  <tr height="4">
    <td height="4" bgcolor="#000066"></td>
  </tr>
</table>
<?php
		if($Flag == "View"){
			if($start_date == "" AND $end_date == ""){
			$con = "";
			}elseif($start_date != "" AND $end_date == ""){
			$st = explode("/",$start_date);
			$con = " AND (date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
			}elseif($start_date == "" AND $end_date != ""){
			$st = explode("/",$end_date);
			$con = " AND (date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
			}else{
			$st = explode("/",$start_date);
			$en = explode("/",$end_date);
			$con = " AND (date BETWEEN '".($st[2] -543)."-".$st[1]."-".$st[0]."' AND '".($en[2] - 543)."-".$en[1]."-".$en[0]."') ";
			}
		}
		$Sel = $db->query("SELECT count(*) as num FROM poll_log WHERE c_id = '$pollR[c_id]' $con"); 
		$total = 0;
		while($R = $db->db_fetch_row($Sel)){
			$total = $total + $R[0];
			}
		##create graph
		
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div align="center">
      <?php if($err == "1"){ ?>
        <font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $text_genpoll_youans;?></font><br>
      <?php } ?><font color="#000000" size="2" face="Tahoma"></font></div></td>
  </tr>
</table>
<br>
<table width="90%" align="center" class="table table-bordered">
  <tr>
    <td><?php echo $text_genpoll_Vote_Topic;?></td>
    <td><?php echo stripslashes($pollR[c_name]); ?></td>
  </tr>
  <tr>
    <td><?php echo $text_genpoll_Vote_Detail;?></td>
    <td><?php echo stripslashes($pollR[c_detail]); ?></td>
  </tr>
  <tr>
    <td><?php echo $text_genpoll_Vote_Create;?></td>
    <td><?php echo datetime($pollR[c_timestamp]) ;?></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td align="center"><br>
      <table width="70%" border="0" cellpadding="3" cellspacing="1" bgcolor="#000000">
                          <tr>
                            <td align="center" bgcolor="#FFFFFF">
                              <?php
	$graph_name = array();
	$graph_data = array();
	$sql_color = "select a_id,a_name from poll_ans where c_id = '".$_GET["cad_id"]."'";
	$query_color = $db->query($sql_color);
		while($rec_color = $db->db_fetch_array($query_color)){
				$sql_aws = "select count(*) as num from poll_log where c_id = '".$_GET["cad_id"]."' and a_id = '".$rec_color[a_id]."' $con ";
				$rec_aws = $db->db_fetch_array($db->query($sql_aws));
				array_push($graph_name,$rec_color[a_name]);
				array_push($graph_data,$rec_aws[num]);
		}
			 	$graph_height  = "300";
  				$graph_width  = "500";
				$graph_group = "Y";
		include("../ewt_graph_include.php");
						  ?>
                          </td>
                          </tr>
                        </table>  
	</td>	
  </tr>

</table>

  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><strong><?php echo $text_genpoll_allans;?> <?php echo $total; ?> <?php echo $text_genpoll_man;?></strong></td>
  </tr>
</table>
</body>
</html>
<?php $db->db_close(); ?>
