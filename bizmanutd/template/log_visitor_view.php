<?php
//session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/style_calendar.css" rel="stylesheet" type="text/css">
<script language="JavaScript"  type="text/javascript" src="js/calendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="js/loadcalendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="js/calendar-th.js"></script>
</head>

<body leftmargin="0" topmargin="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form name="form1" method="post" action="">
	<input name="hdd_search" type="hidden" value="search">
        <table width="50%" border="0" align="center" cellpadding="3" cellspacing="1">
          <tr> 
            <td width="15%" height="21">&nbsp;</td>
            <td width="85%">&nbsp;</td>
          </tr>
          <tr> 
            <td height="27">ค้นหาโดย: </td>
            <td height="27"><input type="text" name="date_start"> <img src="mainpic/b_calendar.gif" alt="..เปิดปฎิทิน." width="22" height="23" border="0" align="absmiddle" onClick="return showCalendar('date_start', 'dd-mm-y');" onMouseOver="this.style.cursor='hand';"> 
              <input type="submit" name="Submit" value="ค้นหา"></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
      </form>
      <br>
	  <?php
	  if($hdd_search == 'search'){
	  if(!empty($date_start)){
	  $date_s = explode('/',$date_start);
	  $date_s = ($date_s[2]-543)."-".$date_s[1]."-".$date_s[0];
	  $wh = "where log_date ='".$date_s."'";
	  }
	  ?>
      <table width="70%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666666">
        <tr align="center" bgcolor="#CCCCCC"> 
          <td width="20%" rowspan="2"><strong>IP</strong></td>
          <td width="20%" rowspan="2"><strong>ชื่อ</strong></td>
          <td colspan="2"><strong>ช่วงเวลาเข้า-ออก</strong></td>
        </tr>
        <tr align="center" bgcolor="#CCCCCC"> 
          <td width="30%"><strong>จาก</strong></td>
          <td width="30%"><strong>ถึง</strong></td>
        </tr>
		<?php
		$sql = "select  min(log_date_text) as min,max(log_date_text) as max,log_module_detail from log_visitor $wh group by log_module_detail";
		$query =$db->query($sql);
		while($rec = $db->db_fetch_array($query)){
		$sql_detail = "select log_ip,log_user from log_visitor where log_module_detail = '".$rec[log_module_detail]."' group by log_module_detail";
		$query_detail = $db->query($sql_detail);
		$rec_detail = $db->db_fetch_array($query_detail);
		?>
        <tr align="center" bgcolor="#FFFFFF"> 
          <td><?php  if(!empty($rec_detail[log_ip])){echo $rec_detail[log_ip];}else{echo "ไม่ทราบ IP";};?></td>
          <td><?php  if(!empty($rec_detail[log_user])){echo $rec_detail[log_user];}else{echo "ไม่ทราบชื่อ";};?></td>
          <td><?php echo $rec[min];?></td>
          <td><?php echo $rec[max];?></td>
        </tr>
		<?php } ?>
      </table><?php } ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

</body>
</html>
