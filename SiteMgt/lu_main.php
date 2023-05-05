<?php
session_start();
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr valign="top"> 
    <td height="1" colspan="3"> &nbsp;
    </td>
  </tr>
  <tr valign="top"> 
    <td width="1">&nbsp;</td>
    <td> 
      <?php
	$sql = $db->query("SELECT * FROM user_info WHERE EWT_Status = 'Y' ");
	?>
      <table width="100%" border="0" cellspacing="1" cellpadding="10">
        <form name="form1" method="get" action="lu_main.php"><tr>
          <td>ค้นหาเจ้าหน้าที่  
              <input name="fname" type="text" id="fname" value="<?php echo $_GET["fname"]; ?>">
              <input type="submit" name="Submit" value="Submit">
              <input name="Flag" type="hidden" id="Flag" value="search"> </td>
        </tr></form>
      </table> 
	  <?php
	  if($_GET["Flag"] == "search"){
	  	$run = "SELECT * FROM gen_user INNER JOIN org_name ON org_name.org_id = gen_user.org_id "; 
		if($_GET["fname"] != ""){
			$run .= " WHERE gen_user.name_thai LIKE '%".$_GET["fname"]."%' OR gen_user.surname_thai LIKE '%".$_GET["fname"]."%' ";
		}
	$run .= " ORDER BY gen_user.gen_user_id";
		$sql = $db->query($run);
		$rows = $db->db_num_rows($sql);
	  ?>
      <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
        <tr align="center" bgcolor="E0DFE3"> 
          <td width="40%" class="head_table">ชื่อ - สกุล</td>
          <td width="40%" class="head_table">หน่วยงาน</td>
          <td width="10%" class="head_table">จำนวนลูกน้อง</td>
          <td width="10%" class="head_table">Setting</td>
        </tr>
        <?php
  if($rows > 0){
  $i = 0;
  while($U = $db->db_fetch_array($sql)){
  $sqlchk = $db->query("SELECT COUNT(under_id) FROM leader_list WHERE leader_id = '".$U["gen_user_id"]."' ");
  $C = $db->db_fetch_row($sqlchk);
  ?>
        <tr bgcolor="#FFFFFF"> 
          <td> <img src="../images/user_logo.gif" width="20" height="20" border="0" align="absmiddle"> 
            <?php echo $U["name_thai"]; ?> <?php echo $U["surname_thai"]; ?> </td>
          <td><?php echo $U["name_org"]; ?></td>
          <td align="center"><?php echo number_format($C[0],0); ?></td>
          <td align="center"><a href="#set" onClick="window.open('lu_set.php?G=<?php echo $U["gen_user_id"]; ?>','setting','width=750,height=550,scrollbars=1,resizable=1');">Setting</a></td>
        </tr>
        <?php $i++; }}else{ ?>
        <tr align="center" bgcolor="#FFFFFF"> 
          <td height="40" colspan="4"><font color="#FF0000">ไม่มีรายชื่อสมาชิก</font></td>
        </tr>
        <?php } ?>
      </table>
	  <?php } ?></td>
    <td width="1">&nbsp;</td>
  </tr>
  <tr valign="top"> 
    <td height="1" colspan="3"> &nbsp;
    </td>
  </tr>
</table>
</body>
</html>
<?php
$db->db_close();
?>
