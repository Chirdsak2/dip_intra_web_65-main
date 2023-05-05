<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="javascript1.1">
	function Preview(c){
				win2 = window.open('<?php echo $EWT_PATH; ?>ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/site_preview.php?filename='+c+'','ContentPreview','top=100,left=80,width=640,height=480,resizable=1,status=0,scrollbars=1');
				win2.focus();
	}
</script>
</head>
<body leftmargin="0" topmargin="0">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">การจัดการเว็บเพจตามมาตรฐาน W3C</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><hr>
    </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td align="left">&nbsp;<img src="../theme/main_theme/g_view.gif" width="16" height="16" align="absmiddle"> 
      ค้นหา 
        <input type="text" name="textfield">
    <input type="submit" name="Submit" value="Search"></td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
  <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
    <td width="5%" height="30" align="center">&nbsp;</td>
    <td width="10%" height="30" align="center">&nbsp;</td>
    <td width="10%" height="30" align="center">&nbsp;</td>
    <td width="10%" align="center">&nbsp;</td>
    <td >ชื่อเว็บเพจ</td>
    <td width="10%" >ปรับปรุงล่าสุด</td>
  </tr>
  <?php
  $offset = '0';
  $limit = '8';
  $sqlMain= " SELECT  filename FROM  temp_index  $filter  ORDER BY filename LIMIT $offset, $limit ";
  $query = $db->query($sqlMain);
  $rows = $db->db_num_rows($query);
  while($R = $db->db_fetch_array($query)){
  $FileName = $R[filename];
  //webpage_info check data for w3c
  $db->query("USE ".$EWT_DB_W3C);
  $sql_check = " SELECT  * FROM  webpage_info  WHERE filename = '$FileName' AND db_name = '".$EWT_DB_NAME."'   ";
  $query_check = $db->query($sql_check);
  $rows_check = $db->db_num_rows($query_check);
  $RC = $db->db_fetch_array($query_check);
  $w3c_ststus = $RC[w3c_status];
  $db->query("USE ".$EWT_DB_NAME);
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td><nobr><a href="#preview" onClick="Preview('<?php echo $FileName;?>')"><img src="../theme/main_theme/g_view.gif" alt="ดูหน้าเพจ" width="16" height="16" border="0"> </a>
      </nobr></td>
    <td><nobr><a href="#W" onClick="
	  <?php  if($w3c_ststus){
				   			if($w3c_ststus=='w3c') {
									$warn = "หน้าเว็บ $FileName นี้ผ่านมาตรฐาน W3C แล้ว\\nท่านต้องการ load หน้าเว็บมาแปลงอีกหรือไม่?";
							} else {
									$warn = "หน้าเว็บ $FileName นี้อยู่ในระหว่างการแก้ไขให้ผ่าน W3C\\nท่านต้องการ เริ่มแปลงหน้าเว็บใหม่อีกหรือไม่?";							
							}
							?>
							if(confirm('<?php echo $warn;?>')) { 
			<?php  } ?>
									window.open('w3c_loadcontent.php?filename=<?php echo $FileName;?>');
			<?php if($w3c_ststus){ ?>
							}
			<?php } ?>"	><img src="../theme/main_theme/g_download_16.png" alt="โหลด Connent" width="16" height="16"  border="0"></a>
	  <?php if($rows_check>0){?><a href="w3c_validator.php?filename=<?php echo $FileName;?>" target="_blank"><img src="../theme/main_theme/g_add_document.gif" alt="แปลงเว็บเพจเบื้องต้น" width="16" height="16" border="0"> </a><?php } ?></nobr></td>
    <td><nobr><img src="../theme/main_theme/g_view.gif" alt="ดูหน้าเพจที่แปลงเว็บเพจเบื้องต้นแล้ว" width="16" height="16" border="0"><img src="../theme/main_theme/g_mainpage.gif" alt="แก้ไขโดย Editor" width="16" height="16"><img src="../theme/main_theme/g_approve.gif" alt="ตรวจสอบด้วย Validator" width="16" height="16"></nobr></td>
    <td><nobr><img src="../theme/main_theme/g_applyall.gif" alt="ผ่าน W3C แล้ว" width="16" height="16"></nobr><img src="../theme/main_theme/g_saveas.gif" alt="ยืนยันการใช้งาน" width="16" height="16"></td>
    <td><?php echo $FileName;?></td>
    <td>&nbsp;</td>
  </tr>
  <?php } 
  if($rows == 0){
  ?>
  <tr align="right" bgcolor="#FFFFFF"> 
    <td colspan="6" align="center">--ไม่พบหน้าเพจ--</td>
  </tr>
  <?php } ?>
</table>
<table width="94%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td>Page : &lt;&lt; Pre&nbsp;&nbsp;1&nbsp;&nbsp;<strong>[2]</strong>&nbsp;&nbsp;3&nbsp;&nbsp;4&nbsp;&nbsp;5&nbsp;&nbsp;6&nbsp;&nbsp;Next &gt;&gt;</td>
  </tr>
</table>
</body>
</html>
<?php
$db->db_close(); ?>