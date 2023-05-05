<?php
include("administrator.php");
include("inc.php");
include("lib/include.php");
$chk_config = $db->query("SELECT * FROM w_config WHERE c_config = '1'");
$CO = mysql_fetch_array($chk_config);	
 ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../js/function.js"></script>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>

<body leftmargin="0" topmargin="0" class="normal_font">
<div align="center">
<?php
$Execsql1 = $db->query("SELECT * FROM w_cate WHERE c_id = '$wcad'");
$QQ= mysql_fetch_array($Execsql1);
?>
  <table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
    <tr>
      <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction"><a href="index_cate.php">หน้าหลักกระทู้</a> <img src="../wb_pic/arrow_r.gif" width="7" height="7" align="absmiddle"> <a href="index_question.php?wcad=<?php echo $wcad; ?>"><?php echo $QQ[c_name]; ?></a> <img src="../wb_pic/arrow_r.gif" width="7" height="7" align="absmiddle"> ตั้งกระทู้ใหม่</span> </td>
    </tr>
  </table>
  <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
    <tr>
      <td align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="index_question.php?wcad=<?php echo $wcad;?>"><img src="../theme/main_theme/g_back.png" width="16" height="16" border="0" align="absmiddle">กลับ</a>
        <hr>
      </td>
    </tr>
  </table>
  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" valign="top">
	<DIV align="center"  style="HEIGHT: 100%;OVERFLOW-Y: auto;WIDTH: 100%">
	  <p>
	<form name="myForm" enctype="multipart/form-data" method="post" action="question_function.php" onSubmit="return CHK()" target="save_function_form">
	  <table width="94%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#7D7E99" class="ewttableuse" >
        <tr>
          <td   align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="ewttableuse">
              <tr class="ewttablehead">
                <td width="2%" height="25" valign="top">&nbsp;</td>
                <td width="94%" align="center" >ขอเชิญร่วมตั้งคำถามครับ</td>
                <td width="4%" align="right" valign="top">&nbsp;</td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><table border=0 cellpadding=0 cellspacing=1 width="100%">
              <tr>
                <td colspan="2" align=center bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="2" cellspacing="0">
                    <tr>
                      <td width="18%">หัวข้อกระทู้</td>
                      <td width="82%"><input name="aque" type=text class=violet id="aque" size=51>
                      </td>
                    </tr>
					
                    <tr>
                      <td width="18%">รายละเอียด</td>
                      <td width="82%"><textarea rows="5" cols="50" name="amsg" id="amsg" class=violet></textarea>
                      </td>
                    </tr>
					 <tr>
              <td width="20%">เอกสารแนบ</td>
              <td width="80%"><input type="file" name="file" >
                <span class="style1">(ขนาดไฟล์ต้องไม่เกิน <?php echo $CO[c_sizeupload];?> KB.)</span></td>
            </tr>
                    <tr>
                      <td width="18%">โดย</td>
                      <td width="82%"><input type=text name="aname" id="aname" size=51 maxlength=30 class=violet>
                      </td>
                    </tr>
                    <tr>
                      <td width="18%">E-mail</td>
                      <td width="82%"><input type=text name="aemail" id="aemail" size=24 maxlength=50 class=violet>
                      </td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align=center bgcolor="#FFFFFF"><a href="javascript:setURL()"><img src="../WebboardMgt/pic/link.gif" alt="แทรกลิงค์ URL" width="18" height="17" border=0></a> 
																		    <a href="javascript:setImage()"><img src="../WebboardMgt/pic/tree.gif" alt="แทรกรูป" width="18" height="17" border=0></a> 
																			<a href="javascript:setsmile('[---]')"><img src="../WebboardMgt/pic/indent.gif" alt="ย่อหน้า" width="18" height="17" border=0></a> 
																			<a href="javascript:setBold()"><img src="../WebboardMgt/pic/b.gif" alt="ตัวหนา" width="18" height="17" border=0></a> 
																			<a href="javascript:setItalic()"><img src="../WebboardMgt/pic/i.gif" alt="ตัวเอียง" width="18" height="17" border=0></a> 
																			<a href="javascript:setUnderline()"><img src="../WebboardMgt/pic/u.gif" alt="เส้นใต้" width="18" height="17" border=0></a> 
																			<a href="javascript:setColor('red','แดง')"><img src="../WebboardMgt/pic/redcolor.gif" alt="สีแดง" width="18" height="17" border=0></a> 
																			<a href="javascript:setColor('green','เขียว')"><img src="../WebboardMgt/pic/greencolor.gif" alt="สีเขียว" width="18" height="17" border=0></a> 
																			<a href="javascript:setColor('blue','น้ำเงิน')"><img src="../WebboardMgt/pic/bluecolor.gif" alt="สีน้ำเงิน" width="18" height="17" border=0></a> 
																			<a href="javascript:setColor('orange','ส้ม')"><img src="../WebboardMgt/pic/orangecolor.gif" alt="สีส้ม" width="18" height="17" border=0></a> 
																			<a href="javascript:setColor('pink','ชมพู')"><img src="../WebboardMgt/pic/pinkcolor.gif" alt="สีชมพู" width="18" height="17" border=0></a> 
																			<a href="javascript:setColor('gray','เทา')"><img src="../WebboardMgt/pic/graycolor.gif" alt="สีเทา" width="18" height="17" border=0></a> &nbsp;&nbsp;&nbsp;
                    <!--<input type="button" name="Button2" value="แสดง icon" onClick="document.getElementById('icon').style.display='';">
                  &nbsp;
                  <input type="button" name="Button2" value="ปิด icon" onClick="document.getElementById('icon').style.display='none';">style="display:none "--></td>
              </tr>
              <tr id="icon" >
                <td align=center colspan=2 bgcolor="#FFFFFF"><nobody><?php
						$i=1;
						$sql_emotion = "select * from emotion";
						$query_emotion = $db->query($sql_emotion);
						while($rec_emotion = $db->db_fetch_array($query_emotion)){
						echo "&nbsp;&nbsp;<a href=\"javascript:setsmile('".$rec_emotion[emotion_character]."')\"><img src=\"".$rec_emotion[emotion_img]."\" border=0 ></a>&nbsp;&nbsp;";
						if($i=='10'){
						echo "<br>";
						$i=0;
						}
						$i++;
						}
						?><!--<a href="javascript:setsmile(':angry:')"><img src="pic/angry.gif" border=0 width="15" height="15"></a> 
																								<a href="javascript:setsmile(':sad:')"><img src="pic/frown.gif" border=0></a> 
																								<a href="javascript:setsmile(':red:')"><img src="pic/redface.gif" border=0></a> 
																								<a href="javascript:setsmile(':big:')"><img src="pic/biggrin.gif" border=0></a> 
																								<a href="javascript:setsmile(':ent:')"><img src="pic/blue.gif" border=0></a>
																								 <a href="javascript:setsmile(':shy:')"><img src="pic/shy.gif" border=0></a> 
																								 <a href="javascript:setsmile(':sleepy:')"><img src="pic/sleepy.gif" border=0></a> 
																								 <a href="javascript:setsmile(':sun:')"><img src="pic/sunglasses.gif" border=0></a> 
																								 <a href="javascript:setsmile(':sg:')"><img src="pic/supergrin.gif" border=0></a> 
																								 <a href="javascript:setsmile(':embarass:')"><img src="pic/embarass.gif" border=0></a> 
																								 <a href="javascript:setsmile(':dead:')"><img src="pic/dead.gif" border=0></a> 
																								 <a href="javascript:setsmile(':cool:')"><img src="pic/cool.gif" border=0></a> 
																								 <a href="javascript:setsmile(':clown:')"><img src="pic/clown.gif" border=0></a> 
																								 <a href="javascript:setsmile(':pukey:')"><img src="pic/pukey.gif" border=0></a> 
																								 <a href="javascript:setsmile(':eek:')"><img src="pic/eek.gif" border=0></a> 
																								 <a href="javascript:setsmile(':roll:')"><img src="pic/sarcblink.gif" border=0></a> 
																								 <a href="javascript:setsmile(':smoke:')"><img src="pic/smokin.gif" border=0></a> 
																								 <a href="javascript:setsmile(':angry:')"><img src="pic/reallymad.gif" border=0></a> 
																								 <a href="javascript:setsmile(':confused:')"><img src="pic/confused.gif" border=0></a> 
																								 <a href="javascript:setsmile(':cry:')"><img src="pic/crying.gif" border=0></a> 
																								 <a href="javascript:setsmile(':lol:')"><img src="pic/lol.gif" border=0></a> 
																								 <a href="javascript:setsmile(':yawn:')"><img src="pic/yawn.gif" border=0></a> 
																								 <a href="javascript:setsmile(':devil:')"><img src="pic/devil.gif" border=0></a> 
																								 <a href="javascript:setsmile(':brain:')"><img src="pic/brain.gif" border=0></a> 
																								 <a href="javascript:setsmile(':phone:')"><img src="pic/phone.gif" border=0></a> 
																								 <a href="javascript:setsmile(':zip:')"><img src="pic/zip.gif" border=0 width="14" height="14"></a><br>
                    																			<a href="javascript:setsmile(':tongue:')"><img src="pic/tongue.gif" border=0></a> 
																								<a href="javascript:setsmile(':alien:')"><img src="pic/aysmile.gif" border=0></a> 
																								<a href="javascript:setsmile(':tasty:')"><img src="pic/tasty.gif" border=0></a> 
																								<a href="javascript:setsmile(':agree:')"><img src="pic/agree.gif" border=0></a> 
																								<a href="javascript:setsmile(':disagree:')"><img src="pic/disagree.gif" border=0></a>
																								<a href="javascript:setsmile(':bawling:')"><img src="pic/bawling.gif" border=0></a> 
																								<a href="javascript:setsmile(':crap:')"><img src="pic/crap.gif" border=0></a> 
																								<a href="javascript:setsmile(':crying1:')"><img src="pic/crying1.gif" border=0></a> 
																								<a href="javascript:setsmile(':dunce:')"><img src="pic/dunce.gif" border=0></a> 
																								<a href="javascript:setsmile(':error:')"><img src="pic/error.gif" border=0></a> 
																								<a href="javascript:setsmile(':evil:')"><img src="pic/evil.gif" border=0></a> 
																								<a href="javascript:setsmile(':lookaroundb:')"><img src="pic/lookaroundb.gif" border=0></a> 
																								<a href="javascript:setsmile(':laugh:')"><img src="pic/laugh.gif" border=0></a> 
																								<a href="javascript:setsmile(':pimp:')"><img src="pic/pimp.gif" border=0></a> 
																								<a href="javascript:setsmile(':spiny:')"><img src="pic/spiny.gif" border=0></a> 
																								<a href="javascript:setsmile(':wavey:')"><img src="pic/wavey.gif" border=0></a> 
																								<a href="javascript:setsmile(':smash:')"><img src="pic/smash.gif" border=0></a> 
																								<a href="javascript:setsmile(':crazy:')"><img src="pic/grazy.gif" border=0></a>
																								 <a href="javascript:setsmile(':download:')"><img src="pic/download.gif" border=0></a> 
																								 <a href="javascript:setsmile(':cranium:')"><img src="pic/cranium.gif" border=0></a> 
																								 <a href="javascript:setsmile(':censore:')"><img src="pic/censore.gif" border=0></a> 
																								 <a href="javascript:setsmile(':nolove:')"><img src="pic/nolove.gif" border=0></a> 
																								 <a href="javascript:setsmile(':beer:')"><img src="pic/beer.gif" border=0></a>--> <br>
                    <font color="blue">คลิกที่รูป เพื่อแทรกรูปลงในข้อความ</font></nobody></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="2%" height="25" valign="bottom">&nbsp;</td>
                <td width="94%" align="center"><b><font color="#FFFFFF" class=size3>
                  <input type=submit value='ส่งหัวข้อกระทู้' name="Submit" >
&nbsp;
<input type=reset value='เคลียร์' name="reset">
<input name="flag" type="hidden" id="flag" value="question">
<input name="wcad" type="hidden" id="wcad" value="<?php echo $wcad; ?>">
                </font></b></td>
                <td width="4%" align="right" valign="bottom">&nbsp;</td>
              </tr>
          </table></td>
        </tr>
      </table>
        </form>
	</p>
</DIV></td>
  </tr>
</table>
      </td>
    </tr>
    <tr valign="top">
      <td colspan="2"><?php @include("com_bottom.php"); ?></td>
    </tr>
  </table>
  <iframe name="save_function_form" src=""  frameborder="0"  width="500" height="500" scrolling="no" ></iframe>
</div>
</body>
</html>
<script language="JavaScript">
function CHK(){
if(document.myForm.aque.value == ""){
alert("กรุณาใส่หัวข้อกระทู้");
document.myForm.aque.focus();
return false;
}
if(document.myForm.amsg.value == ""){
alert("กรุณาใส่หัวข้อรายละเอียด");
document.myForm.amsg.focus();
return false;
}
if(document.myForm.aname.value == ""){
alert("กรุณาใส่ชื่อ");
document.myForm.aname.focus();
return false;
}
if(document.myForm.aname.value == ""){
alert("กรุณาใส่ชื่อ");
document.myForm.aname.focus();
return false;
}
}
</script>
<script language="JavaScript">
	function setURL()
	{
		var temp = window.prompt('ใส่ URL ที่คุณต้องการสร้างเป็นลิงค์','http://'); 
		if(temp) setsmile('[url]'+temp+'[/url]');
	}
	
	function setImage()
	{
		var temp = window.prompt('ใส่ URL ของรูปที่คุณต้องการให้แสดงในกระทู้ของคุณ','http://'); 
		if(temp) setsmile('[img]'+temp+'[/img]');
	}
	
	function setBold()
	{
		var temp = window.prompt('ใส่ข้อความที่คุณต้องการทำเป็นตัวหนา',''); 
		if(temp) setsmile('[b]'+temp+'[/b]');
	}
	
	function setItalic()
	{
		var temp = window.prompt('ใส่ข้อความที่คุณต้องการทำเป็นตัวเอียง',''); 
		if(temp) setsmile('[i]'+temp+'[/i]');
	}
	
	function setUnderline()
	{
		var temp = window.prompt('ใส่ข้อความที่คุณต้องการให้มีเส้นใต้',''); 
		if(temp) setsmile('[u]'+temp+'[/u]');
	}
	
	function setColor(color,name)
	{
		var temp = window.prompt('ใส่ข้อความที่คุณต้องการให้เป็น สี'+name,''); 
		if(temp) setsmile('[color='+color+']'+temp+'[/color]');
	}
	
	function setsmile(what)
	{
		document.myForm.amsg.value = document.myForm.elements.amsg.value+" "+what;
		document.myForm.amsg.focus();
	} 
	
   function chkValid (f) { 
	   if (isBlank(f.aque.value)){
			  alert ('กรุณากรอก"หัวข้อ" ');
			  f.aque.focus ();
			  return false;
	   }
	   
	   if (isBlank(f.amsg.value)){
			  alert ('กรุณากรอก "รายละเอียด" ');
			  f.amsg.focus ();
			  return false;
	   }
	
	   if (isBlank(f.aname.value)){
			  alert ('กรุณากรอก"ชื่อผู้ตั้งคำถาม" ');
			  f.aname.focus ();
			  return false;
	   }
	   f.submit ();
	}
</script>
<?php @$db->db_close(); ?>