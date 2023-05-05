<?php
session_start();
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");

$sql_event = "select event_title from cal_event where event_id ='".$_GET[event_id]."'";
$query = $db->query($sql_event);
$R = $db->db_fetch_array($query);

?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/normal.css" rel="stylesheet" type="text/css">
<script src="js/AjaxRequest.js"></script>
<script src="js/excute.js"></script>
<script language="javascript">
		function order_field(deasc,orderby){
		    document.frm1.deasc.value=deasc;
		    document.frm1.orderby.value=orderby;
            document.frm1.submit();
		}
</script>
<style type="text/css">
<!--
.style1 {
	color: #FF0000;
	font-size: 12px;
}
.style3 {
	font-size: 14;
	font-weight: bold;
}
-->
</style>
</head>
<body leftmargin="0" topmargin="0">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td><span class="style3"><img src="mainpic/icon_news.gif" width="21" height="21" align="absmiddle">รายชื่อผู้สมัคร::<?php echo $R[event_title];?></span></td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="main_calendar.php"><img src="mainpic/arrow_left_blue.gif" alt="<?php echo $text_general_back;?>" width="16" height="16" border="0" align="absmiddle"> 
		กลับ </a>
        <hr>
    </td>
  </tr>
</table>
<form name="frm1" action="" method="post">
<table width="94%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#999999" class="ewttablehead">
  <tr >
    <td width="2" align="center" bgcolor="#CCCCCC"><strong>
      <!--<span class="style1"><?php//php echo $pict[1];?><a href="#" onClick="order_field('<?php//php echo $deasc?>','event_id')"><b>ลำดับ</b></a></span>-->
      ลำดับ</strong></td>
    <td bgcolor="#CCCCCC"><strong>ชื่อ - สกุล </strong></td>
    <td bgcolor="#CCCCCC"><strong>ตำแหน่ง</strong></td>
    <td bgcolor="#CCCCCC"><strong>เบอร์โทรศัพท์</strong></td>
    </tr>
	<?php
	$i=1;
	$sql ="select * from cal_registor where cal_id = '".$_GET[event_id]."'";
	$query = $db->query($sql);
	$num = $db->db_num_rows($query);
	while($rec = $db->db_fetch_array($query)){
	?>
  <tr bgcolor="#FFFFFF">
    <td align="left" valign="top"><?php echo $i;?></td>
    <td><?php echo $rec['cal_registor_name'];?>   <?php echo $rec['cal_registor_lastname'];?></td>
    <td><?php echo $rec['cal_registor_position'];?></td>
    <td valign="top"><?php echo $rec['cal_registor_phone'];?></td>
    </tr>
<?php  $i++; } ?>
<?php if($num == 0){?>
<tr bgcolor="#FFFFFF">
    <td colspan="4" align="center" valign="top"><span class="style1">---ไม่พบรายชื่อผู้สมัคร---</span></td>
    </tr>
<?php } ?>
</table>
</form>
</body>
</html>
<?php
$db->db_close(); 
?>
