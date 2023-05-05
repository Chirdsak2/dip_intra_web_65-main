<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

if($_POST["Flag"] == "SET"){
$bcode = base64_decode($_POST["B"]);
$bid_a = explode("z",$bcode);
$BID = $bid_a[1];
//chk data
if($_POST["start_date"] != ''){
$st = explode("/",$_POST["start_date"]);
$stt = ($st[2] -543)."-".$st[1]."-".$st[0];
}
if($_POST["end_date"] != ''){
$en = explode("/",$_POST["end_date"]);
$ett = ($en[2] -543)."-".$en[1]."-".$en[0];
}
$db->query("UPDATE block SET block_date_start = '".$stt."',block_date_end = '".$ett ."' WHERE BID = '".$BID."' ");

$db->write_log("update","main","แก้ไข block ");
?>
<script language="JavaScript">
//window.location.href = "banner_tool.php?banner_gid=<?php//php echo $_POST["selected"]; ?>&B=<?php//php echo $_POST["B"]; ?>";
top.self.close();
</script>
<?php
exit;
}else{
$bcode = base64_decode($_GET["B"]);
$bid_a = explode("z",$bcode);
$BID = $bid_a[1];

$sql_file = $db->query("SELECT block_name,block_link,block_date_start,block_date_end FROM block WHERE BID = '".$BID."'");
if($db->db_num_rows($sql_file) == 1){
$R = $db->db_fetch_array($sql_file);

$start_date = $R[block_date_start];
$end_date = $R[block_date_end];
if($start_date  != ''){
$st = explode("-",$start_date);
$start_date = $st[2]."/".$st[1]."/".($st[0] +543);
}
if($end_date  != ''){
$en = explode("-",$end_date);
$end_date = $en[2] ."/".$en[1]."/".($en[0]+543);
}
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<link href="../css/style_calendar.css" rel="stylesheet" type="text/css">
<script language="JavaScript"  type="text/javascript" src="../js/calendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/loadcalendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/calendar-th.js"></script>
<script language="JavaScript">
function selectG(c){
document.form1.selected.value = c;
form1.submit(); 
}
</script>
</head>
<body leftmargin="0" topmargin="0">
<form name="form1" method="post" action=""><table width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
 <tr> 
      <td height="20" align="left" bgcolor="F3F3EE" colspan="2"> <img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> 
        Block name : <?php echo $R["block_name"]; ?> | <a href="content_coding.php?B=<?php echo $_GET["B"];?>">แก้ไข Code</a></td>
    </tr>
	<tr> 
      <td height="1" bgcolor="AAAAAA" colspan="2"></td>
    </tr>
    <tr> 
      <td height="1" bgcolor="716F64" colspan="2"></td>
    </tr>
  <tr valign="top">
    <td > <br><br><table width="50%" border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
    <tr>
      <td colspan="2" class="ewttablehead">กำหนดเวลาการแสดงผล</td>
    </tr>
    <tr>
      <td width="18%" align="right" bgcolor="#FFFFFF">วันเริ่มต้น</td>
      <td width="82%" bgcolor="#FFFFFF"><input name="start_date" type="text" size="15" value="<?php echo $start_date;?>">
        <a href="#date" onClick="return showCalendar('start_date', 'dd-mm-y');" ><img src="../images/calendar.gif" width=20 height=20 border=0 align="absmiddle" ></a> 
      &nbsp;</td>
    </tr>
    <tr>
      <td align="right" bgcolor="#FFFFFF">วันสิ้นสุด</td>
      <td bgcolor="#FFFFFF"><input name="end_date" type="text" size="15"  value="<?php echo $end_date;?>">
      <a href="#date" onClick="return showCalendar('end_date', 'dd-mm-y');" ><img src="../images/calendar.gif" width=20 height=20 border=0 align="absmiddle" ></a> &nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#FFFFFF"><input type="submit" name="Submit" value="บันทึก">
        <input type="hidden" name="Flag" value="SET"><input type="hidden" name="B" value="<?php echo $_GET["B"];?>"></td>
    </tr>
  </table></td>
  </tr>
</table>


</form>
</body>
</html>
<?php }} ?>
<?php
$db->db_close(); ?>
