<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
if($_POST[flag]=='set_lang'){
	for($i=0;$i<$_POST[num];$i++){
		set_lang($_POST[c_id],$_POST[lang_name],$_POST[lang_field][$i],$_POST[lang_detail][$i],$module);
	}
	?>
      <script language="JavaScript">
		  alert('บันทึกข้อมูลเรียร้อย');
          location.href='../PollMgt/main.php';
     </script>
   <?php
   exit;
}

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="javascript1.2">
function chk(){
	if(document.form1.lang_name.value == ""){
		alert("Please insert languang!!");
		document.form1.lang_name.focus();
		return false;
	}
}
</script>
</head>
<body leftmargin="0" topmargin="0">
<form name="form1" method="post" action="poll_list.php" onSubmit="return chk();">
  <table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
    <tr>
      <td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle" /> <span class="ewtfunction">บริหารแบบสำรวจ</span> </td>
    </tr>
  </table>
  <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
    <tr>
      <td align="right"> <a href="../PollMgt/main.php"><img src="../theme/main_theme/g_back.gif" width="16" height="16" border="0" align="absmiddle" />กลับ</a> 
          <hr />
      </td>
    </tr>
  </table>
  <table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#000000">
  <tr>
    <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right"><a href="javascript:void(0);" onClick="document.getElementById('nav').style.display='none';"></a></td>
      </tr>
    </table>
    <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#999999" class="ewttableuse">
  <tr>
    <th height="23" colspan="4" bgcolor="#FFFFFF" class="ewttablehead" scope="col"><div align="left">&bull;&nbsp;กรุณาใส่ภาษาตามที่ท่านเลือก(<?php echo $_GET[lang];?>)</div></th>
  </tr>
  <?php
 $sql = $db->query("SELECT * FROM poll_cat where c_id  = '$id' ");
$R = mysql_fetch_array($sql);
$LastTopic=$R[c_name];
$LastDetail=$R[c_detail];
 
  ?>
  <tr>
    <td width="21%" height="11" valign="top" bgcolor="#FFFFFF">หัวข้อแบบสำรวจ : <strong style="color:#FF0000"></strong></td>
    <td width="32%" height="0" bgcolor="#FFFFFF"><input name="lang_detail[0]" type="text" size="50" value="<?php echo select_lang_detail($_GET[id],$_GET[langid],'c_name','poll');?>"><input type="hidden" name="lang_field[0]" value="c_name"></td>
    <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="45%" bgcolor="#FFFFFF"><?php echo $LastTopic;?></td>
  </tr>
  <tr>
    <td height="20" valign="top" bgcolor="#FFFFFF">รายละเอียด : </td>
    <td width="32%" height="20" bgcolor="#FFFFFF"><input name="lang_detail[1]" type="text" class="normal_font" id="lang_detail[1]" size="50" value="<?php echo select_lang_detail($_GET[id],$_GET[langid],'c_detail','poll');?>"><input type="hidden" name="lang_field[1]" value="c_detail"></td>
    <td width="2%" height="20" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="45%" height="20" bgcolor="#FFFFFF"><?php echo $LastDetail;?></td>
  </tr>
  <tr>
    <td height="12" colspan="4" bgcolor="#FFFFFF"><hr></td>
    </tr>
  <tr>
    <td height="11" valign="top" bgcolor="#FFFFFF">ตัวเลือก : </td>
    <td height="0" colspan="3" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="5" cellspacing="1">
      <?php 
	$sql2="SELECT * FROM poll_ans WHERE  c_id = '$id' ORDER BY a_id ";
	$query2 = $db->query($sql2);
	$num = mysql_num_rows($query2);
	//for($i=0;$i<$num;$i++){ 
	 $n=2;
	 $a = 0;
	while($das=mysql_fetch_array($query2)){ ?>
      <tr bgcolor="#FFFFFF">
        <td width="5%"   align="center"><?php echo $a+1; ?></td>
        <td width="45%" ><input name="lang_detail[<?php echo $n;?>]" type="text" class="normal_font"  size="50" value="<?php echo select_lang_detail($_GET[id],$_GET[langid],$das[a_id],'poll');?>">
		<input type="hidden" name="lang_field[<?php echo $n;?>]" value="<?php echo $das[a_id];?>">	</td>
        <td width="50%" >&nbsp;<?php echo $das[a_name]?></td>
      </tr>
      <?php 
    $n++; 
	$a++; 
  } ?>

    </table></td>
    </tr>
  <tr>
    <td height="12" colspan="4" valign="top" bgcolor="#FFFFFF"><hr></td>
    </tr>
   <tr>
    <td height="23" bgcolor="#FFFFFF">&nbsp;</td>
    <td height="23" colspan="3" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="submit" name="Submit" value="บันทึก">
      
      <input type="hidden" name="flag" value="set_lang">
      <input type="hidden" name="num" value="<?php if($num  > 0 ){  echo ($n); }else if($num  == 0){  echo '2';}?>">
      <input type="hidden" name="c_parent" value="<?php echo $sql[c_parent];?>">
      <input type="hidden" name="c_id" value="<?php echo $_GET[id]?>">
      <input type="hidden" name="lang_name" value="<?php echo $_GET[langid]?>">
      <input type="hidden" name="module" value="poll"></td></tr>
</table></td>
  </tr>
</table>

</form>
</body>
</html>