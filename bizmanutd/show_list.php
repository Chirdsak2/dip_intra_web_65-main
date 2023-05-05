<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_NAME);
function chkg($oid,$etype,$Flag){
global $db;
if($Flag == "O"){
$sqll = "SELECT COUNT(gen_user_id) FROM gen_user WHERE org_id = '$oid' AND emp_type_id = '$etype' AND gen_user != '' ";
}else{
$sqll = "SELECT COUNT(gen_user_id) FROM gen_user WHERE org_id = '$oid' AND emp_type_id = '$etype' AND gen_user = '' ";
}
$sql1 = $db->query($sqll);
$C = $db->db_fetch_row($sql1);
return $C[0];
}
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 16px;
}
.style2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
-->
</style>
</head>

<body>
<table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#000000">
      <tr>
        <td width="30%" rowspan="2" align="center">หน่วยงาน</td>
        <td colspan="3" align="center">ข้าราชการ</td>
        <td colspan="3" align="center">พนักงานราชการ</td>
        <td colspan="3" align="center">ลูกจ้างประจำ</td>
        <td colspan="3" align="center">รวม</td>
      </tr>
      <tr>
        <td width="5%" align="center">ข้อมูลครบ</td>
        <td width="5%" align="center">ขาดข้อมูล</td>
        <td width="5%" align="center">รวม</td>
        <td width="5%" align="center">ข้อมูลครบ</td>
        <td width="5%" align="center">ขาดข้อมูล</td>
        <td width="5%" align="center">รวม</td>
        <td width="5%" align="center">ข้อมูลครบ</td>
        <td width="5%" align="center">ขาดข้อมูล</td>
        <td width="5%" align="center">รวม</td>
        <td width="5%" align="center">ข้อมูลครบ</td>
        <td width="5%" align="center">ขาดข้อมูล</td>
        <td width="5%" align="center">รวม</td>
      </tr>
	  <?php
	  $t = 0;
	  $A1 = 0;
	  $A2 = 0;
	  $B1 = 0;
	  $B2 = 0;
	  $C1 = 0;
	  $C2 = 0;
	  $AOT = 0;
	  $ANT = 0;
	  $BOT = 0;
	  $BNT = 0;
	  $COT = 0;
	  $CNT = 0;
	  $sql = $db->query("SELECT *  FROM org_name WHERE org_id != '1' ORDER BY parent_org_id");
	  while($R = $db->db_fetch_array($sql)){
	  $len = strlen($R[parent_org_id]);
	  if($len == "9" AND $t != 0){
	  ?>
	  <tr>
        <td>รวม</td>
        <td align="right"><?php echo $AOT; $A1 += $AOT; ?></td>
        <td align="right"><?php echo $ANT; $A2 += $ANT; ?></td>
        <td align="right"><?php echo ($AOT+$ANT); ?></td>
        <td align="right"><?php echo $BOT; $B1 += $BOT; ?></td>
        <td align="right"><?php echo $BNT; $B2 += $BNT; ?></td>
        <td align="right"><?php echo ($BOT+$BNT); ?></td>
        <td align="right"><?php echo $COT; $C1 += $COT; ?></td>
        <td align="right"><?php echo $CNT; $C2 += $CNT; ?></td>
        <td align="right"><?php echo ($COT+$CNT); ?></td>
        <td align="right"><?php echo ($AOT+$BOT+$COT); ?></td>
        <td align="right"><?php echo ($ANT+$BNT+$CNT); ?></td>
        <td align="right"><?php echo ($AOT+$BOT+$COT+$ANT+$BTN+$CNT); ?></td>
      </tr>
	  <?php
	  $AOT = 0;
	  $ANT = 0;
	  $BOT = 0;
	  $BNT = 0;
	  $COT = 0;
	  $CNT = 0;
	  }
	  ?>
      <tr>
        <td><?php if($len == "14"){ echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; } ?><?php echo $R[name_org]; ?></td>
        <td align="right"><?php $AO = chkg($R[org_id],"1","O"); echo $AO; $AOT += $AO; ?></td>
        <td align="right"><?php $AN = chkg($R[org_id],"1","N"); echo $AN; $ANT += $AN; ?></td>
        <td align="right"><?php echo ($AO+$AN); ?></td>
        <td align="right"><?php $BO = chkg($R[org_id],"2","O"); echo $BO; $BOT += $BO; ?></td>
        <td align="right"><?php $BN = chkg($R[org_id],"2","N"); echo $BN; $BNT += $BN; ?></td>
        <td align="right"><?php echo ($BO+$BN); ?></td>
        <td align="right"><?php $CO = chkg($R[org_id],"3","O"); echo $CO; $COT += $CO; ?></td>
        <td align="right"><?php $CN = chkg($R[org_id],"3","N"); echo $CN; $CNT += $CN; ?></td>
        <td align="right"><?php echo ($CO+$CN); ?></td>
        <td align="right"><?php echo ($AO+$BO+$CO); ?></td>
        <td align="right"><?php echo ($AN+$BN+$CN); ?></td>
        <td align="right"><?php echo ($AO+$BO+$CO+$AN+$BN+$CN); ?></td>
      </tr>
	  <?php $t++; } ?>
	  <tr>
        <td>รวม</td>
        <td align="right"><?php echo $AOT; $A1 += $AOT; ?></td>
        <td align="right"><?php echo $ANT; $A2 += $ANT; ?></td>
        <td align="right"><?php echo ($AOT+$ANT); ?></td>
        <td align="right"><?php echo $BOT; $B1 += $BOT; ?></td>
        <td align="right"><?php echo $BNT; $B2 += $BNT; ?></td>
        <td align="right"><?php echo ($BOT+$BNT); ?></td>
        <td align="right"><?php echo $COT; $C1 += $COT; ?></td>
        <td align="right"><?php echo $CNT; $C2 += $CNT; ?></td>
        <td align="right"><?php echo ($COT+$CNT); ?></td>
        <td align="right"><?php echo ($AOT+$BOT+$COT); ?></td>
        <td align="right"><?php echo ($ANT+$BNT+$CNT); ?></td>
        <td align="right"><?php echo ($AOT+$BOT+$COT+$ANT+$BTN+$CNT); ?></td>
      </tr>
	  <tr>
        <td>รวมทั้งสิ้น</td>
        <td align="right"><?php echo $A1;  ?></td>
        <td align="right"><?php echo $A2;  ?></td>
        <td align="right"><?php echo ($A1+$A2); ?></td>
        <td align="right"><?php echo $B1; ?></td>
        <td align="right"><?php echo $B2; ?></td>
        <td align="right"><?php echo ($B1+$B2); ?></td>
        <td align="right"><?php echo $C1; ?></td>
        <td align="right"><?php echo $C2; ?></td>
        <td align="right"><?php echo ($C1+$C2); ?></td>
        <td align="right"><?php echo ($A1+$B1+$C1); ?></td>
        <td align="right"><?php echo ($A2+$B2+$C2); ?></td>
        <td align="right"><?php echo ($A1+$B1+$C1+$A2+$B2+$C2); ?></td>
      </tr>
    </table>
</body>
</html>
<?php
$db->db_close();
?>
