<?php
include("admin.php");
$color = array("","#CC9933","#CCCC00","#66CCFF","#00CC66","#FF99CC","#FF9933");

?>
<html>
<head>
<title>Vote</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script language="JavaScript"  type="text/javascript" src="../StatMgt/lib_carendar/calendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../StatMgt/lib_carendar/loadcalendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../StatMgt/lib_carendar/calendar-th.js"></script>
<link href="../StatMgt/lib_carendar/style_calendar.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../css/style.css" type="text/css"></head>

<body leftmargin="0" topmargin="0">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
 <form name="form1" method="post" action=""> <tr>
      <td><img src="../images/column-chart.gif" width="24" height="24" border="0" align="left"> 
        <strong><font size="4" face="Tahoma">สถิติการสำรวจความคิดเห็น<br> 
        <font size="2">จากวันที่ 
        <input type="text" name="start_date" size="15" value="<?php print  $start_date; ?>">
      <img src="../images/calendar.gif" alt="..เปิดปฎิทิน." width="20" height="20" border="0" align="absmiddle" onClick="return showCalendar('start_date', 'dd-mm-y');" onMouseOver="this.style.cursor='hand';"> 
      ถึง</font> 
      <input type="text" name="end_date" size="15" value="<?php print  $end_date;  ?>">
      <img src="../images/calendar.gif" alt="..เปิดปฎิทิน." width="20" height="20" border="0" align="absmiddle" onClick="return showCalendar('end_date', 'dd-mm-y');" onMouseOver="this.style.cursor='hand';"> 
      </font></strong>
      
        <input type="submit" name="Submit" value="แสดงข้อมูล">
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
		$db->write_log("view","poll","ดูรายงานสถิติการสำรวจความคิดเห็นทั้งหมด ");
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
	
		
		
		 $PollSel = $db->query("SELECT * FROM poll_cat ");
?>
        <table width="100%" border="0" cellspacing="0" cellpadding="1">
          <tr>
            <td align="right">&nbsp;</td>
          </tr>
          <tr>
            <td width="47%" align="center"><table width="95%" border="0" cellpadding="0" cellspacing="1" bgcolor="#000000">
                <tr>
                  <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
                      <tr align="center" bgcolor="#999999">
                        <td width="40%"><strong><font size="2" face="Tahoma">ความคิดเห็น</font></strong></td>
                        <td width="10%"><strong><font size="2" face="Tahoma">จำนวน</font></strong></td>
                        <td width="50%"><strong><font size="4" face="Tahoma">สถิต</font></strong></td>
                      </tr>
                      <?php
							while($R = $db->db_fetch_array( $PollSel)){
							$Sel = $db->query("SELECT count(*) as num FROM poll_log WHERE c_id = '$R[c_id]' $con"); 
							$total = 0;
							while($R1 = $db->db_fetch_row($Sel)){ $total = $total + $R1[0]; }
					?>
                      <tr  >
                        <td align="left" bgcolor="#EEEEEE" ><?php echo $R[c_name];?></td>
                        <td align="right"><font size="1" face="MS Sans Serif, Tahoma, sans-serif">(<?php echo number_format($total,0); ?>)</font></td>
                        <td>
						<!--graph pie -->
						<img src="graph_pie_poll.php?c_id=<?php echo $R[c_id];?>&&a_id=<?php echo $_POST["vote"];?>&&total=<?php echo $total;?>&&start_date=<?php echo $start_date;?>&&end_date=<?php echo $end_date;?>" border="0">
						<!--graph line -->
						<img src="graph_line_poll.php?c_id=<?php echo $R[c_id];?>&&a_id=<?php echo $_POST["vote"];?>&&total=<?php echo $total;?>&&start_date=<?php echo $start_date;?>&&end_date=<?php echo $end_date;?>" border="0">
						<!--graph bra -->
						<table width="70%" border="0" cellpadding="3" cellspacing="1" bgcolor="#000000">
                          <tr>
                            <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                              <?php
						$i=1;
						$sql_color = "select * from poll_ans where c_id = '".$R[c_id]."'";
						$query_color = $db->query($sql_color);
						while($rec_color = $db->db_fetch_array($query_color)){
						$sql_aws = "select count(*) as num from poll_log where c_id = '".$R[c_id]."' and a_id = '".$rec_color[a_id]."' $con ";
						$rec_aws = $db->db_fetch_array($db->query($sql_aws));
						
						$b = $rec_aws[num];
						?>
                              <tr>
                                <td width="18%" ><?php echo $rec_color[a_name];?>(<?php echo $b; ?>)</td>
                                <td width="82%"><table width="<?php echo $b; ?>%" height="18" border="0" cellpadding="0" cellspacing="1" bgcolor="#333333">
                                    <tr width="<?php echo $b; ?>%" height="12" >
                                      <td width="<?php echo $b; ?>%" height="12"  bgcolor="<?php echo $color[$i];?> "></td>
                                    </tr>
                                </table></td>
                              </tr>
                              <?php  $i++; } ?>
                            </table></td>
                          </tr>
                        </table>
						<br>
                          <br><table width="50%" border="0" cellpadding="2" cellspacing="1" bgcolor="#000000">
  <tr>
    <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="0" cellspacing="0" >
      <?php
	  $i = 1;
	$sql_color = "select * from poll_ans where c_id = '".$R[c_id]."'";
	$query_color = $db->query($sql_color);
	while($rec_color = $db->db_fetch_array($query_color)){
	$sql_aws = "select count(*) as num from poll_log where c_id = '".$R[c_id]."' and a_id = '".$rec_color[a_id]."' $con ";
	$rec_aws = $db->db_fetch_array($db->query($sql_aws));
	
	$b = $rec_aws[num];

	?>
      <tr>
        <td><img src="../images/box_color.gif" width="21" height="23" style="background-color: <?php echo $color[$i] ?>; padding: 0; height: 21px; width: 21px;border-width:0; border-style:solid;">&nbsp;&nbsp;<?php echo $rec_color[a_name];?>(<?php echo $b; ?>)</td>
      </tr>
      <?php $i++; } ?>
    </table></td>
  </tr>
</table></td>
                      </tr>
                      <?php } ?>
                  </table></td>
                </tr>
            </table><?php } ?></td>
          </tr>
        </table>
</body>
</html>
<?php $db->db_close(); ?>
