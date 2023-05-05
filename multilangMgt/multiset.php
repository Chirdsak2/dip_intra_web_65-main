<?php
//include("../language/lang_th/language.php");
$Current_Dir1 ="../language/lang_th/language.php";
if (!$fp = fopen($Current_Dir1, 'r')) {
         //print "Cannot open file ($filename)";
		 ?>
		 <script language="JavaScript">
		 alert("Cannot open file(<?php echo $Current_Dir1;?>)");
		</script>
		 <?php
         exit;
   		 }
		 if (!$fr = fread ($fp, filesize ( $Current_Dir1 ))) {
        //print "Cannot write to file ($filename)";
		 ?>
		 <script language="JavaScript">
		 alert("Cannot read to file(<?php echo $Current_Dir1;?>)");
		</script>
		 <?php
        exit;
  	  }
	$oldtxt = ereg_replace("//+[A-Za-z0-9]+#","",$fr); 
	$txt = explode("$",$oldtxt);
	 
//print($oldtxt);
	
	include($Current_Dir1);	
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
    <tr>
      <td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle" /><span class="ewtfunction">แก้ไขภาษา </span></td>
    </tr>
</table>
  <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
    <tr>
      <td align="right"> <a href="../CalendarMgt/calendar_category.php"><img src="../theme/main_theme/g_back.gif" width="16" height="16" border="0" align="absmiddle" />กลับ</a> 
          <hr />
      </td>
    </tr>
  </table>
<table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
  <tr>
    <td width="31%" class="ewttablehead">ชื่อตัวแปร</td>
    <td class="ewttablehead">ค่าที่แสดง</td>
  </tr>
<?php for($i=1;$i<count($txt);$i++){
$s = explode("=",$txt[$i]);
$paramiter = trim($s[0]);
if($paramiter != ""){
$comment = explode(";//",$s[1]);
?>
  <tr>
    <td bgcolor="#FFFFFF"><?php echo $paramiter;?></td>
    <td bgcolor="#FFFFFF"><input name="<?php echo $paramiter;?>" type="text" value="<?php echo stripslashes(htmlspecialchars($$paramiter,ENT_QUOTES));?>" size="50">
    <?php echo $comment[1];?></td>
  </tr>
  <?php }} ?>
</table>
<?php fclose($fp); ?>
</body>
</html>
