<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
//include("../language/lang_th/language.php");
		$sql = "select lang_config_suffix,lang_config_status from lang_config where lang_config_id ='".$id."' ";
		$query = $db->query($sql);
		$rec = $db->db_fetch_array($query);
	if($id=='1'){
	if($rec[lang_config_status]=='T'){ $path_link = 'lang_th';}else{$path_link = 'lang_en';}
		$Current_Dir2 ="../language/".$path_link ."/language.php";
		$Current_Dir1 ="../ewt/".$EWT_FOLDER_USER."/language/language.php";
	}else{
		$Current_Dir1 ="../ewt/".$EWT_FOLDER_USER."/language/language_".$rec[lang_config_suffix].".php";
	}
if (!$fp = fopen($Current_Dir1, 'r')) {
         //print "Cannot open file ($filename)";
		 ?>
		 <script language="JavaScript">
		 alert("Cannot open file(<?php echo $Current_Dir1;?>)");
		 document.location.href='multiset.php?id=<?php echo $_POST[id];?>';
		</script>
		 <?php
         exit;
   		 }
		 if (!$fr = fread ($fp, filesize ( $Current_Dir1 ))) {
        //print "Cannot write to file ($filename)";
		 ?>
		 <script language="JavaScript">
		 alert("Cannot read to file(<?php echo $Current_Dir1;?>)");
		  document.location.href='multiset.php?id=<?php echo $_POST[id];?>';
		</script>
		 <?php
        exit;
  	  }
	$oldtxt = ereg_replace("//+[A-Za-z0-9]+#","",$fr); 
	$txt = explode("$",$oldtxt);
	 
//print($oldtxt);
	if($_POST[flag]=='from_edit'){
	$text .= "<?php   \n";
		for($i=1;$i<count($txt);$i++){
		$s = explode("=",$txt[$i]);
		$paramiters= trim($s[0]);
			if($paramiters != ""){
				if($_POST[$paramiters."list"] != ''){
				$hidden = "//".$_POST[$paramiters."list"];
				}else{
				$hidden =  '';
				}
				$text .= "$".$paramiters."=\"".addslashes($_POST[$paramiters])."\";".$hidden.""."\n";
			}
		}
	$text .= "    ?>";
	if (!$fp2 = fopen($Current_Dir1, 'w')) {
         //print "Cannot open file ($filename)";
		 ?>
		 <script language="JavaScript">
		 alert("Cannot open file(<?php echo $Current_Dir1;?>)");
		  document.location.href='multiset.php?id=<?php echo $_POST[id];?>';
		</script>
		 <?php
         exit;
   		 }
		 if (!fwrite($fp2, $text)) {
        //print "Cannot write to file ($filename)";
		 ?>
		 <script language="JavaScript">
		 alert("Cannot write to file(<?php echo $Current_Dir1;?>)");
		 document.location.href='multiset.php?id=<?php echo $_POST[id];?>';
		</script>
		 <?php
        exit;
  	  }
		fclose($fp2);
		if($id=='00r1'){//ต้องเป็น id=1 จะมาบันทึกที่ewtadminด้วย แต่ตอนนี้ไม่ให้ใช้งานเลยเป็น 00r1
				if (!$fp3 = fopen($Current_Dir2, 'w')) {
				 //print "Cannot open file ($filename)";
				 ?>
				 <script language="JavaScript">
				 alert("Cannot open file(<?php echo $Current_Dir2;?>)");
				 document.location.href='multiset.php?id=<?php echo $_POST[id];?>';
				</script>
				 <?php
				 exit;
				 }
				 if (!fwrite($fp3, $text)) {
				//print "Cannot write to file ($filename)";
				 ?>
				 <script language="JavaScript">
				 alert("Cannot write to file(<?php echo $Current_Dir2;?>)");
				</script>
				 <?php
				exit;
			  }
		fclose($fp3);
		}
	}
	include($Current_Dir1);	
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php include("../FavoritesMgt/favorites_include.php");?>
<form name="form1" method="post" action="">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
    <tr>
      <td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle" /><span class="ewtfunction">แก้ไขภาษา </span></td>
    </tr>
</table>
  <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode ('ตั้งค่าภาษา -แก้ไขภาษา ['.$rec[lang_config_suffix].']');?>&module=language&url=<?php echo urlencode ("multiset.php?id=".$_GET["id"]);?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="language_setup_web.php"><img src="../theme/main_theme/g_back.gif" width="16" height="16" align="absmiddle" border="0">&nbsp;กลับ&nbsp;</a>
      <hr>
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
    <?php echo $comment[1];?>
    <input type="hidden" name="<?php echo $paramiter;?>list" value="<?php echo $comment[1];?>"></td>
  </tr>
 
  <?php }} ?>
   <tr>
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF"><input type="submit" name="Submit" value="บันทึก">
      <input type="hidden" name="id" value="<?php echo $id;?>">
      <input type="hidden" name="flag" value="from_edit">
      <input type="hidden" name="lang" value="<?php echo $rec[lang_config_suffix];?>"></td>
  </tr>
</table>

</form>
<?php fclose($fp); ?>
</body>
</html>
